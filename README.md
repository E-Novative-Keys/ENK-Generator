ENK-Generator
=============

**ENK-Generator** est un générateur de sites Web modulaires développé dans le cadre de la solution **E-Novative Keys**, en tant que *Mission 2* du projet annuel de 2ème année (2i) 2014-2015 à l'*École Supérieure de Génie Informatique* (ESGI) : **Webex**.

Basé sur le framework ENK-MVC, il permettra la génération en quelques clics d'un site Web au design et aux fonctionnalités pré-développés. Il est de plus extrêmement aisé de développer soi-même un template de site et de l'intégrer au générateur.

Templates
------------

Les templates utilisé par le générateur sont situés dans le répertoire *webroot/files/Templates*.

Un template de générateur est composé comme suit :

1. Controllers : les fichiers *Controllers* représentent les modules à proprement parler, ils en contiennent les fonctionnalités.
2. Dependences : fichiers TXT décrivant les dépendances entre modules, chaque module pouvant dépendre de plusieurs autres. Ainsi, si *News.txt* contient *"Admin, Pages"*, l'inclusion du modules *News* entraînera l'inclusion automatique des modules *Admin* et *Pages*.
3. Models : les Modèles utilisés par les Contrôleurs.
4. Routes : fichiers PHP décrivant les URL liées à chaque module.
5. Scripts : fichiers SQL, contenant les tables et insertions aux configurations globales, relatifs à chaque module. Lors de la génération, un script général sera créé à partir de ces différents fichiers.
6. Views : les Vues des modules, organisées en sous-dossiers par nom et en fichiers par action.
7. webroot : les fichiers divers (CSS, JS, images...) utilisés par le site Web généré.
8. icon.png : l'icône du template tel qu'il apparaîtra dans l'interface du générateur.
9. preview.html : un fichier HTML chargé par le générateur pour donner un aperçu du template lors de la génération.

Équipe
------------
* [Mathieu Boisnard](https://github.com/mboisnard)
* [Valentin Fries](https://github.com/MrKloan)
* Vincent Milano