<?php
require_once('CBdd.php');
require_once('CImage.php');
require_once('CTexte.php');


function supprimerImage($id)
{
   $img = new CImage($id);
   if (!$img->supprimer()){
      echo "Suppression de l'image impossible <br>";
      return false;
   }
   return true;
}

function ajouterImage($image, $description){
   $img = new CImage();
   if (!$img->inserer($image, $description)){
      echo "Insertion de l'image impossible <br>";
      return false;
   }
   return true;
}

function modifierImage($id, $nom, $description){
   $img = new CImage($id);
   $img->setImg_nom($nom);
   $img->setImg_desc($description);

   if (!$img->modifier()){
      echo "Modification de l'image impossible <br>";
      return false;
   }
   return true;
}


function supprimerTexte($id_txt)
{
   $txt = new CTexte($id_txt);
   if (!$txt->supprimer()){
      echo "Suppression du texte impossible <br>";
      return false;
   }
   return true;
   
}



function ajouterTexte($texte, $titre){
   
   $txt = new CTexte();
   if (!$txt->inserer($titre, $texte)){
      echo "Insertion du texte impossible <br>";
      return false;
   }
   return true;

}

function modifierTexte($id_txt, $titre, $texte)
{
   $txt = new CTexte($id_txt);
   $txt->modifier($id_txt);


   $txt = new CTexte($id_txt);
   $txt->settitre($titre);
   $txt->setTexte($texte);

   if (!$txt->modifier()){
      echo "Modification du texte impossible <br>";
      return false;
   }
   return true;

}
?>