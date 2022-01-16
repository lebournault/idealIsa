<?php

require_once('CBdd.php');

class CImage
{
    /* attributs identiques à la BDD */
    private $img_id;
    private $id_contenu;
    private $img_nom;
    private $img_taille;
    private $img_type;
    private $img_desc;
    private $img_blob;      // image au format blob brut tel qu'elle est stockée en BDD

    /* attributs supplementaires*/
    private $img_formatee;  // image au format jpg, png, etc...
    private $TAILLE_MAX = 16777216;   // taille maxi de l'image en octets (16Mo)


    /* constructeur 
        arguments acceptés : aucun ou $id_img
    */
    public function __construct()
    {

        $nb = func_num_args();
        $args = func_get_args();

        $init = "constructeur$nb"; // méthode de construction appelée an fonction du nombre d'arguments

        if (method_exists(__CLASS__, $init)) {
            $this->$init($args);
        } else {
            echo "nombre d'arguments incorrects (0 ou id_img acceptés)";
        }
    }

    /* constructeur sans paramètres */
    private function constructeur0($args)
    {
    }

    /* constructeur avec $im_img comme paramètre */
    /*initialise tous les attributs à partir de la BDD grâce à id_img */
    /* @arg = id_img */
    private function constructeur1($args)
    {
        $this->img_id = $args[0];

        $cnx = new CBdd();

        $requete = "SELECT id_contenu, img_nom, img_taille, img_type, img_desc, img_blob FROM image WHERE img_id = ?";
        $row = $cnx->lireEnregistrementParId($requete, $this->img_id);

        if ($row == null) {
            echo "image inconnue";
        } else {
            $this->id_contenu = $row["id_contenu"];
            $this->img_nom = $row["img_nom"];
            $this->img_taille = $row["img_taille"];
            $this->img_type = $row["img_type"];
            $this->img_desc = $row["img_desc"];
            $this->img_blob = $row["img_blob"];
            $this->img_formatee = $this->creerImageFormatee();
         }
    }


    /* créer l'image au format Jpg, png, etc. à partir d'un blob brut (format en BDD)*/
    /* @return = image au format jpg, png, etc en fonction du type d'image */
    private function creerImageFormatee()
    {
        //convert a blob into an image file
        if ($this->img_blob != null) {
            $image = imagecreatefromstring($this->img_blob);

            ob_start(); //You could also just output the $image via header() and bypass this buffer capture.
            if ($this->img_type == "image/jpeg" || $this->img_type  == "image/jpg") {
                imagejpeg($image, null, 80);
            } else if ($this->img_type == "image/png") {
                imagepng($image);
            } else if ($this->img_type == "image/gif") {
                imagegif($image, null, 80);
            } else if ($this->img_type == "image/bmp") {
                imagebmp($image, null, 80);
            }

            $data = ob_get_contents();
            ob_end_clean();

            $image = "data:" . $this->img_type  . ";base64," .  base64_encode($data);
            return $image;
        }
    }



    /* supprimer l'image de la BDD*/
    public function supprimer()
    {
        // on supprime l'image à partir de id_img
        $cnx = new CBdd();

        $requete = "DELETE FROM `image` WHERE img_id = ?";
        if (!$cnx->actualiserEnregistrement($requete, "i", $this->img_id)) {
            echo "Impossible de supprimer l'image " . $this->img_id;
            return false;
        }

        return true;
    }


    /* 
     enregistre une image dans la BDD
     @arg $image : image au format $_FILES à insérer
     @arg $description : description de type string
     @arg $id_contenu : id du contenu de type int

     return : true ou false suivant que l'enregistrement a fonctionné ou nom
     */
    function inserer($image, $description)
    {
        // chargement de l'image et vérification de ses caractéristiques
        $ret = is_uploaded_file($image['imagesSite']['tmp_name']);

        if (!$ret) {
            echo "Problème de transfert de l'image";
            return false;
        } else {
            // Le fichier a bien été reçu
            $type = $image['imagesSite']['type'];
            if (
                $type != "image/jpeg" && $type  != "image/jpg" && $type != "image/png"
                && $type != "image/gif" && $type != "image/bmp"
            ) {
                echo "types d'images supportés : jpeg, png, gif, bmp";
                return false;
            }

            $img_taille = $image['imagesSite']['size'];

            if ($img_taille > $this->TAILLE_MAX) {
                echo "Echec d'enregistrement de l'image, taille maximmum autorisée : $this->TAILLE_MAX";
                return false;
            }

            // affectation des attributs sauf $img_id
            $this->img_taille = $image['imagesSite']['size'];
            $this->img_type = $image['imagesSite']['type'];
            $this->img_nom  = $image['imagesSite']['name'];
            $this->img_blob = file_get_contents($image['imagesSite']['tmp_name']);
            $this->img_formatee = $this->creerImageFormatee();
            $this->img_desc = $description;
            $this->id_contenu = 'NULL';


            // inscription dans la BDD
            $req = "INSERT INTO image (id_contenu, img_nom, img_taille, img_type, img_desc, img_blob)
                     VALUES (" . $this->id_contenu . ", '" . $this->img_nom . "', '" . $this->img_taille . "', '" . $this->img_type . "' ,
                      '" . $this->img_desc . "' ,'" . addslashes($this->img_blob) . "')";

            $cnx = new CBdd();
            if (!$cnx->actualiserEnregistrement($req)) {
                // if (!$cnx->insererEnregistrement($req)){
                echo "Echec d'enregistrement";
                return false;
            }

            // récupération et affectation de l'attribut $img_id (lecture de l'id du dernier enregistrement effectué)
            $req = "SELECT MAX(img_id) FROM image";
            $result = $cnx->lireTousLesEnregistrements($req);
            $this->img_id = $result[0][0];

            return true;
        }
    }


    /* 
     modifie une image dans la BDD (nom et desciption uniquement)
     return : true ou false suivant que la mise à jour à fonctionné ou non
     */
    public function modifier()
    {
        $req = "UPDATE image SET id_contenu=?, img_nom = ?, img_desc = ? WHERE img_id = ?";    

        $cnx = new CBdd();
        
        if (!$cnx->actualiserEnregistrement($req, "issi",$this->id_contenu ,$this->img_nom, $this->img_desc, $this->img_id)) {
            echo "Echec de modification <br>";
            return false;
        }

        return true;
    }
    

    /**
     * Get the value of img_id
     */
    public function getImg_id()
    {
        return $this->img_id;
    }

    /**
     * Get the value of img_nom
     */
    public function getImg_nom()
    {
        return $this->img_nom;
    }

    /**
     * Get the value of img_taille
     */
    public function getImg_taille()
    {
        return $this->img_taille;
    }

    /**
     * Get the value of img_type
     */
    public function getImg_type()
    {
        return $this->img_type;
    }

    /**
     * Get the value of img_desc
     */
    public function getImg_desc()
    {
        return $this->img_desc;
    }

    /**
     * Get the value of img_formatee
     */
    public function getImg_formatee()
    {
        return $this->img_formatee;
    }

    /**
     * Set the value of img_nom
     *
     * @return  self
     */ 
    public function setImg_nom($img_nom)
    {
        $this->img_nom = $img_nom;

        return $this;
    }

    /**
     * Set the value of img_desc
     *
     * @return  self
     */ 
    public function setImg_desc($img_desc)
    {
        $this->img_desc = $img_desc;

        return $this;
    }

    /**
     * Set the value of id_contenu
     *
     * @return  self
     */ 
    public function setId_contenu($id_contenu)
    {
        $this->id_contenu = $id_contenu;

        return $this;
    }
}
