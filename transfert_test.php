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
   </body>
</html>
