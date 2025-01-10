# Réseau Social

## Description

ReSoC est un projet de réseau social développé en PHP. Il permet aux utilisateurs de s'inscrire, de se connecter, de publier des messages, de suivre d'autres utilisateurs et d'interagir avec des publications via des "J'aime" et des mots-clés.

## Fonctionnalités

- **Inscription** : Les utilisateurs peuvent s'inscrire via le formulaire d'inscription ([registration.php](registration.php)).
- **Connexion** : Les utilisateurs peuvent se connecter via le formulaire de connexion ([login.php](login.php)).
- **Mur** : Chaque utilisateur a un mur où ses messages sont affichés ([wall.php](wall.php)).
- **Flux** : Les utilisateurs peuvent voir les messages des personnes qu'ils suivent ([feed.php](feed.php)).
- **Actualités** : Les utilisateurs peuvent voir les derniers messages de tous les utilisateurs ([news.php](news.php)).
- **Mots-clés** : Les utilisateurs peuvent voir les messages associés à des mots-clés spécifiques ([tags.php](tags.php)).
- **Abonnements** : Les utilisateurs peuvent voir la liste des personnes qu'ils suivent ([subscriptions.php](subscriptions.php)).
- **Suiveurs** : Les utilisateurs peuvent voir la liste des personnes qui les suivent ([followers.php](followers.php)).
- **Paramètres** : Les utilisateurs peuvent voir et modifier leurs informations personnelles ([settings.php](settings.php)).
- **Administration** : Les administrateurs peuvent voir les utilisateurs et les mots-clés les plus utilisés ([admin.php](admin.php)).
- **Usurpation de Post** : Les utilisateurs peuvent poster des messages en se faisant passer pour quelqu'un d'autre (à des fins de test) ([usurpedpost.php](usurpedpost.php)).

## Base de Données

Le projet utilise une base de données MySQL. Les informations de connexion sont définies dans le fichier [config.php](config.php).

## Sécurité

- Les entrées des utilisateurs sont échappées pour éviter les injections SQL.
- Les mots de passe sont hachés avant d'être stockés dans la base de données.

## Installation

1. Clonez le dépôt sur votre machine locale.
2. Configurez les informations de connexion à la base de données dans le fichier [config.php](config.php).
3. Importez le schéma de la base de données fourni dans votre serveur MySQL.
4. Lancez un serveur web local (par exemple, XAMPP, WAMP) et accédez au projet via votre navigateur.



