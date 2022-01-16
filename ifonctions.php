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

//iGestionImageTexte/formulaire d'ajout de texte et de suppression
function supprimerTexte($id)
{
   $txt = new CTexte($id);
   $txt->supprimer();
}

function ajouterTexte($texte, $id_contenu){
   $txt = new CTexte();
   $txt->inserer($id_contenu, $texte);
}

function modifierTexte($id)
{
   $txt = new CTexte($id);
   $txt->modifier($id);
}
?>