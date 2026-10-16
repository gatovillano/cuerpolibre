## 19-11-25 Aumento del límite de subida de archivos en WordPress (Docker)
Descripción general: El usuario reportó un error al subir archivos, indicando que excedían el límite `upload_max_filesize` en `php.ini`. Se identificó que la instancia de WordPress estaba corriendo en un contenedor Docker, por lo que la solución implicó modificar la configuración dentro del contenedor.

- **Punto 1**: Se identificó el contenedor Docker de WordPress (`cuerpolibre-wordpress-1`) utilizando `docker ps`.
- **Punto 2**: Se localizó el archivo `php.ini` dentro del contenedor en `/usr/local/etc/php/php.ini` usando `docker exec cuerpolibre-wordpress-1 find / -name php.ini`.
- **Punto 3**: Se modificaron las directivas `upload_max_filesize` y `post_max_size` a `64M` en el `php.ini` del contenedor utilizando `docker exec` y `sed`.
- **Punto 4**: Se reinició el contenedor `cuerpolibre-wordpress-1` utilizando `docker restart` para aplicar los cambios de configuración de PHP.