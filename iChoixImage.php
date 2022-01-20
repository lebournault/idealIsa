<html>

<head>
   <title>Projet</title>
   <a href="iGestionContenuMag.php">Retour Gestion de contenu</a><br>
</head>

<body>
   <?php

   include_once("ifonctions.inc.php");
   include_once("CCollectionImages.php");
   include_once("CMagazine.php");

   session_start();

   $images = new  CCollectionImages();
   $magazine = new CMagazine($_SESSION['id_mag']); //il faut la récupérer avec une variable session
   

  echo "<h1>Choix images pour le mag: " . $magazine->getNom_mag() . "</h1>"
  ?>
  <h3>Ajouter des images à votre magazine: </h3>

   <h3>Choisir une ou plusieurs images pour votre magazine:</h3>
   <?php
   // Traitement du formulaire tableau. 
   if (isset($_POST['ok'])) {
      // Récupérer le tableau contenant la saisie. 
      $lignes = $_POST['saisie'];
     
      foreach ($lignes as $id_img => $ligne) {
         if (isset($ligne['selectionner'])) {
            // Case "selectionner" cochée = selection = insert Into collection de pages? 
            $magazine->ajouterPageImage($id_img);
         }
      }
      ?>
      <script>document.location.href="iGestionContenuMag.php"; </script>
      <?php
   }
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
            <th>Selectionner</th>
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
                  "<tr>
                     <td>%s</td>
                     <td style=\"display:none;\">%s</td>
                     <td>%s</td>
                     <td>%s</td>
                     <td>%s</td>
                  </tr>",
                  
                  "<img src='" . $image->getImg_formatee()  . "' width='30%'/>",
                  
                  $image->getId_img() . "<input type=\"hidden\"    name=\"saisie[" . $image->getid_img() . "][modifier]\" />", //colonne Cachée
                  
                  $image->getImg_nom(),
                  
                  $image->getImg_desc(),
                  
                  "<input type=\"checkbox\"  name=\"saisie[" . $image->getid_img() . "][selectionner]\"  value=\"" . $image->getid_img() . "\" />"
               );
            } // foreach 
         }
         ?>
      </table>
      <p><input type="submit" name="ok" value="Valider" /></p>

</body>

</html>