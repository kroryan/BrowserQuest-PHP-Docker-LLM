<?php
/**
 * Servicio para interactuar con la API de Ollama
 * Este servicio permite generar respuestas dinámicas para los NPCs del juego
 */
namespace Server;

class OllamaService
{
    /**
     * @var array Configuración de Ollama
     */
    private $config;
    
    /**
     * @var string URL base de la API de Ollama
     */
    private $apiBase;
    
    /**
     * @var string Modelo a utilizar
     */
    private $model;
    
    /**
     * @var array Parámetros de generación
     */
    private $parameters;
    
    /**
     * @var array Contextos predefinidos para NPCs
     */
    private $npcContexts;
    
    /**
     * @var array Caché de respuestas para optimizar rendimiento
     * Estructura: [npcType][playerName][conversationId] => respuesta
     */
    private $responseCache = [];
    
    /**
     * @var bool Estado de disponibilidad de Ollama
     */
    private $available = false;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        // Cargar configuración
        $configPath = __DIR__ . '/Config/ollama.php';
        if (!file_exists($configPath)) {
            $this->logMessage('Error: El archivo de configuración de Ollama no existe en: ' . $configPath);
            return;
        }
        
        try {
            $this->config = require($configPath);
            $this->apiBase = $this->config['api_base'];
            $this->model = $this->config['model'];
            $this->parameters = $this->config['parameters'];
            $this->npcContexts = $this->config['npc_contexts'];
            
            // Verificar disponibilidad de Ollama
            $this->checkAvailability();
        } catch (\Exception $e) {
            $this->logMessage('Error al inicializar OllamaService: ' . $e->getMessage());
        }
    }
    
    /**
     * Registra un mensaje en el log del servidor
     * 
     * @param string $message Mensaje a registrar
     */
    private function logMessage($message)
    {
        echo '[OllamaService] ' . date('Y-m-d H:i:s') . ' - ' . $message . PHP_EOL;
    }
    
    /**
     * Verifica si Ollama está disponible
     * 
     * @return bool Si Ollama está disponible
     */
    public function isAvailable()
    {
        return $this->available;
    }
    
    /**
     * Verifica la disponibilidad del servicio y registra error si no está disponible
     */
    private function checkAvailability()
    {
        try {
            $response = $this->makeRequest('GET', '/api/tags');
            if ($response) {
                $this->available = true;
                $this->logMessage('Ollama está disponible y listo para generar diálogos. Modelo configurado: ' . $this->model);
                return true;
            }
        } catch (\Exception $e) {
            $this->logMessage('Error al verificar disponibilidad de Ollama: ' . $e->getMessage());
        }
        
        $this->available = false;
        $this->logMessage('Advertencia: Ollama no está disponible. Se usarán respuestas estáticas para los NPCs.');
        return false;
    }
    
    /**
     * Genera una respuesta para un NPC usando Ollama, evitando repeticiones
     * 
     * @param string $npcType Tipo de NPC (ej: guard, king, etc.)
     * @param string $playerName Nombre del jugador
     * @param string $playerContext Contexto adicional sobre el jugador
     * @param int|string $conversationId ID único para esta conversación
     * @param string $language Idioma para la respuesta (en, es)
     * @return string|null Respuesta generada o null si no se pudo generar
     */
    public function generateNpcResponse($npcType, $playerName, $playerContext = '', $conversationId = 0, $language = 'en')
    {
        // Si el servicio no está disponible, retornar null
        if (!$this->isAvailable()) {
            return null;
        }
        
        // Añadir una parte aleatoria a cada solicitud para evitar respuestas repetidas
        $randomSeed = mt_rand(1000, 9999);
        
        // Si no hay ID de conversación, generar uno único
        if ($conversationId === 0) {
            $conversationId = uniqid($npcType . '_', true);
        }
        
        // Crear un identificador único para esta interacción específica
        $uniqueInteractionId = $npcType . '_' . $playerName . '_' . $randomSeed;
        
        // Obtener contextos para este tipo de NPC
        $npcContextData = isset($this->npcContexts[$npcType]) 
            ? $this->npcContexts[$npcType] 
            : $this->npcContexts['default'];
            
        // Si es un array, seleccionar un contexto aleatorio para más variedad
        $npcContext = is_array($npcContextData) 
            ? $npcContextData[array_rand($npcContextData)] 
            : $npcContextData;
        
        // Construir el prompt para Ollama, incluyendo el idioma
        $prompt = $this->buildPrompt($npcContext, $playerName, $playerContext, $language);
        
        try {
            // Configurar parámetros para asegurar variedad
            $temperature = $this->parameters['temperature'];
            
            // Aumentar ligeramente la aleatoriedad para este pedido específico
            $temperature += (0.1 * (mt_rand(0, 10) / 10));
            
            // Asegurar que la temperatura esté en rango razonable
            $temperature = min(max($temperature, 0.6), 0.9);
            
            // Configurar la solicitud con seed aleatorio
            $data = [
                'model' => $this->model,
                'prompt' => $prompt,
                'stream' => false,
                'options' => array_merge(
                    $this->parameters, 
                    [
                        'temperature' => $temperature,
                        'seed' => mt_rand(1, 999999) // Seed aleatorio para cada generación
                    ]
                )
            ];
            
            // Realizar solicitud a la API
            $this->logMessage('Generando respuesta para NPC tipo: ' . $npcType . ' (Idioma: ' . $language . ', Seed: ' . $randomSeed . ')');
            $response = $this->makeRequest('POST', '/api/generate', $data);
            
            if (isset($response['response'])) {
                // Procesar y limpiar la respuesta
                $dialog = $this->processResponse($response['response']);
                return $dialog;
            }
        } catch (\Exception $e) {
            $this->logMessage('Error al generar respuesta con Ollama: ' . $e->getMessage());
        }
        
        return null;
    }
    
    /**
     * Construye el prompt para enviar a Ollama con mejor contexto del juego
     * 
     * @param string $npcContext Contexto del NPC
     * @param string $playerName Nombre del jugador
     * @param string $playerContext Contexto adicional sobre el jugador
     * @param string $language Idioma para la respuesta (en, es)
     * @return string Prompt completo
     */
    private function buildPrompt($npcContext, $playerName, $playerContext, $language = 'en')
    {
        // Force lowercase for reliable language comparison
        $language = strtolower(trim($language));
        
        // Base del prompt en inglés por defecto
        $gameContext = "You are in a medieval fantasy RPG game called BrowserQuest. The game is set in a world with monsters, villages, forests, deserts, and dungeons. Players are adventurers who explore the world, fight monsters, and seek treasures.";
        $roleInstruction = "You are an NPC (non-player character) in this world. " . $npcContext;
        $playerInfo = "An adventurer named $playerName approaches you. " . ($playerContext ? "$playerContext " : "");
        $responseGuidance = "Respond as your character would, briefly (maximum 2 sentences) and in first person. Your response should be contextual, interesting and immersive, reflecting your character's personality and the fantasy world you live in. Don't use quotes or narrate your actions, simply respond with what you would say.";
        
        // Si el idioma es español, traducir el prompt
        if ($language === 'es') {
            $gameContext = "Estás en un juego RPG medieval de fantasía llamado BrowserQuest. El juego está ambientado en un mundo con monstruos, aldeas, bosques, desiertos y mazmorras. Los jugadores son aventureros que exploran el mundo, luchan contra monstruos y buscan tesoros.";
            $roleInstruction = "Eres un NPC (personaje no jugador) en este mundo. " . $npcContext;
            $playerInfo = "Un aventurero llamado $playerName se acerca a ti. " . ($playerContext ? "$playerContext " : "");
            $responseGuidance = "Responde como lo haría tu personaje, de forma breve (máximo 2 frases) y en primera persona. Tu respuesta debe ser contextual, interesante e inmersiva, reflejando la personalidad de tu personaje y el mundo de fantasía en el que vives. No uses comillas ni narres tus acciones, simplemente responde con lo que dirías.";
        }
        
        // Añadir instrucción explícita sobre el idioma - make this very clear and emphatic
        $languageInstruction = ($language === 'es') 
            ? "IMPORTANTE: DEBES RESPONDER COMPLETAMENTE EN ESPAÑOL. NO RESPONDAS EN INGLÉS BAJO NINGUNA CIRCUNSTANCIA." 
            : "IMPORTANT: YOU MUST RESPOND COMPLETELY IN ENGLISH. DO NOT RESPOND IN SPANISH UNDER ANY CIRCUMSTANCES.";
        
        // Log the language being used for debugging
        $this->logMessage("Building prompt with language: " . $language);
        
        // Construir el prompt completo
        return $gameContext . "\n\n" . 
               $roleInstruction . "\n\n" . 
               $playerInfo . "\n" . 
               $responseGuidance . "\n\n" . 
               $languageInstruction;
    }
    
    /**
     * Procesa y limpia la respuesta de Ollama
     * 
     * @param string $response Respuesta cruda de Ollama
     * @return string Respuesta procesada
     */
    private function processResponse($response)
    {
        // Eliminar comillas si están presentes al inicio y final
        $response = trim($response, '"');
        
        // Eliminar dobles comillas escapadas
        $response = str_replace('\"', '"', $response);
        
        // Eliminar prefijos comunes que los modelos tienden a generar
        $prefixes = [
            "NPC:", 
            "[NPC]:", 
            "Yo:", 
            "*", 
            "- ", 
            "\"", 
            "'",
            "Guardia:",
            "Rey:",
            "Aldeano:",
            "Aldeana:",
            "Sacerdote:",
            "Científico:",
            "Mago:",
            "Villager:",
            "Guard:",
            "King:",
            "Priest:",
            "Sorcerer:",
            "Hechicero:",
            "(Respondiendo a",
            "[Respondiendo]"
        ];
        
        foreach ($prefixes as $prefix) {
            if (strpos($response, $prefix) === 0) {
                $response = substr($response, strlen($prefix));
                $response = trim($response);
            }
        }
        
        // Eliminar sufijos comunes
        $suffixes = ["\"", "'", "*"];
        foreach ($suffixes as $suffix) {
            if (substr($response, -strlen($suffix)) === $suffix) {
                $response = substr($response, 0, -strlen($suffix));
                $response = trim($response);
            }
        }
        
        // Eliminar frases que indiquen diálogo o narración
        $response = preg_replace('/^(dice:|responde:|exclama:|murmura:|suspira:|grita:|pregunta:)\s*/i', '', $response);
        
        // Eliminar descripciones de acciones entre paréntesis
        $response = preg_replace('/\([^)]*\)/', '', $response);
        
        // Asegurar que la primera letra esté en mayúscula
        if (strlen($response) > 0) {
            $response = ucfirst($response);
        }
        
        // Limitar longitud para evitar burbujas de diálogo demasiado grandes
        if (strlen($response) > 150) {
            $response = substr($response, 0, 147) . '...';
        }
        
        return $response;
    }
    
    /**
     * Realiza una solicitud HTTP a la API de Ollama
     * 
     * @param string $method Método HTTP (GET, POST)
     * @param string $endpoint Endpoint de la API
     * @param array $data Datos a enviar (para POST)
     * @return array Respuesta decodificada
     * @throws \Exception Si ocurre un error en la solicitud
     */
    private function makeRequest($method, $endpoint, $data = null)
    {
        $url = $this->apiBase . $endpoint;
        $options = [
            'http' => [
                'method' => $method,
                'header' => 'Content-Type: application/json',
                'timeout' => 10, // Timeout de 10 segundos para evitar bloqueos
                'ignore_errors' => true
            ]
        ];
        
        if ($data && $method === 'POST') {
            $options['http']['content'] = json_encode($data);
        }
        
        $context = stream_context_create($options);
        $response = @file_get_contents($url, false, $context);
        
        if ($response === false) {
            $error = error_get_last();
            throw new \Exception("Error en la solicitud a Ollama: " . ($error ? $error['message'] : 'Desconocido'));
        }
        
        $decoded = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Error al decodificar la respuesta de Ollama: " . json_last_error_msg());
        }
        
        return $decoded;
    }
}