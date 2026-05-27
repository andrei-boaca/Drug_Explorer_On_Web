#!/bin/bash
# =============================================================
#  DrugExplorer – Setup automat pe VPS Ubuntu 22.04 / 24.04
#  Rulare: bash setup.sh
# =============================================================
set -euo pipefail

# ── Configurare ───────────────────────────────────────────────
REPO_URL="https://github.com/andrei-boaca/Drug_Explorer_On_Web.git"
BRANCH="main"
APP_DIR="/var/www/drugexplorer"
NGINX_CONF="/etc/nginx/sites-available/drugexplorer"
DB_NAME="statistici_droguri"
DB_USER="web_user"
DOMAIN=""   # lasat gol = acces prin IP

# Parole generate random (salvate la sfarsit)
DB_ROOT_PASS=$(openssl rand -base64 20 | tr -d '+/=')
DB_PASS=$(openssl rand -base64 16 | tr -d '+/=')

echo ""
echo "╔══════════════════════════════════════════╗"
echo "║   DrugExplorer – Setup VPS               ║"
echo "╚══════════════════════════════════════════╝"
echo ""

# ── 1. Citeste GROQ API Key ───────────────────────────────────
read -rp "► Introdu GROQ API Key: " GROQ_KEY
if [[ -z "$GROQ_KEY" ]]; then
    echo "EROARE: GROQ API Key e obligatorie."; exit 1
fi

# ── 2. Actualizare sistem ─────────────────────────────────────
echo ""
echo "[1/7] Actualizare pachete..."
apt-get update -q && apt-get upgrade -yq

# ── 3. Instalare nginx + PHP + MySQL ─────────────────────────
echo "[2/7] Instalare nginx, PHP, MySQL..."
apt-get install -yq nginx mysql-server \
    php8.5-fpm php8.5-mysql php8.5-mbstring php8.5-xml php8.5-curl \
    php8.5-zip php8.5-intl unzip curl git

# ── 4. Configurare MySQL ──────────────────────────────────────
echo "[3/7] Configurare MySQL..."
mysql -u root <<SQL
ALTER USER 'root'@'localhost' IDENTIFIED BY '${DB_ROOT_PASS}';
FLUSH PRIVILEGES;
SQL

mysql -u root -p"${DB_ROOT_PASS}" <<SQL
CREATE DATABASE IF NOT EXISTS \`${DB_NAME}\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS '${DB_USER}'@'localhost' IDENTIFIED BY '${DB_PASS}';
GRANT ALL PRIVILEGES ON \`${DB_NAME}\`.* TO '${DB_USER}'@'localhost';
FLUSH PRIVILEGES;
SQL

# ── 5. Clonare repo si configurare ───────────────────────────
echo "[4/7] Clonare repo..."
rm -rf "${APP_DIR}"
git clone --branch "${BRANCH}" "${REPO_URL}" "${APP_DIR}"

# Creare config.php cu credentialele generate
cat > "${APP_DIR}/config.php" <<PHP
<?php
define('DB_HOST', 'localhost');
define('DB_NAME', '${DB_NAME}');
define('DB_USER', '${DB_USER}');
define('DB_PASS', '${DB_PASS}');
define('DB_CHARSET', 'utf8mb4');

define('GROQ_API_KEY', '${GROQ_KEY}');

function getConnection(): PDO {
    static \$pdo = null;
    if (\$pdo === null) {
        \$dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
        \$options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        \$pdo = new PDO(\$dsn, DB_USER, DB_PASS, \$options);
    }
    return \$pdo;
}
PHP

# ── 6. Import baza de date ────────────────────────────────────
echo "[5/7] Import baza de date..."
mysql -u "${DB_USER}" -p"${DB_PASS}" "${DB_NAME}" < "${APP_DIR}/schema.sql"
mysql -u "${DB_USER}" -p"${DB_PASS}" "${DB_NAME}" < "${APP_DIR}/populare_2021.sql"
mysql -u "${DB_USER}" -p"${DB_PASS}" "${DB_NAME}" < "${APP_DIR}/populare_2022.sql"
mysql -u "${DB_USER}" -p"${DB_PASS}" "${DB_NAME}" < "${APP_DIR}/populare_extra.sql"

# ── 7. Permisiuni fisiere ─────────────────────────────────────
chown -R www-data:www-data "${APP_DIR}"
chmod -R 755 "${APP_DIR}"
chmod -R 775 "${APP_DIR}/cache"

# ── 8. Configurare nginx ──────────────────────────────────────
echo "[6/7] Configurare nginx..."
cat > "${NGINX_CONF}" <<NGINX
server {
    listen 80;
    listen [::]:80;
    server_name ${DOMAIN:-_};

    root ${APP_DIR};
    index index.php index.html;

    # PHP files
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.5-fpm.sock;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
        include fastcgi_params;
    }

    # Static assets
    location ~* \.(css|js|jpg|jpeg|png|gif|ico|svg|woff2?)$ {
        expires 7d;
        add_header Cache-Control "public";
    }

    # Block direct access to sensitive files
    location ~ /\.(git|env) {
        deny all;
    }

    location = /config.php { deny all; }

    access_log /var/log/nginx/drugexplorer_access.log;
    error_log  /var/log/nginx/drugexplorer_error.log;
}
NGINX

ln -sf "${NGINX_CONF}" /etc/nginx/sites-enabled/drugexplorer
rm -f /etc/nginx/sites-enabled/default
nginx -t && systemctl reload nginx
systemctl enable nginx php8.5-fpm mysql

# ── Done ──────────────────────────────────────────────────────
SERVER_IP=$(curl -s https://api.ipify.org 2>/dev/null || hostname -I | awk '{print $1}')

echo ""
echo "╔══════════════════════════════════════════════════════╗"
echo "║   Setup GATA!                                        ║"
echo "╠══════════════════════════════════════════════════════╣"
printf "║   URL:        http://%-32s ║\n" "${DOMAIN:-$SERVER_IP}"
printf "║   DB user:    %-36s ║\n" "${DB_USER}"
printf "║   DB pass:    %-36s ║\n" "${DB_PASS}"
printf "║   Root MySQL: %-36s ║\n" "${DB_ROOT_PASS}"
echo "╚══════════════════════════════════════════════════════╝"
echo ""
echo "  Salveaza parolele de mai sus!"
echo ""
