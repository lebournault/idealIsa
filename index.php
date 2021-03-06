<html>

<head>
   <title>Projet Accueil</title>
</head>

<body>
   <?php

   session_start();

   include_once("ifonctions.inc.php");
   include_once("CCollectionMagazines.php");
   include_once("CMagazine.php");
   include_once("CCollectionImages.php");

   $magazines = new CCollectionMagazines();

   if (isset($_POST["titre_mag"])) {
      if ($_POST["titre_mag"] != "") {
         $magazines->ajouterMagazine($_POST["titre_mag"], $_POST["nb_pages"]);
      }
   }

   if (isset($_POST["id_mag"])) {
      $magazines->supprimerMagazine($_POST["id_mag"]);
   }

   if (isset($_POST["select"])) {
      echo "select OK <br>";
   }

   ?>

   <h1>Accueil : Gestionnaire Magazine</h1>
   <h3>Ajouter un titre et le nombre de pages de votre magazine :</h3>
   <form enctype="multipart/form-data" action="" method="post">
      <table border="0" cellpadding="4" cellspacing="0">
         <tr style="vertical-align:middle;">
            <td><label for="name">Titre magazine :</label></td>
            <td><input type="text" id="titre_mag" name="titre_mag" required></td>
            <td><label for="name">Nombre de pages à insérer dans le magazine :</label></td>
            <td><input type="number" placeholder="1" id="nb_pages" name="nb_pages" min="1"></td>
            <td><input type="submit" value="Enregistrer" /></td>
         <tr>
      </table>
   </form>
   <h3>Modifier le(s) titre(s), le nombre de pages ou supprimer vos magazines :</h3>
   <?php
   // Traitement du formulaire. 
   if (isset($_POST['ok'])) {
      // Récupérer le tableau contenant la saisie. 
      $lignes = $_POST['saisie'];

      foreach ($lignes as $id_mag => $ligne) {
         // Nettoyage de la saisie. 
         $nom_mag = trim($ligne['nom_mag']);
         $nb_pages = $ligne['nb_pages'];

         if (isset($ligne['supprimer'])) {
            // Case "supprimer" cochée = suppression = DELETE 
            $magazines->supprimerMagazine($id_mag);
         } elseif ($ligne['modifier'] == 1) {
            // Zone "modifier" TRUE (1) = modification = UPDATE 
            $magazines->modifierMagazine($id_mag, $nom_mag, $nb_pages);
         }
      }
   }


   ?>
   <!-- construction d'une table HTML à l'intérieur  
 ++++ d'un formulaire -->
   <form enctype="multipart/form-data" action="" name="formulaire" method="post">
      <table border="1" cellpadding="4" cellspacing="0">
         <!-- ligne de titre -->
         <tr align="center">
            <th style="display:none;">Identifiant</th>
            <th>Titre Mag</th>
            <th>Nombre de pages</th>
            <th>Supprimer</th>
            <th>Magazine</th>
         </tr>
         <?php
         // Code PHP pour les lignes du tableau. 
         //$magazines = new CCollectionMagazines();

         if ($magazines->getCollection() != null) { // S'il y a un résultat à afficher 
            // Initialisation d'un compteur de ligne. 
            $i = 0;
            // Boucle de fetch. 

            foreach ($magazines->getCollection() as $magazine) {
               // Incrémentation du compteur de ligne. 
               $i++;
               // Calcul du numéro d'ordre dans le formulaire de la 
               // zone cachée correspondant à l'identifiant. 
               $n = 5 * ($i - 1);
               // Mise en forme des données. 
               printf(
                  "<tr>
                        <td style=\"display:none;\">%s</td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                     </tr>",

                  $magazine->getId_mag() . "<input type=\"hidden\"    name=\"saisie[" . $magazine->getId_mag() . "][modifier]\" />", // colonne cachée

                  "<input type=\"text\"      name=\"saisie[" . $magazine->getId_mag() . "][nom_mag]\" value=\"" . $magazine->getNom_mag() . "\" 
                     onchange=\"document.formulaire[$n].value=1\" />",

                  "<input type=\"text\"      name=\"saisie[" . $magazine->getId_mag() . "][nb_pages]\" value=\"" . $magazine->getNb_pages() . "\" 
                     onchange=\"document.formulaire[$n].value=1\" />",

                  "<input type=\"checkbox\"  name=\"saisie[" . $magazine->getId_mag() . "][supprimer]\" value=\"" . $magazine->getId_mag() . "\" />",

                  "<input type=\"button\"      name=\"select\"  value=\"selectionner\" onclick=\"redirection('iGestionContenuMag.php'," . $magazine->getId_mag() . " )\" />"

               );
            }
         }
         ?>
      </table>
      <p><input type="submit" name="ok" value="Valider" /></p>
   </form>


   <a href="iGestionImage.php">Gestionnaire d'images</a>&emsp;
   <a href="iGestionTexte.php">Gestionnaire de texte</a>&emsp;
   

   <script>
      function redirection(page, id_mag) {
         page = page + "?id_magazine=" + id_mag;
         document.location.href = page;
      }
   </script>
</body>

</html>