<?php

require_once('CBdd.php');

class CTexte{
    
    private $id_txt;
    private $id_contenu;
    private $titre;
    private $texte;
    
    /* constructeur 
        arguments acceptés : aucun ou $id_txt
    */
    public function __construct()
    {

        $nb = func_num_args();
        $args = func_get_args();
        $init = "constructeur$nb"; // méthode de construction appelée en fonction du nombre d'arguments

        if (method_exists(__CLASS__, $init)) {
            $this->$init($args);
        } else {
            echo "nombre d'arguments incorrects (0 ou id_txt acceptés)";
        }
    }

    /* constructeur sans paramètres */
    private function constructeur0($args)
    {
    }

    /* constructeur avec id_txt comme paramètre */
    /*initialise tous les attributs à partir de la BDD grâce à id_txt */
    /* @arg = id_txt */
    private function constructeur1($args)
    {
        $this->id_txt = $args[0];

        $cnx = new CBdd();

        $requete = "SELECT `id_txt`, `id_contenu`, `titre`, `texte` FROM `texte` WHERE id_txt = ?";
        $row = $cnx->lireEnregistrementParId($requete, $this->id_txt);

        if ($row == null) {
            echo "texte inconnu";
        } else {
            $this->id_txt= $row["id_txt"];
            $this->id_contenu = $row["id_contenu"];
            $this->titre = $row["titre"];
            $this->texte = $row["texte"];
         }
    }

    /* supprimer le texte de la BDD*/
    public function supprimer()
    {
        // on supprime le texte à partir de id_txt
        $cnx = new CBdd();

        $requete = "DELETE FROM `texte` WHERE id_txt = ?";
        //  if (!$cnx->supprimerUnEnregistrementParId($requete, $this->img_id)){
        if (!$cnx->actualiserEnregistrement($requete, "i", $this->id_txt)) {
            echo "Impossible de supprimer le texte " . $this->id_txt;
            return false;
        }

        return true;
    }

    function inserer($titre, $texte){
               
            $req = "INSERT INTO texte (titre, texte)
                     VALUES (?,?)";
            $cnx = new CBdd();

            if (!$cnx->actualiserEnregistrement($req, "ss", $titre, $texte)) {
                echo "Echec d'enregistrement";
                return false;
            }

            $req = "SELECT MAX(id_txt) FROM texte";
            $result = $cnx->lireTousLesEnregistrements($req);
            
            $this->id_txt = $result[0][0];
            $this->id_contenu = "NULL";
            $this->titre = $titre;
            $this->texte = $texte;

            return true;
        }
    
        public function modifier()
        {
            $req = "UPDATE texte SET id_contenu=?, titre=?, texte=? WHERE id_txt=?";
            $cnx = new CBdd();

            if (!$cnx->actualiserEnregistrement($req, "issi",$this->id_contenu, $this->titre, $this->texte, $this->id_txt)) {
                // if (!$cnx->insererEnregistrement($req)){
                echo "Echec d'enregistrement";
                return false;
            }
            return true;
        }

    /**
     * Get the value of id_txt
     */ 
    public function getId_txt()
    {
        return $this->id_txt;
    }

    
    /**
     * Get the value of texte
     */ 
    public function getTexte()
    {
        return $this->texte;
    }

    /**
     * Set the value of texte
     *
     * @return  self
     */ 
    public function setTexte($texte)
    {
        $this->texte = $texte;

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

    /**
     * Set the value of titre
     *
     * @return  self
     */ 
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Set the value of id_txt
     *
     * @return  self
     */ 
    public function setId_txt($id_txt)
    {
        $this->id_txt = $id_txt;

        return $this;
    }

    
}
