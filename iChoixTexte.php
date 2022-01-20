<html>

<head>
   <title>Projet</title>
   <a href="iGestionContenuMag.php">Retour Gestion de contenu</a><br>
</head>

<body>
   <?php

   include_once("ifonctions.inc.php");
   include_once("CCollectionTextes.php");
   include_once("CMagazine.php");

   session_start();
 
   $textes = new CCollectionTextes();
   $magazine = new CMagazine($_SESSION['id_mag']); //il faut la récupérer avec une variable session
   
   echo "<h1>Choix texte pour le mag: " . $magazine->getNom_mag() . "</h1>"
   ?>
   <h3>Choisir un ou plusieurs textes pour votre magazine :</h3>
   <?php
   // Traitement du formulaire. 
   if (isset($_POST['ok'])) {
      // Récupérer le tableau contenant la saisie. 
      $lignes = $_POST['saisie'];
     // var_dump($lignes);
      foreach ($lignes as $id_txt => $ligne) {
         if (isset($ligne['selectionner'])) {
            // Case "selectionner" cochée = selectionner = insert into 
            $magazine->ajouterPageTexte($id_txt);
            
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
            <th style="display:none;">Identifiant</th>
            <th>Titre</th>
            <th>Texte</th>
            <th>Selectionner</th>
         </tr>
         <?php
         // Code PHP pour les lignes du tableau. 
         //$textes = new CCollectionTextes();

         if ($textes->getCollection() != null) { // S'il y a un résultat à afficher 
            // Initialisation d'un compteur de ligne. 
            $i = 0;
            // Boucle de fetch. 

            foreach ($textes->getCollection() as $texte) {
               // Incrémentation du compteur de ligne. 
               $i++;
               // Calcul du numéro d'ordre dans le formulaire de la 
               // zone cachée correspondant à l'identifiant. 
               $n = 3 * ($i - 1);
               // Mise en forme des données. 

               printf(
                  "<tr>
                     <td style=\"display:none;\">%s</td>
                     <td>%s</td>
                     <td>%s</td>
                     <td>%s</td>
                  </tr>",

                  $texte->getId_txt() .
                  "<input type=\"hidden\"    name=\"saisie[" . $texte->getId_txt() . "][modifier]\" />",
                  $texte->getTitre(),
                  $texte->getTexte(),
                  "<input type=\"checkbox\"  name=\"saisie[" . $texte->getId_txt() . "][selectionner]\" value=\"" . $texte->getId_txt() . "\" />"
               );
            } // foreach 
         }
         ?>
      </table>
      <p><input type="submit" name="ok" value="Valider" /></p>

</body>

</html>