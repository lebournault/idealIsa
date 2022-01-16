<html>

<head>
   <title>Ajoute une image dans la table image</title>
</head>

<body>
   <?php
  
   include_once("ifonctions.php");
   include_once("ifonctions.inc.php");
   include_once("CCollectionImages.php");

   if (isset($_FILES['imagesSite']['tmp_name'])) {
      ajouterImage($_FILES, $_POST["img_desc"]);
   }
   if (isset($_POST["image_supp_id"])) {
      supprimerImage($_POST["image_supp_id"]);
   }

   ?>

   <h1>Gestionnaire d'image</h1>
   <h3>Ajouter une image à votre répertoire Images:</h3>
   <form enctype="multipart/form-data" action="" method="post">
      <input type="hidden" name="MAX_FILE_SIZE" value="16777216" />
      <input type="file" name="imagesSite" size=50 />
      <textarea name="img_desc" rows="5" cols="40">Description de votre image ici</textarea>
      <input type="submit" value="Enregistrer" />
   </form>
   <h3>Modifications:</h3>
   <?php
   // Traitement du formulaire. 
   if (isset($_POST['ok'])) {
      // Récupérer le tableau contenant la saisie. 
      $lignes = $_POST['saisie'];
      foreach ($lignes as $img_id => $ligne) {
         // Nettoyage de la saisie. 
         $img_nom = trim($ligne['img_nom']);
         $img_desc = trim($ligne['img_desc']);

         if (isset($ligne['supprimer'])) {
            // Case "supprimer" cochée = suppression = DELETE 
            supprimerImage($img_id);
         } elseif ($ligne['modifier'] == 1) {
            // Zone "modifier" TRUE (1) = modification = UPDATE 
            modifierImage($img_id, $img_nom, $img_desc);
         }
      }
   }
   // Recharger les images
 // $resultat = lireToutesLesImages();

   ?>
   <!-- construction d'une table HTML à l'intérieur  
 ++++ d'un formulaire -->
   <form action="iGestionImage.php" name="formulaire" method="post">
      <table border="1" cellpadding="4" cellspacing="0">
         <!-- ligne de titre -->
         <tr align="center">
            <th>Miniature</th>
            <th style="display:none;">Identifiant</th>
            <th>Nom</th>
            <th>Description</th>
            <th>Supprimer</th>
         </tr>
         <?php
         // Code PHP pour les lignes du tableau. 
         $images = new CCollectionImages();
         
         if ($images->getCollection() != null) { // S'il y a un résultat à afficher 
            // Initialisation d'un compteur de ligne. 
            $i = 0;
            // Boucle de fetch. 

            foreach ($images->getCollection() as $image) {
               // Incrémentation du compteur de ligne. 
               $i++;
               // Calcul du numéro d'ordre dans le formulaire de la 
               // zone cachée correspondant à l'identifiant. 
               $n = 4 * ($i - 1);
               // Mise en forme des données. 

               printf(
                  "<tr><td>%s</td><td style=\"display:none;\">%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                  "<img src='" . $image->getImg_formatee()  . "' width='30%'/>",
                  $image->getImg_id() .
                     "<input type=\"hidden\" 
           name=\"saisie[" . $image->getImg_id() . "][modifier]\" />",
                  "<input type=\"text\" 
           name=\"saisie[" . $image->getImg_id() . "][img_nom]\" 
           value=\"" . $image->getImg_nom() . "\" 
           onchange=\"document.formulaire[$n].value=1\" />",
                  "<input type=\"text\" 
           name=\"saisie[" . $image->getImg_id() . "][img_desc]\" 
           value=\"" . $image->getImg_desc() . "\" 
           onchange=\"document.formulaire[$n].value=1\" />",
                  "<input type=\"checkbox\" 
           name=\"saisie[" . $image->getImg_id() . "][supprimer]\" 
           value=\"" . $image->getImg_id() . "\" />"
               );
            } // foreach 
         }
         ?>
      </table>
      <p><input type="submit" name="ok" value="Valider les modifications" /></p>

</body>

</html>