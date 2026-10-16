# Cuerpolibre — cómo recrear la web tal cual en otro PC

## Qué va en GitHub y qué no

**GitHub (código liviano, ~20MB):**
- `wp-content/themes/cuerpolibre/` ← tu tema
- `wp-content/plugins/cuerpolibre-setup/`, `cuerpolibre-masonry-gallery/` ← plugins propios
- `docker-compose.yml`, `.env.example`, `php.ini`, `.htaccess`
- `scripts/`, `docs/`
- Este README

**NO va a GitHub (muy pesado / secreto):**
- `wp-config.php`, `.env` (secretos)
- `wp-content/uploads/` (4.6GB fotos/videos) → va en `backup/` en disco externo / Drive
- `backup/db-*.sql.gz` (base de datos) → disco externo / Drive
- `wp-admin/`, `wp-includes/`, `wp-content/plugins/elementor`, etc. (se re-descargan solos)

## PC viejo (este) — generar backup

```bash
# 1. Asegúrate que los contenedores estén arriba
docker compose up -d

# 2. Generar backup (DB + uploads)
set -a; source .env 2>/dev/null || true; set +a
./scripts/backup.sh
# Si falla por falta de .env, saca las credenciales con:
# docker inspect cuerpolibre-db-1 --format '{{json .Config.Env}}'

# 3. Copia la carpeta backup/ a un disco externo o Drive
ls -lh backup/
```

## PC nuevo — restaurar tal cual

```bash
# 1. Clonar
git clone https://github.com/TU_USUARIO/cuerpolibre.git
cd cuerpolibre

# 2. Configurar
cp .env.example .env
# edita .env con los mismos valores del PC viejo (o nuevos, pero anótalos)

# 3. Copia los backup del disco externo a ./backup/
# backup/db-latest.sql.gz
# backup/uploads-latest.tar.gz

# 4. Levantar + restaurar
docker compose up -d
./scripts/restore.sh

# 5. Abrir
# http://localhost:9005
```

## Si cambias de dominio (ej: de localhost:9005 a midominio.com)

Dentro del contenedor:

```bash
docker exec -it cuerpolibre-wordpress-1 wp search-replace 'http://localhost:9005' 'https://midominio.com' --path=/var/www/html --allow-root
```

## Plugins de terceros (se reinstalan solos o desde backup)

Elementor, Pro Elements, Rank Math, WP Statistics, etc. no están en Git.
Se reinstalan desde wp-admin, o quedan registrados en `backup/plugins-list.txt`.
