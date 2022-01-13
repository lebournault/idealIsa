<html>
   <head>
      <title>Stock d'images</title>
   </head>
   <body>
      <?php
      require_once('CBdd.php');
      $cnx=new CBdd();
      $requete = "SELECT `img_nom`, `img_id` FROM `images`";
      $result = $cnx->lireTousLesEnregistrements($requete);

        echo "<table><tr><td>Nom</td><td>Id</td></tr>";

        foreach($result as $image){
           echo "<tr><td>" . $image['img_nom'] . "</td><td>" . $image['img_id'] . "</td></tr>";
        }
        
        echo "</table>";
      ?>
   </body>
</html>
