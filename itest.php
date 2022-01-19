<html>

<head>
   <title>Ajoute une image dans la table image</title>
</head>

<body>
   <?php
  
  
   //include_once("CMycontenu.php");
   include_once('CMagazine.php');
   include_once 'CPage.php';
   include_once("CContenu.php");

/*    $cont1 = new CMyContenu(1);
   $cont2 = new CMyContenu(2);

   echo $cont1->getMyContenu()->getImg_desc();
   echo $cont2->getMyContenu()->getTexte(); */

/*    $cont1 = new CContenu(1);
   $cont2 = new CContenu(2);

   echo $cont1->getContenu()->getMyContenu()->getImg_desc();
   echo '<br>';
   echo $cont2->getContenu()->getMyContenu()->getTexte(); */

   

   $mag = new CMagazine(99);
   $mag->ajouterPageImage(3);

 
   /* foreach($mag->getPages() as $page){
      echo "num : ".$page->getNum_page().", id_contenu : ".$page->getId_contenu()."<br>";

      echo "contenu image ou texte (boolean_img) : ". $page->getContenu()->getBoolean_img() ."<br>";

      if ($page->getContenu()->getBoolean_img()){
         echo "je suis une image <br>";
         echo "<img src='" . $page->getContenu()->lireContenu()  . "' width='10%'/>";
      } else {
         echo "Texte : <br>" . $page->getContenu()->lireContenu() ."<br>";
      }
      echo "<br><br>";
   } */
?>

</body>

</html>