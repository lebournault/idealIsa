<?php
require_once('CContenu.php');
require_once('CMagazine.php');

class CPage
{
    /* attributs */
    private $id_contenu;
    private $id_mag;
    private $num_page;

    /* références */
    private $contenu;   // référence vers Ccontenu

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

    /* constructeur avec $id_mag et id_contenu comme paramètres 
    /*    constructeur2($id_mag, $id_contenu)
    /*initialise tous les attributs à partir de la BDD grâce aux identifiants
    /* @arg id_mag : id du magazine
    /* @arg id_contenu : id du contenu
    */
    private function constructeur2($args)
    {
        $this->id_mag = $args[0];
        $this->id_contenu = $args[1];

        $cnx = new CBdd();

        $requete = "SELECT num_page FROM page WHERE id_contenu=? AND id_mag=?";
        $result = $cnx->lirePlusieursEnregistrements($requete, "ii", $this->id_contenu, $this->id_mag);

        if ($result == null) {
            echo "contenu inconuu";
        } else {
            $this->num_page = $result[0]["num_page"];
        }

        // initialisation de la référence vers Ccontenu
            $this->contenu = new CContenu($this->id_contenu);
    }


    /* supprimer l'image de la BDD*/
    public function supprimer()
    {
        // on supprime l'image à partir de id_img
        $cnx = new CBdd();

        $requete = "DELETE FROM page WHERE id_contenu = ? AND id_mag = ?";
        if (!$cnx->actualiserEnregistrement($requete, "ii", $this->id_contenu, $this->id_mag)) {
            echo "Impossible de supprimer la page d'id_mag " .$this->id_mag. "et d'id_contenu ".$this->id_contenu;
            return false;
        }

        return true;
    }


    /* 
 enregistre une nouvelle page avec son num_page dans la BDD
 @arg $id_contenu : id de contenu
  @arg $id_mag : id de magazine
  @arg $num_page : numéro de page dans le magazine
 return : true ou false suivant que l'enregistrement a fonctionné ou nom
 */
    function inserer($id_contenu, $id_mag, $num_page)
    {
        $cnx = new CBdd();
        // vérification si le contenu pour le magazine est déjà présent dans la table page
        $req = "SELECT `id_contenu`from page where `id_contenu`=? and id_mag = ?";
        $resultat =$cnx->lirePlusieursEnregistrements($req, "ii", $id_contenu, $id_mag);
/*         echo "id_contenu: $id_contenu, id_mag : $id_mag <br>";
        echo "req : $req <br>";
        echo 'résultat : <br>';
        var_dump($resultat); */
        
        if ($resultat != null){     // si présent
            return false;
        }

        // inscription dans la BDD
        $req = "INSERT INTO page (id_contenu, id_mag, num_page) VALUES (?, ?, ?)";

        
        if (!$cnx->actualiserEnregistrement($req, "iii", $id_contenu, $id_mag, $num_page)) {
            echo "Echec d'enregistrement";
            return false;
        }

        $this->id_contenu = $id_contenu;
        $this->id_mag = $id_mag;
        $this->num_page = $num_page;

        
        // initialisation de la référence vers Ccontenu
        $this->contenu = new CContenu($this->id_contenu);
 
        return true;
    }


    /* 
 modifie l'objet dans la BDD (numéro de page uniquement)
 return : true ou false suivant que la mise à jour à fonctionné ou non
 */
    public function modifier()
    {
        $req = "UPDATE page SET num_page = ? WHERE id_contenu = ? AND id_mag = ?";

        $cnx = new CBdd();

        if (!$cnx->actualiserEnregistrement($req, "iii", $this->num_page, $this->id_contenu, $this->id_mag)) {
            echo "Echec de modification <br>";
            return false;
        }

        return true;
    }
   

    /**
     * Get the value of id_contenu
     */ 
    public function getId_contenu()
    {
        return $this->id_contenu;
    }

    /**
     * Get the value of id_mag
     */ 
    public function getId_mag()
    {
        return $this->id_mag;
    }

    /**
     * Get the value of num_page
     */ 
    public function getNum_page()
    {
        return $this->num_page;
    }

    /**
     * Set the value of num_page
     *
     * @return  self
     */ 
    public function setNum_page($num_page)
    {
        $this->num_page = $num_page;

        return $this;
    }

    /**
     * Get the value of contenu
     */ 
    public function getContenu()
    {
        return $this->contenu;
    }
}
