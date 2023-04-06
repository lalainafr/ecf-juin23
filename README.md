
# ECF Quai Antique
[![CircleCI](https://ecf-studi.lalaina.rajaonahsoa.fr)](https://github.com/lalainafr/ecf-juin23.git)

## Description :
Réaliser une application qui permet de gerer la réservation en ligne permettant d'un restaurant. L'application offre les fonctionalités qui permettent la création de compte client et admin, la gestion des galeries d'image sur la page d'accueil, la gestion des cartes, plats et menus, la gestion des horaires d'ouverture, la gestion des réservations, et l'ajout d'allergie par le client


Détails du projet
=========

### Objectifs :
L'objectif de ce projet consiste a concevoir une application web vitrine pour la gestion du restaurant Quai Antique à Chambery qui sera inauguré par le chef Arnaud Michant 
L'application répondra à toutes les fonctionnalités demandées par le chef et sera mise place avec toutes les sécurités nécessaires


### Exigences :
Réaliser une application qui simule une gestion de restaurant  en ligne permettant à un utilisateur d’effectuer des opérations de création de compte client et de le consulter ensuite, effetuer des réservations et les gerer en fonction des dates, creneaux horaires, et nombre de place disponible, de consulter les galeries d'image, les menus, plats, cartes et les horaires disponibles. 

#### Profils utilisateurs :

##### Visiteur : 
* Le visiteur poura consulter les galeries d'images dans la page d'accueil, les horaires d'ouverture les menus ainsi que les plats proposés par le restaurant.

##### Client : 
* Le client peut soumettre une demande de création de compte pour les nouveaux clients. La création de compte s’effectue à travers un formulaire. une fois connecté, le client sera en mesure de mettre un nombre convive et et les allergies par défaut. Il pourra gérer ses propres réservations (consulter, modifier, supprimer). Il pourra consulter les galeries d'images dans la page d'accueil, les horaires d'ouverture le menu ainsi que les plats proposés par le restaurant.

##### Admin :
* L'administrateur aura accès à une interface pour gérer les résecvations des clients (consuler, modifier, supprimer). Il pourra accèder aussi au panel d'administration afin de gérer les galeries d'images sur la page d'accueil, les menu, les plats, les utilisateurs, les horaires d'ouverture, les disponibilités et les catégories des plats.

### Descriptions des fonctionnalités :
#### Souscription et connexion : 
Tout visiteur aura la possibilité d'acceder à une page pour s'inscrire, ensuite une autre page lui permettra de se connecter en entrant ses identifinats (emeil et mot passe). Les mots de passe seront sécurisés.

#### Galerie d'images : 
L'administrateur aura la possibilté de gérer (ajouter, modifier, supprimer) les Galeries d'images (les plats les plus appreciés) qui sont visibles sur la page d'accueil du site web. Au survol de l'image dans la galerie, son titre apparaitra.

#### Carte : 
L'administrateur aura la possibilté de gérer (ajouter, modifier, supprimer) les cartes. Ce sont des plats listés dans des catégories et sont visible dans la page 'carte'

#### Menu : 
L'administrateur aura la possibilté de gérer (ajouter, modifier, supprimer) les menus. Ce sont des plats listés dans des formules et sont visible dans la page 'menu'

#### Horaire d'ouverture : 
L'administrateur aura la possibilté de gérer (ajouter, modifier, supprimer) les horaires d'ouverture du restaurant. Ils ont visible dans chaque pied de page

#### Reservation de table : 
Chaque utilisateur (visiteur, client) pourra accèder à la page de reservation. La réservation continent le nom et prenom de l'utilisateur, une date de réservation, un nombre de place disponible, les créneaux horaires (le midi de 12h - 13h30 et le soir de 19h -21h, les crfeéneaux sont espacés de 15mn)un nombre de personne et les allergies de l'utilisateur.
Si l'utiliseur possède un compte, sont nome et prenom, nombres de personnes ainsi que ses allergies par défaut sont pré remplir dans le formulaire. Toutefois il pourra changer le nombre de personnes pour la réservation, il pourra rajouter des allergies qui sont rajoutés automatiquement dans son profil.
Le nombre de place disponible est généré automatiquement sans rechargement de la page à partir de la date selectionnée par l'utilisateur 

Quelques contraintes ont été mises en place:
* Si la date et antérieure à la date du jour, un message d'erreur est generé pour informer l'utilisateur qu'il ne peut pas selectionner une date antérieurre à la date d'aujourdhui
* Si l'utilisateur a reserver à la date d'aujourdhui, quand il regarder la liste des ses réservations, sa réservation ne pourra pas être modifiée.
* Si le nombre de personnes de la réservation et supérieur au nombre de place de disponibles, un message d'erreur est generé pour informer l'utilisateur qu'il n'y a pas assez de place pour la date d'aujourdhui
* Si le créneau à une date donnée à été pris pas un autre utilisateur, un message d'erreur est generé pour informer l'utilisateur que le créneau n'est plus disponible

Les places disponibles pour les dates selectionnées sont mises à jours (incrementé ou decrementé) dans les cas suivants
* l'utilisateur change le nombre de personnes
* l'utilisateur change de date
* l'utilisateur change le nombre de personnes et de date


#### Horaire d'ouverture : 
Le client (utilisateur connecté) aura la possibilté de rajouter des allergies qui seront rajoutés dans son profil et seront visible lorsqu'il fera une réservation

Guide d'utilisation
=========
Le guide d'utilisation ce trouve dans le dossier pdf. 
Vous pouvez également cliquer sur ce [lien](https://github.com/...)

Déploiement
=========
Afin de déployer le projet sur hostinger. Il est important d'avoir créer un compte sur celui-ci, louer un hebergement ainsi qu'un nom de domaine

Configuration: 

Sur hostinger
* Parametrer la base données( nom d'utilisateur et mot de passe) 
* Parametrer la version PHP
* Installer le fichier .htaccess 

Sur un terminal
* Se connecter dans le shell bash de hostinger à partir de la la clé SSH
    * Aller dans le dossier concerné
    * Mettre à jour Composer
    * Installer les dépendances (php bin console composer.phar.install ou update)
    * Faire les migrations (php bin console doctrine:migrations:migrate)
    * Faire les fixtures (php bin console doctrine:fixture:load)
* Passer en mode prod (APP_ENV=prod)
* php composer.phar install --no-dev --optimize-autoloader
* On nettoye le cache (APP_ENV=prod APP_DEBUG=0 php bin/console cache :clear)


Installation en local
====================

Pour installer le projet en local. Vous devez avoir un environement de développement correctement configuré.

[Mettre en place un environement de développement](https://symfony.com/doc/current/setup.html)

Une fois cela fait :

* Cloner le projet
  * ````git clone https://github.com/lalainafr/ecf-juin23.git````
* Créer une copie du .env en le nommant .env.local
  * ````cp .env .env.local````
* Modifier le fichier .env.local afin de le rendre compatible avec votre environement
* Installer les dépendances php
  * ````composer install````
* Exécuter les migrations sur la base de données
  * ```php bin/console doctrine:migrations:migrate```
* Créer un compte admin et quelques utilisateurs
  * ````php bin/console doctrine:fixture:load````
* Lancer le projet
  * ````symfony server:start````
    

