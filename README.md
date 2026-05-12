# AquaSense AI 🌊

Sistema inteligente de monitoreo y prevención de contaminación del agua basado en el **ODS 6: Agua Limpia y Saneamiento**.

## Descripción

AquaSense AI es un prototipo funcional que simula una red de sensores IoT para monitorear la calidad del agua en tiempo real en distintos puntos de Ecuador. Utiliza tecnología **LoRa** para comunicación de largo alcance y **ESP32** como microcontrolador en los nodos de sensores.

## Tecnologías

| Capa | Tecnología |
|------|-----------|
| Frontend | HTML5 · Tailwind CSS · Chart.js |
| Backend | PHP 8.3 |
| Servidor web | Nginx |
| Deploy | GitHub Actions + SSH |
| Comunicación IoT (simulada) | LoRa · ESP32 |

## Estructura del proyecto

```
aquasense-repo/
├── public/               # Archivos públicos servidos por Nginx
│   ├── index.html        # Dashboard principal
│   ├── css/
│   │   └── style.css     # Estilos globales
│   └── js/
│       └── dashboard.js  # Lógica del frontend
├── api/                  # Backend PHP
│   ├── sensores.php      # Endpoint: datos de sensores simulados
│   ├── alertas.php       # Endpoint: sistema de alertas
│   └── historial.php     # Endpoint: historial 24h
├── config/
│   └── nginx.conf        # Configuración Nginx de referencia
├── .github/
│   └── workflows/
│       └── deploy.yml    # CI/CD: deploy automático al servidor
└── README.md
```

## Instalación en servidor

### Requisitos
- Ubuntu 22.04+
- Nginx instalado
- PHP 8.3-fpm instalado
- Acceso SSH con clave

### Primer deploy manual

```bash
# En el servidor
sudo mkdir -p /var/www/aquasense
sudo chown -R www-data:www-data /var/www/aquasense

# Configurar Nginx (ver config/nginx.conf)
sudo cp config/nginx.conf /etc/nginx/sites-available/aquasense
sudo ln -s /etc/nginx/sites-available/aquasense /etc/nginx/sites-enabled/aquasense
sudo nginx -t && sudo nginx -s reload
```

### Deploy automático (GitHub Actions)

Configurar los siguientes secrets en GitHub → Settings → Secrets and variables → Actions:

| Secret | Valor |
|--------|-------|
| `SSH_HOST` | IP del servidor |
| `SSH_USER` | Usuario SSH (ej: `umpacto-team`) |
| `SSH_PRIVATE_KEY` | Clave privada SSH (contenido de `~/.ssh/id_rsa`) |
| `SSH_PORT` | Puerto SSH (normalmente `22`) |

Con esto, cada `git push` a `main` desplegará automáticamente.

## Parámetros monitoreados

- **pH** — Nivel de acidez/alcalinidad (rango seguro: 6.5–8.5)
- **Temperatura** — En °C
- **Turbidez** — En NTU (rango seguro: 0–25)
- **Oxígeno disuelto** — En mg/L (rango seguro: 5–12)
- **Índice de calidad** — 0–100% (calculado)

## Estados de alerta

| Estado | Condición |
|--------|-----------|
| 🟢 Normal | Todos los parámetros en rango |
| 🟡 Alerta | pH fuera de rango o turbidez > 50 NTU |
| 🔴 Crítico | pH < 5.5 o turbidez > 80 NTU o calidad < 30% |

## Licencia

Prototipo académico — ODS 6 · Ecuador 2025
