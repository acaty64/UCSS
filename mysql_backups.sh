#!/bin/bash

USER='root'
PASSWORD='ucss20505378629'

# Indicamos que queremos eliminar los respaldos mayores a 30 días
find /home/admin/backups -name "*.sql.gz" -mtime +30 -exec /bin/rm {} \;

# Creamos el respaldo de la BD deploy y que queremos comprimirla por medio
# de gzip indicandole en el nombre la fecha y hora de cuando se creó el respaldo

mysqldump --user=${USER} --password=${PASSWORD} fcec | gzip > ./backups/bk_`date +%Y%m%d%H%M`.sql.gz
