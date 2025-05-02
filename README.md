# BrowserQuest-PHP Docker

![BrowserQuest width workerman](https://github.com/walkor/BrowserQuest-PHP/blob/master/Web/img/screenshot.jpg?raw=true)


BrowserQuest-PHP is a multiplayer online game based on Mozilla's BrowserQuest, with the backend rewritten in PHP using the Workerman framework. This repository provides a Dockerized setup for easy deployment and management.

---

## Features

- Fully Dockerized for simple deployment
- Configurable WebSocket host and port
- Persistent configuration for development and production
- Multilingual support with enhanced language selector
- Multilingual instructions (English and Spanish)

---

## Requirements

- Docker
- Docker Compose

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

## Actualizaciones Recientes

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
