<html>

<head>
   <title>Gestionnaire de magazines</title>
   <a href="index.php">Retour Accueil</a><br>
</head>

<body>
   <?php
   include_once("ifonctions.inc.php");
   include_once("CMagazine.php");
   include_once("CCollectionImages.php");
   include_once("CPage.php");
   include_once("CContenu.php");


   session_start();
   $id_mag = $_SESSION['id_mag'];
   // Traitement du passage du nom_mag de l'index vers iGestionContenuMag 
   if (isset($_POST["id_magazine"])) {
      $id_mag = $_POST["id_magazine"];
      $_SESSION['id_mag'] = $id_mag;
   }
   $mag = new CMagazine($id_mag);
   echo "<h1>Gestionnaire du magazine : " . $mag->getNom_mag() . "</h1>";
   ?>

   <!-- Formulaire buttons radio -->
   <h3>Ajouter du contenu à votre magazine :</h3>
   <form enctype="multipart/form-data" action="" method="post">
      <input type="radio" id="image" name="choix" value="image" onclick="this.form.action = 'iChoixImage.php';" />
      <label for="image">Image</label>
      <input type="radio" id="texte" name="choix" value="texte" onclick="this.form.action = 'iChoixTexte.php';">
      <label for="texte">Texte</label>&emsp;
      <input type="submit" value="Valider" />
   </form>


   <h3>Contenu pages:</h3>
   <?php
   // Traitement du formulaire tableau. 
   if (isset($_POST['ok'])) {
      // Récupérer le tableau contenant la saisie. 
      $lignes = $_POST['saisie'];
      foreach ($lignes as $id_contenu => $ligne) {

         if (isset($ligne['supprimer'])) {
            // Case "supprimer" cochée = suppression = DELETE 
            $page = new Cpage($mag->getId_mag(), $id_contenu);
            $page->supprimer(); //a faire
            
         }
         if (isset($ligne['num_page'])) {
            $page = new CPage($mag->getId_mag(), $id_contenu);
            $page->setNum_page($ligne['num_page']);
            $page->modifier();
         }
         /* elseif ($ligne['modifier'] == 1) {
            // Zone "modifier" TRUE (1) = modification = UPDATE 
            //$mag->modifierPage();
           
         } */
      }

   ?>
      <script>
         document.location.href = "iGestionContenuMag.php";
      </script>
   <?php
   }
   ?>
   <!-- construction d'une table HTML à l'intérieur  
 ++++ d'un formulaire -->
   <form action="" name="formulaire" method="post">
      <table border="1" cellpadding="4" cellspacing="0">
         <!-- ligne de titre -->
         <tr align="center">
            <th>Contenu</th>
            <th style="display:none;">Identifiant</th>
            <th>Nom Contenu</th>
            <th>Numéro de page</th>
            <th>Supprimer</th>
         </tr>
         <?php


         if ($mag->getPages() != NULL) {

            $i = 0;
            // Boucle de fetch. 

            foreach ($mag->getPages() as $page) {
               // Incrémentation du compteur de ligne. 
               $i++;
               // Calcul du numéro d'ordre dans le formulaire de la 
               // zone cachée correspondant à l'identifiant. 
               $n = 5 * ($i - 1);
               // Mise en forme des données. 

               if ($page->getContenu()->getBoolean_img()) {
                  $contenutab = "<img src='" . $page->getContenu()->lireContenu()  . "' width='10%'/>";
               } else {
                  $contenutab = $page->getContenu()->lireContenu();
               }


               printf(
                  "<tr><td>%s</td><td style=\"display:none;\">%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",

                  $contenutab,

                  $page->getId_Contenu() . "<input type=\"hidden\" name=\"saisie[" . $page->getId_Contenu() . "][modifier]\" />",

                  $page->getContenu()->lireIntituleContenu(),

                  "<input type=\"number\"  min=\"1\" name=\"saisie[" . $page->getId_Contenu() . "][num_page]\" value=\"" . $page->getNum_page() . "\"
                   onchange=\"document.formulaire[$n].value=1\">",


                  "<input type=\"checkbox\" name=\"saisie[" . $page->getId_Contenu() . "][supprimer]\" value=\"" . $page->getId_Contenu() . "\" />"
               );
            } // foreach 
         }
         ?>
      </table>
      <p><input type="submit" name="ok" value="Valider les modifications" /></p>
      <a href="iApercuFlipbook.php">Aperçu flipbook</a>
</body>

</html>