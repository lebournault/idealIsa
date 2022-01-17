<?php
require_once('CMycontenu.php');

class CContenu
{
    /* attributs */
    private $id_contenu;
    private $id_mycontenu;

    /*références vers d'autres d'objets */
    private $contenu; // référence vers CMyContenu

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
    /*initialise tous les attributs à partir de la BDD grâce à id_img */
    /* @arg = id_img */
    private function constructeur1($args)
    {
        $this->id_contenu = $args[0];

        $cnx = new CBdd();

        $requete = "SELECT id_mycontenu FROM contenu WHERE id_contenu = ?";
        $row = $cnx->lireEnregistrementParId($requete, $this->id_contenu);

        if ($row == null) {
            echo "contenu inconnu";
        } else {
            $this->id_mycontenu = $row["id_mycontenu"];
        }

        //initialisation de la référence vers l'objet image ou texte
        $this->contenu = new CMyContenu($this->id_mycontenu);
    }


    /* supprimer l'image de la BDD*/
    public function supprimer()
    {
        // on supprime l'image à partir de id_img
        $cnx = new CBdd();

        $requete = "DELETE FROM contenu WHERE id_contenu = ?";
        if (!$cnx->actualiserEnregistrement($requete, "i", $this->id_contenu)) {
            echo "Impossible de supprimer l'image " . $this->id_contenu;
            return false;
        }

        return true;
    }


    /* 
 enregistre un id_mycontenu dans la BDD
 @arg $id_mycontenu : id de mycontenu
 return : true ou false suivant que l'enregistrement a fonctionné ou nom
 */
    function inserer($id_mycontenu)
    {
        // inscription dans la BDD
        $req = "INSERT INTO contenu (id_mycontenu) VALUES (?)";

        $cnx = new CBdd();
        if (!$cnx->actualiserEnregistrement($req, "i", $id_mycontenu)) {
            echo "Echec d'enregistrement";
            return false;
        }

        $this->id_mycontenu = $id_mycontenu;
        // récupération et affectation de l'attribut $img_id (lecture de l'id du dernier enregistrement effectué)
        $req = "SELECT MAX(id_contenu) FROM contenu";
        $result = $cnx->lireTousLesEnregistrements($req);
        $this->id_contenu = $result[0][0];

        return true;
    }


    /* 
 modifie l'objet dans la BDD (nom et desciption uniquement)
 return : true ou false suivant que la mise à jour à fonctionné ou non
 */
    public function modifier()
    {
        $req = "UPDATE contenu SET id_mycontenu = ? WHERE id_contenu = ?";

        $cnx = new CBdd();

        if (!$cnx->actualiserEnregistrement($req, "ii", $this->id_mycontenu, $this->id_contenu)) {
            echo "Echec de modification <br>";
            return false;
        }

        return true;
    }

    /**
     * Get the value of contenu
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set the value of contenu
     *
     * @return  self
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }
}
