<html>

<head>
   <title>Ajoute une texte dans la table texte</title>
</head>

<body>
   <?php

   include_once("ifonctions.php");
   include_once("ifonctions.inc.php");
   include_once("CCollectionTextes.php");


   if (isset($_POST["texte_supp_id"])) {
      supprimerTexte($_POST["texte_supp_id"]);
   }

   if (isset($_POST["texte"])) {
      ajouterTexte($_POST["texte"], $_POST["titre"]);
   }
   ?>

   <h1>Gestionnaire du texte</h1>
   <h3>Ajouter un texte à votre répertoire texte:</h3>
   <form enctype="multipart/form-data" action="" method="post">
      <label for="name">titre :</label>
      <input type="text" id="titre" name="titre"></text>
      <textarea name="texte" rows="5" cols="40"></textarea>
      <input type="submit" value="Enregistrer" />
   </form>
   <h3>Modifications :</h3>
   <?php
   // Traitement du formulaire. 
   if (isset($_POST['ok'])) {
      // Récupérer le tableau contenant la saisie. 
      $lignes = $_POST['saisie'];
      foreach ($lignes as $id_txt => $ligne) {
         // Nettoyage de la saisie. 
         $titre = trim($ligne['titre']);
         $texte = trim($ligne['texte']);

         if (isset($ligne['supprimer'])) {
            // Case "supprimer" cochée = suppression = DELETE 
            supprimerTexte($id_txt);
         } elseif ($ligne['modifier'] == 1) {
            // Zone "modifier" TRUE (1) = modification = UPDATE 
            modifierTexte($id_txt, $titre, $texte);
         }
      }
   }
   // Recharger les textes
   // $resultat = lireToutesLesTextes();

   ?>
   <!-- construction d'une table HTML à l'intérieur  
 ++++ d'un formulaire -->
   <form action="iGestionTexte.php" name="formulaire" method="post">
      <table border="1" cellpadding="4" cellspacing="0">
         <!-- ligne de titre -->
         <tr align="center">
            <th>Identifiant</th>
            <th>Titre</th>
            <th>Texte</th>
            <th>Supprimer</th>
         </tr>
         <?php
         // Code PHP pour les lignes du tableau. 
         $textes = new CCollectionTextes();

         if ($textes->getCollection() != null) { // S'il y a un résultat à afficher 
            // Initialisation d'un compteur de ligne. 
            $i = 0;
            // Boucle de fetch. 

            foreach ($textes->getCollection() as $texte) {
               // Incrémentation du compteur de ligne. 
               $i++;
               // Calcul du numéro d'ordre dans le formulaire de la 
               // zone cachée correspondant à l'identifiant. 
               $n = 4 * ($i - 1);
               // Mise en forme des données. 

               printf(
                  "<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",

                  $texte->getId_txt() .
                     "<input type=\"hidden\" 
           name=\"saisie[" . $texte->getId_txt() . "][modifier]\" />",
                  "<input type=\"text\" 
           name=\"saisie[" . $texte->getId_txt() . "][titre]\" 
           value=\"" . $texte->getId_txt() . "\" 
           onchange=\"document.formulaire[$n].value=1\" />",
                  "<input type=\"text\" 
           name=\"saisie[" . $texte->getId_txt() . "][texte]\" 
           value=\"" . $texte->getTexte() . "\" 
           onchange=\"document.formulaire[$n].value=1\" />",
                  "<input type=\"checkbox\" 
           name=\"saisie[" . $texte->getId_txt() . "][supprimer]\" 
           value=\"" . $texte->getId_txt() . "\" />"
               );
            } // foreach 
         }
         ?>
      </table>
      <p><input type="submit" name="ok" value="Valider les modifications" /></p>

</body>

</html>