# BrowserQuest-PHP Docker

Este es el proyecto BrowserQuest-PHP adaptado para ejecutarse en Docker.

## Requisitos previos

- Docker
- Docker Compose

## Configuración importante

Para que el juego funcione correctamente, es esencial configurar la variable de entorno `HOST_ADDRESS` en el archivo `docker-compose.yml`.

### ⚠️ IMPORTANTE: Configuración del HOST_ADDRESS ⚠️

El problema "Could not connect to server" ocurre cuando el cliente web no puede conectarse al servidor WebSocket.

**La solución requiere establecer `HOST_ADDRESS` correctamente:**

1. Para uso local (mismo equipo):
   - Usa `localhost` si accedes desde el mismo equipo donde se ejecuta Docker
   - Usa la dirección IP local de tu equipo si accedes desde otro dispositivo en la misma red

2. Para uso en red:
   - Usa la dirección IP de la máquina que ejecuta Docker, visible para tus clientes
   - Usa un nombre de dominio si tienes uno configurado

## Pasos para iniciar

1. **Configura el archivo docker-compose.yml**

   Edita la variable `HOST_ADDRESS` en el archivo `docker-compose.yml`:

   ```yaml
   environment:
     - HOST_ADDRESS=tu_ip_o_hostname
     - HOST_PORT=8000
   ```

   Ejemplos:
   - `HOST_ADDRESS=localhost` (para acceso local)
   - `HOST_ADDRESS=192.168.1.100` (para acceso desde la red local)
   - `HOST_ADDRESS=midominio.com` (para acceso con dominio)

2. **Construye la imagen Docker**

   ```bash
   docker-compose build
   ```

3. **Inicia el contenedor**

   ```bash
   docker-compose up -d
   ```

4. **Verifica los logs**

   ```bash
   docker-compose logs
   ```

5. **Accede al juego**

   Abre tu navegador y visita:
   ```
   http://localhost:8787
   ```

## Solución de problemas

Si ves el error "Could not connect to server" después de crear tu personaje:

1. Verifica que la variable `HOST_ADDRESS` esté configurada correctamente
2. Asegúrate de que el puerto 8000 esté accesible desde el cliente
3. Revisa los logs del contenedor para ver si hay errores de conexión

## Detener el servidor

```bash
docker-compose down
```