# README - Annuaire 
Cet annuaire permet de recenser les membres de votre équipe. 

# Pré-requis 
- Serveur Web (Apache)
- PHP
- MySQL

# Installation 
Récupérer l'ensemble des fichiers présent sur le dépôt GitHub. Modifier le fichier `config.php` et indiquer les identifiants d'accès à votre base de donnée. 
Créer les 2 tables : 
- Users : permet de stocker les utilisateurs aptent à se connecter
- Collaborateurs : Permet de stocker l'ensemble des collaborateur présent sur `index.php` .

# Structure SQL : 

Table Users : 

<img width="1055" alt="Capture d’écran 2024-10-31 à 14 34 21" src="https://github.com/user-attachments/assets/cccf9465-ec90-4bf0-b00d-efcdc49d70ed">

Table Collaborateurs : 

<img width="1107" alt="Capture d’écran 2024-10-31 à 14 34 57" src="https://github.com/user-attachments/assets/793df4b5-f998-4ba9-8c44-4074b81d0772">

# Création de compte : 

Afin de créer un compte, vous devez renseigner les informations suivantes dans la page `ajout_utilisateur.php` : 

- Username
- Password
- Nom
- Prénom

Une fois fait, upload cette page à la racine et accéder à la page depuis le navigateur. Si tout est bon, vous pouvez vous connecter sur la page `login.php` avec l'utilisateur que vous 
venez de créer. 
Pour des raisons de sécurité évidente, ne laissez pas cette page sur votre serveur Web après la création du compte. 

# Ajout d'un collaborateur : 

Afin d'ajouter un collaborateur sur la page d'accueil, veuillez vous rendre sur la page `add_collaborateur.php` et y renseigner les informations. 
**Attention, cela ne crééra pas de compte pour se connecter à l'annuaire. Pour ce faire, veuillez utiliser la méthode "Création de compte".**

# Créer dossier photos 

Afin que les photos des collaborateurs s'upload bien, veuillez créer le sous dossier `photos` dans le dossier `assets`. 
