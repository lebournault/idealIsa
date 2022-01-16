<html>

<head>
   <title>Ajoute une image dans la table image</title>
</head>

<body>
   <?php
  
  
   //include_once("CMycontenu.php");
   include_once("CContenu.php");

/*    $cont1 = new CMyContenu(1);
   $cont2 = new CMyContenu(2);

   echo $cont1->getMyContenu()->getImg_desc();
   echo $cont2->getMyContenu()->getTexte(); */

   $cont1 = new CContenu(1);
   $cont2 = new CContenu(2);

   echo $cont1->getContenu()->getMyContenu()->getImg_desc();
   echo '<br>';
   echo $cont2->getContenu()->getMyContenu()->getTexte();

?>

</body>

</html>