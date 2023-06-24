#!/bin/bash

# Obtiene la ruta absoluta del directorio actual
CURRENT_DIR=$(cd "$(dirname "$0")" && pwd)

# Ruta al directorio 'api' relativa al directorio actual
API_DIR="$CURRENT_DIR/../api"

# Navega al directorio 'api'
cd "$API_DIR" || exit

# Ejecuta el comando para iniciar el servidor PHP
php -S 127.0.0.1:8000