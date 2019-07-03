docker-symfony-ELK-mariaDb-PhpMyadmin
=====================================

##commande pour généré les entités a partir de la base de données
docker exec docker-sf4-project_php_1 bin/console doctrine:mapping:import "App\Entity" annotation --path=src/Entity

##commande pour génerer le getter et setter 
 
docker exec docker-sf4-project_php_1 bin/console make:entity --regenerate App