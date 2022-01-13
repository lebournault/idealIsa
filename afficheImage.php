<?php
    require_once('CBdd.php');
    
    if ( isset($_GET['id']) ){
      $id = intval ($_GET['id']);
      $cnx=new CBdd();
      
      $requete = "SELECT `img_type`, `img_blob` FROM `images` WHERE img_id = ?";
      $row = $cnx->lireEnregistrementParId($requete, $id);

      if ( $row == null){
        echo "image inconnue";
      } else {

        $img_type = $row["img_type"];
        $img_blob = $row["img_blob"];
 
      //convert a blob into an image file
      $image = imagecreatefromstring($img_blob); 

      //capture de tampon
      ob_start(); 
      if ($img_type == "image/jpeg" || $img_type  == "image/jpg"){
        imagejpeg($image, null, 80);
      }
      $data = ob_get_contents();
      ob_end_clean();
      
      $image = "data:". $img_type  .";base64," .  base64_encode($data);
      echo '<img src="'.$image  . '" width="40%"/>';
      }      

    } else {
        echo "Mauvais id d'image";
    }

?>
