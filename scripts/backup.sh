#!/bin/bash
# Backup completo para migrar "tal cual" a otro PC.
# Genera: backup/db.sql.gz + backup/uploads.tar.gz + backup/plugins-list.txt
# Uso: ./scripts/backup.sh
set -e
cd "$(dirname "$0")/.."

mkdir -p backup
DATE=$(date +%Y-%m-%d)

echo "== 1/3 Dump base de datos (cuerpolibre-db-1) =="
docker exec cuerpolibre-db-1 mysqldump -u root -p"$MYSQL_ROOT_PASSWORD" --databases "$MYSQL_DATABASE" 2>/dev/null | gzip > backup/db-$DATE.sql.gz || \
docker exec cuerpolibre-db-1 sh -c 'mysqldump -u root -p"$MYSQL_ROOT_PASSWORD" --all-databases' 2>/dev/null | gzip > backup/db-$DATE.sql.gz || {
  echo "ERROR: no se pudo dumpear. Carga tu .env primero: set -a; source .env; set +a"
  echo "O hazlo manual: docker exec cuerpolibre-db-1 env | grep MYSQL"
  exit 1
}
ln -sf db-$DATE.sql.gz backup/db-latest.sql.gz
echo "OK backup/db-$DATE.sql.gz"

echo "== 2/3 Uploads (puede tardar, 4.6G) =="
tar -czf backup/uploads-$DATE.tar.gz \
  --exclude='wp-statistics' \
  --exclude='cache' \
  -C wp-content uploads
ln -sf uploads-$DATE.tar.gz backup/uploads-latest.tar.gz
ls -lh backup/

echo "== 3/3 Lista de plugins =="
docker exec cuerpolibre-wordpress-1 wp plugin list --path=/var/www/html --allow-root 2>/dev/null > backup/plugins-list.txt || \
ls wp-content/plugins/ > backup/plugins-list.txt
cat backup/plugins-list.txt

echo ""
echo "Listo. Copia la carpeta backup/ a disco externo / Drive."
echo "NO se sube a GitHub (muy pesado)."
