# 🌐 Réseau Social - Social Network

## Description

Ce projet est un réseau social développé en PHP avec une architecture modern et sécurisée. Il permet aux utilisateurs de s'inscrire, se connecter, publier des messages, suivre d'autres utilisateurs et interagir via des "J'aime" et des mots-clés.

**Status**: ✅ Sécurisé | ✅ Dockerisé | ✅ Production-ready

## 🎯 Fonctionnalités

### Utilisateurs
- ✅ **Inscription** - Enregistrement sécurisé avec validation d'email et mot de passe bcrypt
- ✅ **Connexion** - Authentification avec prepared statements
- ✅ **Profil** - Affichage du profil utilisateur et statistiques

### Contenu
- ✅ **Mur** - Messages personnels de l'utilisateur
- ✅ **Flux** - Messages des personnes suivies
- ✅ **Actualités** - Flux global de tous les messages
- ✅ **Mots-clés** - Navigation par tags/hashtags
- ✅ **Likes** - Système de "J'aime" sur les posts

### Social
- ✅ **Suiveurs** - Gérer les followers
- ✅ **Abonnements** - Voir les personnes suivies
- ✅ **Paramètres** - Modifier les informations personnelles

### Administration
- ✅ **Panel Admin** - Statistiques utilisateurs et mots-clés
- ⚠️ **Modération** - À implémenter

## 🚀 Démarrage Rapide (Docker)

### Prérequis
- Docker installé ([https://docker.com](https://docker.com))
- Docker Compose

### Installation et Lancement

```bash
# 1. Cloner/accéder au projet
cd /path/to/social_network

# 2. Lancez la commande suivante :
docker-compose up -d

# 3. Attendre 30 secondes, puis ouvrir
# http://localhost:8080
```

### Arrêter
```bash
docker-compose down
```

## 👤 Auteur

Boris Valero 

