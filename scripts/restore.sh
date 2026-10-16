#!/bin/bash
# Restaurar en PC nuevo "tal cual".
# Requiere: .env configurado + backup/db-latest.sql.gz + backup/uploads-latest.tar.gz
# Uso: ./scripts/restore.sh
set -e
cd "$(dirname "$0")/.."

if [ ! -f .env ]; then
  echo "ERROR: falta .env. Haz: cp .env.example .env y edítalo."
  exit 1
fi
set -a; source .env; set +a

echo "== 1/3 Levantar contenedores =="
docker compose up -d db
sleep 10
docker compose up -d wordpress
sleep 10

if [ -f backup/db-latest.sql.gz ]; then
  echo "== 2/3 Importar DB =="
  zcat backup/db-latest.sql.gz | docker exec -i cuerpolibre-db-1 mysql -u root -p"$MYSQL_ROOT_PASSWORD" "$MYSQL_DATABASE"
  echo "DB importada."
else
  echo "SKIP: no hay backup/db-latest.sql.gz (instalación limpia)."
fi

if [ -f backup/uploads-latest.tar.gz ]; then
  echo "== 3/3 Restaurar uploads =="
  tar -xzf backup/uploads-latest.tar.gz -C wp-content/
  echo "Uploads restaurados."
else
  echo "SKIP: no hay backup/uploads-latest.tar.gz"
fi

echo ""
echo "Abre http://localhost:${HOST_WORDPRESS_PORT:-9005}"
echo "Si cambiaste de dominio, dentro de WP ejecuta Search-Replace de la URL vieja a la nueva."
