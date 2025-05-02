#!/bin/bash
set -e

# Obtener la variable de entorno HOST_ADDRESS o usar localhost como predeterminado
HOST_ADDRESS=${HOST_ADDRESS:-"localhost"}
HOST_PORT=${HOST_PORT:-"8000"}

echo "====================================================================="
echo "Configurando BrowserQuest-PHP con host: $HOST_ADDRESS y puerto: $HOST_PORT"
echo "====================================================================="

# Crear o actualizar el archivo de configuración local para el cliente web
echo '{
    "host": "'"$HOST_ADDRESS"'",
    "port": '"$HOST_PORT"'
}' > /app/Web/config/config_local.json

# Ver la configuración generada
echo "Configuración generada en config_local.json:"
cat /app/Web/config/config_local.json

# Iniciar el servidor en modo foreground
echo "Iniciando BrowserQuest-PHP..."
exec php /app/start.php start