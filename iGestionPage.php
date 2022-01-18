<html>

<head>
   <title>Ajouter des pages au magazin</title>
   <a href ="index.php">Retour Gestion Magazine</a><br>
</head>

<body>
   <?php

   include_once("ifonctions.php");
   include_once("ifonctions.inc.php");
   include_once("CCollectionTextes.php");
   include_once("CCollectionMagazines.php");

   if (isset($_POST["nom_mag"])) {
      ajouterMagazine($_POST["nom_mag"], $_POST["nb_pages"]);
   }

   if (isset($_POST["id_mag"])) {
      supprimerMagazine($_POST["id_mag"]);
   }
   ?>

   <h1>Gestionnaire de pages</h1>
   <h3>Votre magazine :</h3>
   
      
</body>

</html>