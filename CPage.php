<?php
require_once('CContenu.php');
require_once('CMagazine.php');

class CPage
{
    /* attributs */
    private $id_page;
    private $id_contenu;
    private $id_mag;
    private $num_page;

    /*références vers d'autres d'objets */
    private $contenu; // référence vers CContenu

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

    /* constructeur avec $id_page comme paramètre */
    /*initialise tous les attributs à partir de la BDD grâce à id_page */
    /* @arg = id_page */
    private function constructeur1($args)
    {
        $this->id_page = $args[0];

        $cnx = new CBdd();

        $requete = "SELECT id_contenu, id_mag, num_page FROM page WHERE id_page = ?";
        $row = $cnx->lireEnregistrementParId($requete, $this->id_page);

        if ($row == null) {
            echo "contenu inconuu";
        } else {
            $this->id_contenu = $row["id_contenu"];
            $this->id_mag = $row["id_mag"];
            $this->num_page = $row["num_page"];
        }

        //initialisation de la référence vers l'objet image ou texte
        $this->contenu = new CContenu($this->id_contenu);
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
 enregistre un id_page dans la BDD
 @arg $id_contenu : id de contenu
  @arg $id_mag : id de magazine
  @arg $num_page : numéro de page dans le magazine
 return : true ou false suivant que l'enregistrement a fonctionné ou nom
 */
    function inserer($id_contenu, $id_mag, $num_page)
    {
        // inscription dans la BDD
        $req = "INSERT INTO page (id_contenu, id_mag, num_page) VALUES (?, ?, ?)";

        $cnx = new CBdd();
        if (!$cnx->actualiserEnregistrement($req, "iii", $id_contenu, $id_mag, $num_page)) {
            echo "Echec d'enregistrement";
            return false;
        }

        $this->id_contenu = $id_contenu;
        $this->id_mag = $id_mag;
        $this->num_page = $num_page;
        // récupération et affectation de l'attribut $id_page (lecture de l'id du dernier enregistrement effectué)
        $req = "SELECT MAX(id_page) FROM page";
        $result = $cnx->lireTousLesEnregistrements($req);
        $this->id_page = $result[0][0];

        return true;
    }


    /* 
 modifie l'objet dans la BDD (nom et desciption uniquement)
 return : true ou false suivant que la mise à jour à fonctionné ou non
 */
    public function modifier()
    {
        $req = "UPDATE page SET id_contenu = ?, id_mag = ?, num_page = ? WHERE id_page = ?";

        $cnx = new CBdd();

        if (!$cnx->actualiserEnregistrement($req, "iiii", $this->id_contenu, $this->id_mag, $this->num_page, $this->id_page)) {
            echo "Echec de modification <br>";
            return false;
        }

        return true;
    }

   
}
