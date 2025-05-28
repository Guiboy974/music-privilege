# Générateur Csv 

L’objectif de l’application développée sous **Laravel** était de concevoir un outil générique d’exportation de flux produits vers des marketplaces et des comparateurs de prix. Cette application est spécifiquement conçue pour les marchands utilisant le **CMS Magento,** car l'importation des produits repose sur une **API** dédiée qui communique directement avec Magento.

L’outil permet de configurer les exports en fonction des exigences spécifiques de chaque plateforme tierce (marketplace ou comparateur). Il est ainsi possible de définir pour chaque champ : une valeur par défaut, sa visibilité, son ordre d’apparition, ainsi que son comportement lors de la génération du fichier CSV. Cela garantit une flexibilité maximale dans la gestion des attributs produits selon les contraintes de chaque service externe.

**Laravel**, associé au framework **Filament**, s’est révélé être une solution idéale pour ce projet. Bien que ce ne soit pas le but de l’application, son interface simple et intuitive permet une utilisation autonome par les marchands eux-mêmes.

**Blueprint PHP**, intégré à **Laravel**, offre une approche déclarative pour définir la structure de la base de données. Au lieu d'écrire du **SQL** brut, Blueprint permet de décrire les tables, colonnes et relations à l'aide d'une syntaxe PHP fluide et intuitive. Cette approche présente l'avantage majeur de rendre le schéma de base de données facilement compréhensible et modifiable.
