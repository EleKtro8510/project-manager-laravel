🛠️ Application de Gestion de Projets, Équipes et Membres

Cette application Laravel permet de gérer efficacement des projets, équipes, et membres, avec des fonctionnalités complètes d’édition, d’affectation, et de visualisation.
🚀 Fonctionnalités principales

    ✅ Création, modification et suppression de projets

    👥 Gestion des équipes et de leurs membres

    🔗 Assignation d’une équipe à un projet

    🔄 Modification dynamique des membres d'une équipe (ajout, suppression, réassignation)

    🔍 Affichage détaillé des projets, avec description et équipe liée

    🧩 Interface utilisateur claire avec Bootstrap 5 (pills, boutons stylisés, responsive)

📁 Structure des entités
Project

    id

    name

    description (nullable)

    status

    team_id (nullable)

Team

    id

    name

Member

    id

    name

    role

    team_id (nullable)

🖼️ Aperçu des pages

    /project → Liste des projets avec filtre par équipe

    /team → Liste des équipes avec leurs membres

    /member → Vue de tous les membres, avec équipe associée

📝 Personnalisation

    Tu peux personnaliser les rôles des membres dans les vues create.team et edit.team

    Ajoute ou désactive des statuts de projets dans les <select>

📌 Notes techniques

    Laravel v10+

    Bootstrap v5.3

    Utilisation d’Eloquent pour toutes les relations (hasMany, belongsTo)

    Utilisation de request()->validate() pour la validation propre côté serveur

    Comportements dynamiques gérés avec un peu de JS vanilla

📃 Licence

Ce projet est open-source
# project-manager-laravel
# project-manager-laravel
