<?php
require_once('CPage.php');

class CMagazine
{
    /* attributs */
    private $id_mag;
    private $nom_mag;
    private $nb_pages;

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

        $requete = "SELECT nom_mag, nb_pages FROM magazine WHERE id_mag = ?";
        $row = $cnx->lireEnregistrementParId($requete, $this->id_mag);

        if ($row == null) {
            echo "magazine inconnu";
        } else {
            $this->nom_mag = $row["nom_mag"];
            $this->nb_pages = $row["nb_pages"];
        }

        //initialisation du tableau des pages du magazine
        $requete = "SELECT id_contenu, num_page FROM page WHERE id_mag = ? order by num_page";
        $result = $cnx->lirePlusieursEnregistrementsParId($requete, $this->id_mag);

        if ($result != null) {
            foreach ($result as $page) {
                $this->pages[] = new CPage($this->id_mag, $page[0]);
            }
        }
    }


    /* supprimer le magazine de la BDD*/
    public function supprimer()
    {
        // on supprime le magazine à partir de son id
        $cnx = new CBdd();

        $requete = "DELETE FROM `magazine` WHERE id_mag = ?";
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
    function inserer($nom_mag, $nb_pages)
    {
        // inscription dans la BDD
        $req = "INSERT INTO magazine (nom_mag, nb_pages) VALUES (?,?)";

        $cnx = new CBdd();
        if (!$cnx->actualiserEnregistrement($req, "si", $nom_mag, $nb_pages)) {
            echo "Echec d'enregistrement";
            return false;
        }

        // récupération et affectation de l'attribut $id_mag (lecture de l'id du dernier enregistrement effectué)
        $req = "SELECT MAX(id_mag) FROM magazine";
        $result = $cnx->lireTousLesEnregistrements($req);

        $this->id_mag = $result[0][0];
        $this->nom_mag = $nom_mag;
        $this->nb_pages = $nb_pages;

        return true;
    }


    /* 
 modifie l'objet dans la BDD (nom et desciption uniquement)
 return : true ou false suivant que la mise à jour à fonctionné ou non
 */
    public function modifier()
    {
        $req = "UPDATE magazine SET nom_mag = ?, nb_pages =? WHERE id_mag = ?";

        $cnx = new CBdd();

        if (!$cnx->actualiserEnregistrement($req, "sii", $this->nom_mag, $this->nb_pages, $this->id_mag)) {
            echo "Echec de modification <br>";
            return false;
        }

        return true;
    }


    public function ajouterPageImage($id_img)
    {
        // inscription dans la BDD
        $req = "Select id_contenu from contenu where id_img =?";

        $cnx = new CBdd();
        if (!$result = $cnx->lireEnregistrementParId($req, $id_img)) {
            $contenu = new CContenu();
            if (!$contenu->inserer($id_img, 1)) {
                echo "échec d'ajout de la page d'identifiant " . $id_img;
                return false;
            }
            $id_contenu = $contenu->getId_contenu();
        } else {
            $id_contenu = $result["id_contenu"];
        }
        $page = new CPage();
        $page->inserer($id_contenu, $this->id_mag, -1);
    }
    

    public function ajouterPageTexte($id_txt)
    {
        //var_dump($id_txt);
        // inscription dans la BDD
        $req = "Select id_contenu from contenu where id_txt =?";

        $cnx = new CBdd();
        if (!$result = $cnx->lireEnregistrementParId($req, $id_txt)) {
            $contenu = new CContenu();
            if (!$contenu->inserer($id_txt, 0)) {
                echo "échec d'ajout de la page d'identifiant " . $id_txt;
                return false;
            }
            $id_contenu = $contenu->getId_contenu();
        } else {
            $id_contenu = $result["id_contenu"];
        }
        $page = new CPage();
        $page->inserer($id_contenu, $this->id_mag, -1);
    } 


    /**
     * Get the value of nom_mag
     */
    public function getNom_mag()
    {
        return $this->nom_mag;
    }

    /**
     * Set the value of nom_mag
     *
     * @return  self
     */
    public function setNom_mag($nom_mag)
    {
        $this->nom_mag = $nom_mag;

        return $this;
    }

    /**
     * Get the value of id_mag
     */
    public function getId_mag()
    {
        return $this->id_mag;
    }

    /**
     * Get the value of nb_pages
     */
    public function getNb_pages()
    {
        return $this->nb_pages;
    }

    /**
     * Set the value of nb_pages
     *
     * @return  self
     */
    public function setNb_pages($nb_pages)
    {
        $this->nb_pages = $nb_pages;

        return $this;
    }

    /**
     * Get the value of pages
     */
    public function getPages()
    {
        return $this->pages;
    }
}
