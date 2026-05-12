#!/bin/bash
# =============================================================
# AquaSense AI — Setup inicial en servidor
# Ejecutar UNA SOLA VEZ antes de configurar GitHub Actions
# =============================================================

set -e

REPO_URL="$1"   # Ej: https://github.com/tu-usuario/aquasense-repo.git
TARGET="/var/www/aquasense"

if [ -z "$REPO_URL" ]; then
  echo "Uso: ./setup-server.sh https://github.com/tu-usuario/aquasense-repo.git"
  exit 1
fi

echo ""
echo "════════════════════════════════════════"
echo "   AquaSense AI — Setup del servidor"
echo "════════════════════════════════════════"
echo ""

# 1. Crear directorio
echo "[1/5] Creando directorio..."
sudo mkdir -p $TARGET
sudo chown -R $USER:$USER $TARGET

# 2. Clonar repositorio
echo "[2/5] Clonando repositorio..."
git clone "$REPO_URL" $TARGET

# 3. Configurar Nginx
echo "[3/5] Configurando Nginx..."
sudo cp $TARGET/config/nginx.conf /etc/nginx/sites-available/aquasense

# Eliminar default si existe para evitar conflicto
if [ -f /etc/nginx/sites-enabled/default ]; then
  sudo rm /etc/nginx/sites-enabled/default
fi

# Activar solo si no existe ya
if [ ! -f /etc/nginx/sites-enabled/aquasense ]; then
  sudo ln -s /etc/nginx/sites-available/aquasense /etc/nginx/sites-enabled/aquasense
fi

sudo nginx -t
sudo nginx -s reload

# 4. Permisos
echo "[4/5] Ajustando permisos..."
sudo chown -R www-data:www-data $TARGET
sudo chmod -R 755 $TARGET

# 5. Abrir firewall si ufw activo
echo "[5/5] Verificando firewall..."
if sudo ufw status | grep -q "active"; then
  sudo ufw allow 80/tcp
  echo "     Puerto 80 abierto"
fi

echo ""
echo "════════════════════════════════════════"
echo "   ✓ Setup completado"
echo "════════════════════════════════════════"
IP=$(curl -s -4 ifconfig.me)
echo ""
echo "   Accede en: http://$IP"
echo ""
echo "   Próximo paso: configurar GitHub Actions"
echo "   Ver README.md → sección Deploy automático"
echo ""
