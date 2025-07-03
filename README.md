# Student-API

API REST pour gérer les notes scolaires des étudiants.

## Description

Cette API permet de créer, lire, mettre à jour et supprimer des étudiants et leurs notes.  
Elle est développée en PHP avec le micro-framework Slim 4 et utilise une base de données MySQL.

## Fonctionnalités

- CRUD des étudiants (nom, email)
- CRUD des notes (matière, note, étudiant)
- JSON en entrée et sortie
- Routes RESTful
- Connexion à une base MySQL via PDO

## Installation

1. Cloner le dépôt : git clone https://github.com/Xenozn/Student-API.git
2. Installer les dépendances : composer install
3. Configurer la base de données dans db.php
4. Importer le schéma SQL (tables students et grades) dans votre base MySQL.
5. Lancer le serveur PHP : php -S localhost:8080 -t public

## Utilisation
- GET /students : Liste tous les étudiants
- POST /students : Ajoute un étudiant (JSON : { "name": "...", "email": "..." })
- GET /grades : Liste toutes les notes
- POST /grades : Ajoute une note (JSON : { "student_id": 1, "subject": "...", "grade": 15 })
- PUT /grades/id : Modifie une note avec son ID (JSON : { "student_id": 1, "subject": "...", "grade": 15 })
- DELETE /grades/id : Supprime une note

## Autheur

BASTIEN VEZIN
