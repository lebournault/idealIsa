<html>

<head>
   <title>Ajoute une image dans la table image</title>
</head>

<body>
   <?php
   include_once("ajoutImageLivre.php");
   include_once("iListeGestIT.php");
   
   if (isset($_FILES['imagesSite']['tmp_name'])) {
      ajoutImageLivre();
   }
   if (isset($_POST["image_supp_id"])) {
      supprimerImage($_POST["image_supp_id"]);
   }

   ?>
   <h1>Gestionnaire de page</h1>
   <h3>Ajouter une image à votre répertoire Images:</h3>
   <form enctype="multipart/form-data" action="" method="post">
      <input type="hidden" name="MAX_FILE_SIZE" value="250000" />
      <input type="file" name="imagesSite" size=50 />
      <input type="submit" value="Enregistrer" />
   </form>

   <p><a href="iListeGestIT.php">Liste de toutes vos images stockées</a></p>


   <form action="iGestionImageTexte.php" name="formulaire" method="post">
      <table border="1" cellpadding="4" cellspacing="0">
         <!-- ligne de titre -->
         <tr align="center">
            <th>Identifiant</th>
            <th>Nom</th>
            <th>Description</th>
            <th>Supprimer</th>
         </tr>
         <?php
         // Recharger les collections (ici avec une requête  
         // non préparée). 
         // Connexion. 
         $mysqli = mysqli_connect("localhost:3306", "flipbook", "Dt5[uctF@A_048Nf", "flipbook");
         $req = 'SELECT * FROM images';
         $résultat = $mysqli->query($req);
         // Code PHP pour les lignes du tableau. 
         
         ?>
         <h3>Liste des toutes vos images:</h3>
      </table>
      <p><input type="submit" name="ok" value="Enregistrer" /></p>
   </form>
   <h3>Supprimer une image:</h3>
   <form enctype="multipart/form-data" action="" method="post">
      <input type="hidden" name="MAX_FILE_SIZE" value="250000" />
      <input type="number" name="image_supp_id" size=50 />
      <input type="submit" value="Envoyer" />
   </form>
</body>

</html>