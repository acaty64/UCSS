#!/bin/bash

USER='root'
PASSWORD='ucss20505378629'

# Creamos el respaldo de la BD fcec y sin compresion

mysqldump --user=${USER} --password=${PASSWORD} fcec > ~/backups/down_`date +%Y%m%d`.sql

