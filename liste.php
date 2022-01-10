<html>
   <head>
      <title>Stock d'images</title>
   </head>
   <body>
      <?php
        $mysqli = mysqli_connect("localhost:3306", "flipbook", "Dt5[uctF@A_048Nf", "flipbook");
        
         $result = $mysqli->query("SELECT `img_nom`, `img_id` FROM `images`");

        echo "<table><tr><td>Nom</td><td>Id</td></tr>";

        while ($images = $result->fetch_assoc()) {
        //var_dump($images);
        echo "<tr><td>" . $images['img_nom'] . "</td><td>" . $images['img_id'] . "</td></tr>";
        
        }
        
        echo "</table>";
      ?>
   </body>
</html>
