# SUPFILE PROJECT

L’objectif de ce projet est la création et la mise en place d’un système de vente d'espace de stockage en ligne sur Internet


## Configuration requise
- PHP >= 5.6
- Mysql
- Symfony 3.3.2
- Composer => [Installer Composer](http://getcomposer.com/) A confirmer


## Installation :

Pour ceux qui sont sous windows installer git core pour windows

[Télécharger git](https://git-scm.com/downloads)

Cloner le projet 

`https://github.com/elvino29/SupFile.git`

`cd SupFile/`

`composer install`  



## Configuration de la base de donnée

Ouvrez le fichier ./app/config/parameters.yml et adaptez la configuration.
 
`DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/supfile`

Puis faites:

`php bin/console doctrine:database:create`

et 

`php bin/console doctrine:schema:update --force`


## Pour finir
Lancez le serveur

`php bin/console server:run` 

rendez vous depuis votre navigateur à l'url indiqué.


