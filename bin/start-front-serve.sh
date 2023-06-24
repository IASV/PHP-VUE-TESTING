#!/bin/bash

# Obtiene la ruta absoluta del directorio actual
CURRENT_DIR=$(cd "$(dirname "$0")" && pwd)

# Ruta al directorio 'api' relativa al directorio actual
API_DIR="$CURRENT_DIR/../frontend"

# Navega al directorio 'api'
cd "$API_DIR" || exit

# Ejecuta el comando para iniciar el servidor Vite
npm run dev