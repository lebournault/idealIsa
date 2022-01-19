<html>

<head>
   <title>Gestionnaire de magazines</title>
   <a href="index.php">Retour Gestion Magazine</a><br>
</head>

<body>
   <?php
   include_once("ifonctions.inc.php");
   include_once("CMagazine.php");
   include_once("CContenu.php"); 
   include_once("CCollectionMagazine.php");

   $contenus = new CCollectionMagazines();

   if (isset($_POST["id_magazine"])) {
      $id_mag = $_POST["id_magazine"];

      $mag = new CMagazine($id_mag);
      echo "<h1>Gestionnaire du magazine : " . $mag->getNom_mag() . "</h1>";
   } else {
      echo "<h1>Magazine inconnu</h1>";
   }

   if (isset($_POST["contenu"])) {
      if ($_POST["contenu"] != "") {
         $contenus->ajouterContenu($_POST["contenu"]);
      }
   }
   ?>


   <h3>Ajouter du contenu à votre magazine :</h3>
   <form action="">
      <input type="radio" id="image" name="contenu" value="image">
      <label for="image">Image</label>
      <input type="radio" id="texte" name="contenu" value="texte">
      <label for="texte">Texte</label>
   </form>





</body>

</html>