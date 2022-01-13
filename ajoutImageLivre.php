<?php
    require_once('CBdd.php');

    function ajoutImageLivre(){
        $ret        = false;
        $img_blob   = '';
        $img_taille = 0;
        $img_type   = '';
        $img_nom    = '';
        $taille_max = 250000;
        $ret        = is_uploaded_file($_FILES['imagesSite']['tmp_name']);

        if (!$ret) {
            echo "Problème de transfert";
            return false;
        } else {
            // Le fichier a bien été reçu
            $img_taille = $_FILES['imagesSite']['size'];
            
            if ($img_taille > $taille_max) {
                echo "Trop gros !";
                return false;
            }

            $img_type = $_FILES['imagesSite']['type'];
            $img_nom  = $_FILES['imagesSite']['name'];
            $img_blob = file_get_contents ($_FILES['imagesSite']['tmp_name']);

            $id_contenu = 1;
            //requête préparée en cours pb avec l'insertion du blob en bdd
            //$cnx=new CBdd();
      
            /* $requete = "INSERT INTO images (id_contenu, img_nom, img_taille, img_type, img_blob) VALUES (?, ?, ?, ?, ?)";
            if (!$cnx->ajouterUneImage($requete, $id_contenu, $img_nom, $img_taille, $img_type, $img_blob)) {
                echo "echec d'insertion d'image";
                return false;
            } */
      
            $mysqli = mysqli_connect("localhost:3306", "flipbook", "Dt5[uctF@A_048Nf", "flipbook");
        
            
            $req ="INSERT INTO images (id_contenu, img_nom, img_taille, img_type, img_blob) VALUES (" .$id_contenu .", '" . $img_nom . "', '" .$img_taille . "', '" . $img_type . "' , '" . addslashes ($img_blob) . "')";

           //echo "requete : ". $req ."<br>";
            
           $mysqli->query($req);
            return true;
        }
    }
?>
