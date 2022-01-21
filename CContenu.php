<?php
require_once('IfContenu.php');
require_once('CImage.php');
require_once('CTexte.php');

class CContenu
{
    /* attributs */
    private $id_contenu;
    private $boolean_img;   // True si le contenu est une image, false si c'est un texte
    private $id_img;
    private $id_txt;

    /* constructeur 
        arguments acceptés : aucun ou $id_contenu
    */
    public function __construct()
    {

        $nb = func_num_args();
        $args = func_get_args();

        $init = "constructeur$nb"; // méthode de construction appelée an fonction du nombre d'arguments

        if (method_exists(__CLASS__, $init)) {
            $this->$init($args);
        } else {
            echo "nombre d'arguments incorrects (0 ou id acceptés)";
        }
    }

    /* constructeur sans paramètres */
    private function constructeur0($args)
    {
    }

    /* constructeur avec $im_img comme paramètre */
    /*initialise tous les attributs à partir de la BDD grâce à id_contenu */
    /* @arg = id_contenu */
    private function constructeur1($args)
    {
        $this->id_contenu = $args[0];

        $cnx = new CBdd();

        $requete = "SELECT boolean_img, id_img, id_txt FROM contenu WHERE id_contenu = ?";
        $row = $cnx->lireEnregistrementParId($requete, $this->id_contenu);

        if ($row == null) {
            echo "contenu inconnu";
        } else {
            $this->boolean_img = $row["boolean_img"];
            $this->id_img = $row["id_img"];
            $this->id_txt = $row["id_txt"];
        }
    }


    /* supprimer l'image de la BDD*/
    public function supprimer()
    {
        // on supprime l'image à partir de id_img
        $cnx = new CBdd();

        $requete = "DELETE FROM contenu WHERE id_contenu = ?";
        if (!$cnx->actualiserEnregistrement($requete, "i", $this->id_contenu)) {
            echo "Impossible de supprimer le contenu " . $this->id_contenu;
            return false;
        }
        
        return true;
    }


    /* 
 enregistre un id_img dans la BDD
 @arg $id_image : id de l'image
 return : true ou false suivant que l'enregistrement a fonctionné ou nom
 */
    function insererImage($id_image)
    {
        // inscription dans la BDD
        $req = "INSERT INTO contenu (boolean_img, id_img) VALUES (?, ?)";

        $cnx = new CBdd();
        if (!$cnx->actualiserEnregistrement($req, "ii", 1, $id_image)) {
            echo "Echec d'enregistrement";
            return false;
        }

        $this->boolean_img = 1;
        $this->id_img = $id_image;
        // récupération et affectation de l'attribut $id_contenu (lecture de l'id du dernier enregistrement effectué)
        $req = "SELECT MAX(id_contenu) FROM contenu";
        $result = $cnx->lireTousLesEnregistrements($req);
        $this->id_contenu = $result[0][0];

        return true;
    }


    /* 
 enregistre un id_txt dans la BDD
 @arg $id_txt : id du texte
 return : true ou false suivant que l'enregistrement a fonctionné ou nom
 */
    function insererTexte($id_txt)
    {
        // inscription dans la BDD
        $req = "INSERT INTO contenu (boolean_img, id_txt) VALUES (?, ?)";

        $cnx = new CBdd();
        if (!$cnx->actualiserEnregistrement($req, "ii", 0, $id_txt)) {
            echo "Echec d'enregistrement";
            return false;
        }

        $this->boolean_img = 0;
        $this->id_txt = $id_txt;
        // récupération et affectation de l'attribut $id_contenu (lecture de l'id du dernier enregistrement effectué)
        $req = "SELECT MAX(id_contenu) FROM contenu";
        $result = $cnx->lireTousLesEnregistrements($req);
        $this->id_contenu = $result[0][0];

        return true;
    }

    function inserer($id, $boolean_img)
    {
        // inscription dans la BDD
        if ($boolean_img) {
            $req = "INSERT INTO contenu (boolean_img, id_img) VALUES (?, ?)";
        } else {
            $req = "INSERT INTO contenu (boolean_img, id_txt) VALUES (?, ?)";
        }
        $cnx = new CBdd();
        if (!$cnx->actualiserEnregistrement($req, "ii", $boolean_img, $id)) {
            echo "Echec d'enregistrement";
            return false;
        }

        $this->boolean_img = $boolean_img;
        if ($boolean_img) {
            $this->id_img = $id;
        } else {
            $this->id_txt = $id;
        }

        // récupération et affectation de l'attribut $id_contenu (lecture de l'id du dernier enregistrement effectué)
        $req = "SELECT MAX(id_contenu) FROM contenu";
        $result = $cnx->lireTousLesEnregistrements($req);
        $this->id_contenu = $result[0][0];

        return true;
    }



    public function lireContenu()
    {

        /* traitement du contenu à renvoyer */
        if ($this->boolean_img) {        // si c'est une image
            $contenu = new CImage($this->id_img);
        } else {
            $contenu = new CTexte($this->id_txt);
        }

        return $contenu->lireContenu();
    }
    
    public function lireIntituleContenu()
    {

        /* traitement du contenu à renvoyer */
        if ($this->boolean_img) {        // si c'est une image
            $contenu = new CImage($this->id_img);
        } else {
            $contenu = new CTexte($this->id_txt);
        }

        return $contenu->lireIntituleContenu();
    }
    


    /**
     * Get the value of boolean_img
     */
    public function getBoolean_img()
    {
        return $this->boolean_img;
    }

    /**
     * Set the value of boolean_img
     *
     * @return  self
     */
    public function setBoolean_img($boolean_img)
    {
        $this->boolean_img = $boolean_img;

        return $this;
    }

    /**
     * Get the value of id_contenu
     */ 
    public function getId_contenu()
    {
        return $this->id_contenu;
    }
}
