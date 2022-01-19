<html>

<head>
   <title>Ajouter des magazin ou modifier les existants</title>
</head>

<body>
   <?php

   include_once("ifonctions.inc.php");
   include_once("CCollectionMagazines.php");

   $magazines = new CCollectionMagazines();

   if (isset($_POST["titre_mag"])) {
      if ($_POST["titre_mag"] != "") {
         $magazines->ajouterMagazine($_POST["titre_mag"], $_POST["nb_pages"]);
      }
   }

   if (isset($_POST["id_mag"])) {
      $magazines->supprimerMagazine($_POST["id_mag"]);
   }
   ?>

   <h1>Gestionnaire Magazine</h1>
   <h3>Ajouter :</h3>
   <form enctype="multipart/form-data" action="" method="post">
      <table border="0" cellpadding="4" cellspacing="0">
         <tr style="vertical-align:middle;">
            <td><label for="name">Titre magazine :</label></td>
            <td><input type="text" id="titre_mag" name="titre_mag"></text></td>
            <td><label for="name">Nombre de pages à insérer dans le magazine :</label></td>
            <td><input type="number" placeholder="1" id="nb_pages" name="nb_pages" min="1"></text></td>
            <td><input type="submit" value="Enregistrer" /></td>
         <tr>
      </table>
      <h3>Modifications :</h3>
      <?php
      // Traitement du formulaire. 
      if (isset($_POST['ok'])) {
         // Récupérer le tableau contenant la saisie. 
         $lignes = $_POST['saisie'];
         var_dump($lignes);
         foreach ($lignes as $id_mag => $ligne) {
            echo "ligne : <br>";
            var_dump($ligne);
            // Nettoyage de la saisie. 
            $nom_mag = trim($ligne['nom_mag']);
            $nb_pages = $ligne['nb_pages'];
            echo "nom mag : " . $nom_mag . "<br>";
            echo "nb pages : $nb_pages";
            if (isset($ligne['supprimer'])) {
               // Case "supprimer" cochée = suppression = DELETE 
               $magazines->supprimerMagazine($id_mag);
            } elseif ($ligne['modifier'] == 1) {
               // Zone "modifier" TRUE (1) = modification = UPDATE 
               $magazines->modifierMagazine($id_mag, $nom_mag, $nb_pages);
            }
         }
      }
      // Recharger les textes
      // $resultat = lireToutesLesTextes();

      ?>
      <!-- construction d'une table HTML à l'intérieur  
 ++++ d'un formulaire -->
      <form action="" name="formulaire" method="get">
         <table border="1" cellpadding="4" cellspacing="0">
            <!-- ligne de titre -->
            <tr align="center">
               <th>Identifiant</th>
               <th>Titre Mag</th>
               <th>Nombre de pages</th>
               <th>Supprimer</th>
               <th>Pages</th>
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
                     "<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",

                     $magazine->getId_mag() . "<input type=\"hidden\" name=\"saisie[" . $magazine->getId_mag() . "][modifier]\" />",
                     "<input type=\"text\" name=\"saisie[" . $magazine->getId_mag() . "][nom_mag]\" value=\"" . $magazine->getNom_mag() . "\" 
                     onchange=\"document.formulaire[$n].value=1\" />",
                     "<input type=\"text\" name=\"saisie[" . $magazine->getId_mag() . "][nb_pages]\" value=\"" . $magazine->getNb_pages() . "\" 
                     onchange=\"document.formulaire[$n].value=1\" />",
                     "<input type=\"checkbox\" name=\"saisie[" . $magazine->getId_mag() . "][supprimer]\" value=\"" . $magazine->getId_mag() . "\" />",

                     "<form action=\"igestionContenuMag.php\" method=\"post\" target=\"_blank\">
                       <input type=\"hidden\" name=\"id_magazine\" value=\"" . $magazine->getId_mag() . "\"/>
                        <button type=\"submit\">Cliquez sur moi</button>
                   </form>"

                  );
               }
            }
            ?>
         </table>
         <p><input type="submit" name="ok" value="Valider" /></p>

         <a href="iGestionContenuMag.php">Gestionnaire de pages</a>&emsp;
         <a href="iGestionImage.php">Gestionnaire d'images</a>&emsp;
         <a href="iGestionTexte.php">Gestionnaire de texte</a>&emsp;
         <a href="iApercuFlipbook.php">flipbook</a>

</body>

</html>