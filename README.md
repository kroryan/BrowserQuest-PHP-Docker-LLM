# BrowserQuest-PHP Docker with Ollama Integration

![BrowserQuest width workerman](https://github.com/kroryan/BrowserQuest-PHP-Docker-LLM/blob/main/Web/img/screenshot.jpg?raw=true)
![BrowserQuest width workerman](https://github.com/kroryan/BrowserQuest-PHP-Docker-LLM/blob/main/Web/img/screenshot1.jpg?raw=true)


BrowserQuest-PHP is a multiplayer online game based on Mozilla's BrowserQuest, with the backend rewritten in PHP using the Workerman framework. This repository provides a Dockerized setup for easy deployment and management, now with dynamic NPC dialogues powered by Ollama.

---

## Features

- Fully Dockerized for simple deployment
- Configurable WebSocket host and port
- Persistent configuration for development and production
- Multilingual support with enhanced language selector
- Multilingual instructions (English and Spanish)
- **NEW: AI-powered NPC dialogues** using Ollama
- **NEW: Dynamic, contextual NPC responses** based on player equipment and status
- **NEW: Multilingual AI responses** that match the game's selected language

---

## Requirements

- Docker
- Docker Compose
- Ollama (for AI-powered NPC dialogues)

---

## Getting Started

### 1. Clone the Repository

```bash
git clone https://github.com/your-repo/BrowserQuest-PHP.git
cd BrowserQuest-PHP
```

### 2. Configure the Docker Environment

Edit the `docker-compose.yml` file to set the `HOST_ADDRESS` environment variable. This variable determines the WebSocket server's address that the client will connect to.

#### Examples:

- **Localhost (same machine):**
  ```yaml
  environment:
    - HOST_ADDRESS=localhost
  ```

- **Local network (accessible from other devices):**
  ```yaml
  environment:
    - HOST_ADDRESS=192.168.1.100
  ```

- **Public domain:**
  ```yaml
  environment:
    - HOST_ADDRESS=yourdomain.com
  ```

### 3. Build the Docker Image

Run the following command to build the Docker image:

```bash
docker-compose build
```

### 4. Start the Server

Start the server in detached mode:

```bash
docker-compose up -d
```

### 5. Access the Game

Open your browser and navigate to:

- **Frontend:** [http://localhost:8787](http://localhost:8787)
- **WebSocket:** `ws://localhost:8000`

Replace `localhost` with the IP or domain you configured in `HOST_ADDRESS`.

---

## Recent Updates

### Enhanced Language Support

The game now features a dramatically improved language selection system:

- **Large, prominent language buttons** on the initial screen for easy language selection
- **Persistent language settings** saved to the browser's local storage
- **On-the-fly translation** without page reload
- **Automatic language detection** based on browser settings
- **Visual indicators** showing the currently active language
- **Small language toggle** available at all times in the top corner

Currently supported languages:
- English
- Spanish

---

## Ollama Integration for Dynamic NPC Dialogues

This version of BrowserQuest-PHP includes integration with [Ollama](https://ollama.ai/), allowing NPCs to generate dynamic, contextual responses using AI language models.

### How It Works

- NPCs now generate unique responses based on their character type and player context
- Responses adapt to player's equipment, health status, and other game factors
- The system supports multiple languages (currently English and Spanish)
- Responses are more varied, natural, and immersive than static dialogue

### Setup Ollama

1. **Install Ollama**

   Follow the installation instructions at [ollama.ai](https://ollama.ai/) for your operating system.

2. **Pull the Recommended Model**

   Pull the following model or another model of your choice:
   ```bash
   ollama pull hf.co/soob3123/amoral-gemma3-1B-v2-gguf:Q8_0
   ```

3. **Configure Ollama in BrowserQuest**

   Edit the Ollama configuration file at `Server/Config/ollama.php` to change settings:

   ```php
   // Change the Ollama API URL if needed (default works with Docker)
   'api_base' => 'http://host.docker.internal:11434',
   
   // Change the model name if you prefer to use a different model
   'model' => 'hf.co/soob3123/amoral-gemma3-1B-v2-gguf:Q8_0',
   ```

### Interacting with NPCs

When you talk to NPCs in the game, the system will use Ollama to generate dynamic responses. Here are some tips:

- **For varied responses**: When interacting with an NPC, clicking repeatedly will generate different responses (sometimes it may take 2-3 clicks to see changes - we're working on improving this)
- **Contextual dialogues**: NPCs will recognize your character's equipment, health status, and respond accordingly
- **Language matching**: Responses will be in the same language you've selected for the game interface

### Fallback Mechanism

If Ollama is not available or encounters an error, the system will automatically fall back to the original static dialogues. This ensures the game remains playable even if the AI service is down.

### Customizing NPC Personalities

You can customize how NPCs respond by editing the context templates in `Server/Config/ollama.php`. Each NPC type has different personality traits and knowledge that influence their responses.

---

## Managing the Docker Container

### View Logs

To monitor the server logs:

```bash
docker-compose logs -f
```

### Stop the Server

To stop and remove the container:

```bash
docker-compose down
```

---

## Troubleshooting

### "Could not connect to server" Error

If you see this error after creating a character, it means the client cannot connect to the WebSocket server. Ensure the following:

1. The `HOST_ADDRESS` in `docker-compose.yml` is correctly set to the IP or domain accessible from the client.
2. The WebSocket port (default: 8000) is open and accessible.
3. Check the logs for any errors:
   ```bash
   docker-compose logs
   ```

---

## Advanced Configuration

### Changing Ports

You can change the external ports by modifying the `ports` section in `docker-compose.yml`:

```yaml
ports:
  - "9000:8000"  # WebSocket port
  - "8080:8787"  # HTTP port
```

### Persistent Configuration

The `Web/config` directory is mounted as a volume in the container. Any changes made to the configuration files will persist across container restarts.

---

## Español: Instrucciones de Uso

### Requisitos

- Docker
- Docker Compose
- Ollama (para los diálogos de NPCs generados por IA)

### Pasos para Iniciar

1. **Clonar el Repositorio**

   ```bash
   git clone https://github.com/your-repo/BrowserQuest-PHP.git
   cd BrowserQuest-PHP
   ```

2. **Configurar el Entorno Docker**

   Edita el archivo `docker-compose.yml` y establece la variable `HOST_ADDRESS` con la dirección IP o dominio del servidor.

   #### Ejemplos:

   - **Localhost (misma máquina):**
     ```yaml
     environment:
       - HOST_ADDRESS=localhost
     ```

   - **Red local (accesible desde otros dispositivos):**
     ```yaml
     environment:
       - HOST_ADDRESS=192.168.1.100
     ```

   - **Dominio público:**
     ```yaml
     environment:
       - HOST_ADDRESS=tu-dominio.com
     ```

3. **Construir la Imagen Docker**

   ```bash
   docker-compose build
   ```

4. **Iniciar el Servidor**

   ```bash
   docker-compose up -d
   ```

5. **Acceder al Juego**

   Abre tu navegador y visita:

   - **Frontend:** [http://localhost:8787](http://localhost:8787)
   - **WebSocket:** `ws://localhost:8000`

   Reemplaza `localhost` con la IP o dominio configurado en `HOST_ADDRESS`.

---

## Integración con Ollama para Diálogos Dinámicos de NPCs

Esta versión de BrowserQuest-PHP incluye integración con [Ollama](https://ollama.ai/), permitiendo que los NPCs generen respuestas dinámicas y contextuales utilizando modelos de lenguaje de IA.

### Cómo Funciona

- Los NPCs ahora generan respuestas únicas basadas en su tipo de personaje y el contexto del jugador
- Las respuestas se adaptan al equipamiento del jugador, estado de salud y otros factores del juego
- El sistema soporta múltiples idiomas (actualmente inglés y español)
- Las respuestas son más variadas, naturales e inmersivas que los diálogos estáticos

### Configuración de Ollama

1. **Instalar Ollama**

   Sigue las instrucciones de instalación en [ollama.ai](https://ollama.ai/) para tu sistema operativo.

2. **Descargar el Modelo Recomendado**

   Descarga el siguiente modelo o cualquier otro modelo de tu elección:
   ```bash
   ollama pull hf.co/soob3123/amoral-gemma3-1B-v2-gguf:Q8_0
   ```

3. **Configurar Ollama en BrowserQuest**

   Edita el archivo de configuración de Ollama en `Server/Config/ollama.php` para cambiar la configuración:

   ```php
   // Cambia la URL de la API de Ollama si es necesario (el valor predeterminado funciona con Docker)
   'api_base' => 'http://host.docker.internal:11434',
   
   // Cambia el nombre del modelo si prefieres usar un modelo diferente
   'model' => 'hf.co/soob3123/amoral-gemma3-1B-v2-gguf:Q8_0',
   ```

### Interactuando con NPCs

Cuando hablas con NPCs en el juego, el sistema utilizará Ollama para generar respuestas dinámicas. Aquí algunos consejos:

- **Para respuestas variadas**: Al interactuar con un NPC, hacer clic repetidamente generará respuestas diferentes (a veces puede tomar 2-3 clics para ver cambios - estamos trabajando para mejorar esto)
- **Diálogos contextuales**: Los NPCs reconocerán el equipamiento de tu personaje, estado de salud y responderán en consecuencia
- **Coincidencia de idioma**: Las respuestas estarán en el mismo idioma que hayas seleccionado para la interfaz del juego

### Mecanismo de Respaldo

Si Ollama no está disponible o encuentra un error, el sistema automáticamente utilizará los diálogos estáticos originales. Esto asegura que el juego permanezca jugable incluso si el servicio de IA no está funcionando.

### Personalización de las Personalidades de los NPCs

Puedes personalizar cómo responden los NPCs editando las plantillas de contexto en `Server/Config/ollama.php`. Cada tipo de NPC tiene diferentes rasgos de personalidad y conocimientos que influyen en sus respuestas.

---

### Sistema de Idiomas Mejorado

El juego ahora cuenta con un sistema de selección de idiomas considerablemente mejorado:

- **Botones de idioma grandes y destacados** en la pantalla inicial para facilitar la selección
- **Configuración de idioma persistente** guardada en el almacenamiento local del navegador
- **Traducción instantánea** sin necesidad de recargar la página
- **Detección automática del idioma** basada en la configuración del navegador
- **Indicadores visuales** que muestran el idioma actualmente activo
- **Selector de idioma pequeño** disponible en todo momento en la esquina superior

Idiomas actualmente soportados:
- Inglés
- Español

---

### Solución de Problemas

#### Error: "Could not connect to server"

Si ves este error después de crear un personaje, verifica lo siguiente:

1. La variable `HOST_ADDRESS` en `docker-compose.yml` está configurada correctamente.
2. El puerto WebSocket (por defecto: 8000) está abierto y accesible.
3. Revisa los logs para identificar errores:
   ```bash
   docker-compose logs
   ```

---

### Detener el Servidor

Para detener y eliminar el contenedor:

```bash
docker-compose down
```
