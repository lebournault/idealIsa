<?php
require_once('CPage.php');

class CMagazine
{
    /* attributs */
    private $id_mag;
    private $nom_mag;

    /* association vers les références d'objets CPage */
    private $pages = array(); // tableau des pages du magazine

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

    /* constructeur avec $id_mag comme paramètre */
    /*initialise tous les attributs à partir de la BDD grâce à id_page */
    /* @arg = nom_mag */
    private function constructeur1($args)
    {
        $this->id_mag = $args[0];

        $cnx = new CBdd();

        $requete = "SELECT nom_mag FROM magazine WHERE id_mag = ?";
        $row = $cnx->lireEnregistrementParId($requete, $this->id_mag);

        if ($row == null) {
            echo "contenu inconuu";
        } else {
            $this->nom_mag = $row["nom_mag"];
        }

        //initialisation du tableau des pages du magazine
        $requete = "SELECT id_page FROM page WHERE id_mag = ? ORDER BY num_page";
        $result = $cnx->lireEnregistrementParId($requete, $this->id_mag);

        if ($row == null) {
            echo "id magazine inconuu";
        } else {
            foreach ($result as $page) {
                $this->pages[] = new CPage($page[0]);
            }
        }
    }


    /* supprimer le magazine de la BDD*/
    public function supprimer()
    {
        // on supprime le magazine à partir de son id
        $cnx = new CBdd();

        $requete = "DELETE FROM magazine WHERE id_mag = ?";
        if (!$cnx->actualiserEnregistrement($requete, "i", $this->id_mag)) {
            echo "Impossible de supprimer le magazine " . $this->id_mag;
            return false;
        }

        return true;
    }


    /* 
 enregistre un magazine dans la BDD
 @arg $nom_mag: nom du magazine
 return : true ou false suivant que l'enregistrement a fonctionné ou nom
 */
    function inserer($nom_mag)
    {
        // inscription dans la BDD
        $req = "INSERT INTO magazine (nom_mag) VALUES (?)";

        $cnx = new CBdd();
        if (!$cnx->actualiserEnregistrement($req, "s", $nom_mag)) {
            echo "Echec d'enregistrement";
            return false;
        }

          $this->nom_mag = $nom_mag;
        // récupération et affectation de l'attribut $id_mag (lecture de l'id du dernier enregistrement effectué)
        $req = "SELECT MAX(id_mag) FROM magazine";
        $result = $cnx->lireTousLesEnregistrements($req);
        $this->id_mag = $result[0][0];

        return true;
    }


    /* 
 modifie l'objet dans la BDD (nom et desciption uniquement)
 return : true ou false suivant que la mise à jour à fonctionné ou non
 */
    public function modifier()
    {
        $req = "UPDATE magazine SET nom_mag = ? WHERE id_mag = ?";

        $cnx = new CBdd();

        if (!$cnx->actualiserEnregistrement($req, "si", $this->nom_mag, $this->id_mag)) {
            echo "Echec de modification <br>";
            return false;
        }

        return true;
    }
}
