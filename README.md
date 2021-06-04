# skill-management

1/ Installation complémentaire dans la console : 

  |_ " composer require twig/intl-extra "                 (=> Datetime format)
  
  |_ " composer require symfony/twig-pack "               (=> Customize error page)
  
  |_ " composer require symfony/webpack-encore-bundle "   (=>webapck pour mise en forme css)
  
  |_ " npm install "
  
  |_ " npm install bootstrap --save-dev "                 (=> installation de boostrap)
  
  |_ " npm i @popperjs/core "                             (=>dependance complémentaire boostrap)
  
  

2/ Récupéper le Fichier "DATA_SOURCE_ENTITIES.zip" dans moodle (Fichiers au format sql pour importation dans la BDD PHPMyAdmin)


3/ Mots de passe encodés : accès par défaut pour chaque profil :

|ROLE_ :       EMAIL                     => PASSWORD     |
|--------------------------------------------------------|
|admin :      root@root.com              => root         |
|structure :  commercial@commercial.com  => commercial   |
|structure :  rh@rh.com                  => rhrh         |
|user :       collaborateur@oracle.com   => collaborateur|



4/ Table relationnelle :

<img width="1142" alt="Table relationnelle" src="https://user-images.githubusercontent.com/65809101/118299118-a347d580-b4e0-11eb-9904-7a7997973ae9.png">
