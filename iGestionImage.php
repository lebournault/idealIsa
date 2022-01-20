<html>

<head>
   <title>Ajoute une image dans la table image</title>
   <a href ="index.php">Retour Accueil</a><br>
</head>

<body>
   <?php

   include_once("ifonctions.inc.php");
   include_once("CCollectionImages.php");
   session_start();

   $images = new  CCollectionImages();
 

   if (isset($_FILES['imagesSite']['tmp_name'])) {
      $images->ajouterImage($_FILES, $_POST["img_desc"]);
   }
   if (isset($_POST["image_supp_id"])) {
      $images->supprimerImage($_POST["image_supp_id"]);
   }

   ?>

   <h1>Gestionnaire d'image</h1>
   <h3>Ajouter une image à votre répertoire Images:</h3>
   <form enctype="multipart/form-data" action="" method="post">
      <table border="0" cellpadding="4" cellspacing="0">
         <tr style="vertical-align:middle;">
            <td><input type="hidden" name="MAX_FILE_SIZE" value="16777216" /></td>
            <td><input type="file" name="imagesSite" size=50 /></td>
            <td><textarea name="img_desc" rows="5" cols="40" placeholder="Ajouter votre description ici"></textarea></td>
            <td> <input type="submit" value="Enregistrer" /></td>
         <tr>
      </table>
   </form>
   <h3>Modifications:</h3>
   <?php
   // Traitement du formulaire. 
   if (isset($_POST['ok'])) {
      // Récupérer le tableau contenant la saisie. 
      $lignes = $_POST['saisie'];
      foreach ($lignes as $id_img => $ligne) {
         // Nettoyage de la saisie. 
         $img_nom = trim($ligne['img_nom']);
         $img_desc = trim($ligne['img_desc']);

         if (isset($ligne['supprimer'])) {
            // Case "supprimer" cochée = suppression = DELETE 
            $images->supprimerImage($id_img);
         } elseif ($ligne['modifier'] == 1) {
            // Zone "modifier" TRUE (1) = modification = UPDATE 
            $images->modifierImage($id_img, $img_nom, $img_desc);
         }
      }
   }
   // Recharger les images
   // $resultat = lireToutesLesImages();

   ?>
   <!-- construction d'une table HTML à l'intérieur  
 ++++ d'un formulaire -->
   <form action="" name="formulaire" method="post">
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
         //$images = new CCollectionImages();

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
                  $image->getId_img() .
                     "<input type=\"hidden\" 
           name=\"saisie[" . $image->getid_img() . "][modifier]\" />",
                  "<input type=\"text\" 
           name=\"saisie[" . $image->getid_img() . "][img_nom]\" 
           value=\"" . $image->getImg_nom() . "\" 
           onchange=\"document.formulaire[$n].value=1\" />",
                  "<input type=\"text\" 
           name=\"saisie[" . $image->getid_img() . "][img_desc]\" 
           value=\"" . $image->getImg_desc() . "\" 
           onchange=\"document.formulaire[$n].value=1\" />",
                  "<input type=\"checkbox\" 
           name=\"saisie[" . $image->getid_img() . "][supprimer]\" 
           value=\"" . $image->getid_img() . "\" />"
               );
            } // foreach 
         }
         ?>
      </table>
      <p><input type="submit" name="ok" value="Valider les modifications" /></p>

</body>

</html>