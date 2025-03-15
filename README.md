# API Spotify con Laravel 12 y Sanctum

## Descripción
Este proyecto provee un endpoint para obtener información de artistas desde la API de Spotify, además de un sistema de autenticación con Laravel Sanctum.

---

## Requisitos
- **PHP 8.2 o superior**
- **Composer** instalado
- **MySQL** u otra base de datos soportada

---

## Configuración
1. **Clona el repositorio**:
   ```bash
   git clone https://github.com/raziel2019/ApiSpotify
   cd ApiSpotify
   ```

2. **Instala dependencias**:
   ```bash
   composer install
   ```

3. **Copia el archivo de entorno**:
   ```bash
   cp .env.example .env
   ```

4. **Configura tu base de datos** en `.env`:
   ```ini
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laravel
   DB_USERNAME=root
   DB_PASSWORD=
   ```
5. **Agrega tus credenciales de Spotify** en `.env`:
   ```ini
   SPOTIFY_CLIENT_ID=tu_client_id
   SPOTIFY_CLIENT_SECRET=tu_client_secret
   ```

6. **Genera la clave de la aplicación**:
   ```bash
   php artisan key:generate
   ```

7. **Ejecuta las migraciones**:
   ```bash
   php artisan migrate
   ```

---

## Uso

### 1. Iniciar el servidor
```bash
php artisan serve
```
Accede a: `http://127.0.0.1:8000`

### 2. Registrar un usuario
- **Endpoint**: `POST /api/register`
- **Body (JSON)**:
```json
{
   "name": "Test User",
   "email": "test@example.com",
   "password": "password123"
}
```
- **Respuesta**:
```json
{
  "message": "Usuario registrado correctamente",
  "user": {
    "id": 1,
    "name": "Test User",
    "email": "test@example.com"
  },
  "token": "..."
}
```

### 3. Iniciar sesión
- **Endpoint**: `POST /api/login`
- **Body (JSON)**:
```json
{
   "email": "test@example.com",
   "password": "password123"
}
```
- **Respuesta**:
```json
{
  "message": "Inicio de sesión exitoso",
  "user": {
    "id": 1,
    "name": "Test User",
    "email": "test@example.com"
  },
  "token": "..."
}
```

### 4. Consumir el endpoint de Spotify
- **Endpoint**: `GET /api/spotify/artist?artist=Coldplay`
- **Headers**:
  ```
  Authorization: Bearer TU_TOKEN_AQUI
  Accept: application/json
  ```
- **Respuesta**:
```json
{
  "artists": {
    "items": [
      {
        "name": "Coldplay",
        ...
      }
    ]
  }
}
```

### 5. Cerrar sesión
- **Endpoint**: `POST /api/logout`
- **Headers**:
  ```
  Authorization: Bearer TU_TOKEN_AQUI
  Accept: application/json
  ```
- **Respuesta**:
```json
{
   "message": "Sesión cerrada"
}
```