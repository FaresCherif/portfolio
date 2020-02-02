#!/bin/bash

# Configuration de base: datestamp e.g. YYYYMMDD

DATE=$(date +"%Y%m%d")

# Dossier où sauvegarder les backups (crée le d'abord!)

BACKUP_DIR="/backup/mysql"

# Identifiants MySQL

MYSQL_USER="dbbackup"
MYSQL_PASSWORD="salam"

# Commandes MySQL (aucune raison de modifier ceci)

MYSQL=/usr/bin/mysql
MYSQLDUMP=/usr/bin/mysqldump

# Bases de données MySQL à ignorer. Pas besoin dans notre cas

#SKIPDATABASES="Database|information_schema|performance_schema|mysql"

# Nombre de jours à garder les dossiers (seront effacés après 1 an)

RETENTION=365

# ---- NE RIEN MODIFIER SOUS CETTE LIGNE ------------------------------------------
#
# Create a new directory into backup directory location for this date

mkdir -p $BACKUP_DIR/$DATE

# Retrieve a list of all databases

databases=`$MYSQL -u$MYSQL_USER -p$MYSQL_PASSWORD -e "SHOW DATABASES;" | grep -Ev "($SKIPDATABASES)"`

# Dumb the databases in seperate names and gzip the .sql file

for db in $databases; do
echo $db
$MYSQLDUMP --force --opt --user=$MYSQL_USER -p$MYSQL_PASSWORD --skip-lock-tables --events --databases $db | gzip > "$BACKUP_DIR/$DATE/$db.sql.gz"
done

# Suprimer les fichier de plus de 1an

find $BACKUP_DIR/* -mtime +$RETENTION -delete

