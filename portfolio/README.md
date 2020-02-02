Projet tuteuré - Site de mise en relation de stage à l'étranger
===============================================================

Réalisé par Simon MAZENOUX, Fares CHERIF, Guillaume BREHIER, Aurélien RAVAUD et Thomas CHATARD

But du projet
-------------

Le principal objectif de ce projet est la création d'un site de mise en relation d'étudiants avec des entreprises étangères.

Mise en place du site
---------------------

Ce site fonctionne avec php7 et une base de données Mysql (ou mariaDB) et apache.

La base de données doit s'appeler "site_stage_etudiant_entreprise".
L'utilisateur s'appelle "bd" et son mot de passe doit être "bede".
De base, l'application est dans un environnement de développement, cad que les erreurs du SGBD seront affichées directement sur l'écran de l'utilisateur final.

Vous pouvez modifier toutes ces paramètres dans le fichier config.inc.php

Jeu d'essai
-----------

Pour vérifier le bon fonctionnement de notre site, nous avons créer un jeu d'essai :

Toutes les personnes ont comme mot de passe "salam"

Les profs ont un nom et un prénom qui commencent par un P :
Parme Pascal, 05 55 64 15 78, pascal@prof.fr
Peuchere Pierre, 05 45 44 45 98, pierre@prof.fr
Peront Paolo, 05 25 47 65 98, paolo@prof.fr

Les étudiants ont un nom et un prénom qui commençent par un E :
Elan Edouard, 05 85 95 42 37, edouard@etu.fr
Elton Etienne, 05 45 56 52 07, elton@etu.fr
Espere Estebane, 05 85 59 42 87, espere@etu.fr

Les referents ont un nom et un prénom qui commençent par R :
Rolland Robert, 06 65 34 15 87, robert@etu.fr
Regan Ronald, '06 61 84 05 07', ronald@etu.fr
Reginal Raymond, 06 71 48 50 70, raymond@etu.fr

L'admin a un nom et prénom qui commence par un A :
Aubert Arold, 06 12 32 92 12, arold@admin.fr

Les salariés ont un nom et prénom qui commencent par un S :
Salomé Sarran, 06 41 49 58 43, salome@salarie.fr




Mise en place du serveur mail

https://doc.ubuntu-fr.org/msmtp

On utilise msmtp pour envoyer des mail




Mise en place des sauvegardes automatiques
------------------------------------------

Script à voir dans les répertoires ci-dessous

Il faut tout d'abord créer un utilisateur sur la BD souhaitée. Pour cela il faut faire cette requête :

CREATE USER 'dbbackup'@'localhost' IDENTIFIED BY '***';
GRANT SELECT  ,RELOAD ,FILE ,SUPER ,LOCK TABLES ,SHOW VIEW ON * . * TO 'dbbackup'@'localhost' IDENTIFIED BY '***' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0 ;

Ensuite il faut executer le script :

./mysqlbackup.sh

Changer les droit du script (question de securité) :

chmod 755 mysqlbackup.sh

Créer un conjob (Utile et déja installé pour les tâches planifiées sur les serveurs linux)

vi /etc/crontab

0 1 * * * root /usr/local/sbin/kinamo_mysqlbackup.sh

Relanceer le demon crontab

service cron restart
service crond restart
