<html>
   <head>
      <title>Stock d'images</title>
   </head>
   <body>
      <?php
        include ("transfert.php");
         if ( isset($_FILES['imagesSite']['tmp_name']) )
         {
             transfert();
         }
      ?>
      <h3>Ajouter une image:</h3>
      <form enctype="multipart/form-data" action="" method="post">
         <input type="hidden" name="MAX_FILE_SIZE" value="250000" />
         <input type="file" name="imagesSite" size=50 />
         <input type="submit" value="Envoyer" />
      </form>
      <p><a href="liste.php">Liste</a></p>
   </body>
</html>
