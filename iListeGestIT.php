<html>

<head>
   <title>Affiche la liste des images de la table image</title>
</head>

<body>
   <?php
   require_once('CBdd.php');
   require_once('CImage.php');

   function lireImages()
   {
      $cnx = new CBdd();
      $requete = "SELECT `img_nom`, `img_id` FROM `images`";
      $result = $cnx->lireTousLesEnregistrements($requete);

      echo "<table><tr><td>Nom</td><td>Id</td></tr>";

      foreach ($result as $image) {
         echo "<tr><td>" . $image['img_nom'] . "</td><td>" . $image['img_id'] . "</td></tr>";
      }

      echo "</table>";
   }


   function supprimerImage($id)
   {
      $img = new CImage($id);
      $img->supprimer();
   }



   lireImages();
   ?>
</body>

</html>