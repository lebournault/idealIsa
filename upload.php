<html>
   <head>
      <title>Stock d'images</title>
   </head>
   <body>
       <p>uipload !!!</p>
     <?php
       //  include ("transfert.php");
         if ( is_uploaded_file($_FILES['imagesSite']['tmp_name'])){
            echo "image chargée <br>";
            echo $_FILES['imagesSite']['tmp_name'];
         }
      ?>
     
   </body>
</html>