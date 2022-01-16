<?php
    require_once('CImage.php');
    require_once('CTexte.php');
    
    /* définit le contenu d'une page : image ou texte */
    class CMyContenu {
        /* attributs */
        private $id_mycontenu;
        private $boolean_img;   // false si texte, true si image
        private $valeur; // id de l'image ou du texte

        /*références vers d'autres d'objets */
        private $myContenu; // référence vers CImage ou  CTexte

/* constructeur 
        arguments acceptés : aucun ou $id_mycontenu
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
    /*initialise tous les attributs à partir de la BDD grâce à id_mycontenu */
    /* @arg = id_mycontenu */
    private function constructeur1($args)
    {
        $this->id_mycontenu = $args[0];

        $cnx = new CBdd();

        $requete = "SELECT boolean_img, valeur FROM mycontenu WHERE id_mycontenu = ?";
        $row = $cnx->lireEnregistrementParId($requete, $this->id_mycontenu);

        if ($row == null) {
            echo "mycontenu inconuu";
        } else {
            $this->boolean_img = $row["boolean_img"];
            $this->valeur = $row["valeur"];
         }

         //initialisation de la référence vers l'objet image ou texte
         if ($this->boolean_img){   // si image
            $this->myContenu = new CImage($this->valeur);
         } else {
            $this->myContenu = new CTexte($this->valeur);
           }
    }


 /* supprimer l'objet de la BDD*/
 public function supprimer()
 {
     // on supprime à partir de l'id
     $cnx = new CBdd();

     $requete = "DELETE FROM mycontenu WHERE id_mycontenu = ?";
     if (!$cnx->actualiserEnregistrement($requete, "i", $this->id_mycontenu)) {
         echo "Impossible de supprimer id_mycontenu : " . $this->id_mycontenu;
         return false;
     }

     return true;
 }


 /* 
enregistre un id_mycontenu dans la BDD
@arg $boolean_img : true si on insère une image, false si c'est un texte
@arg $valeur : id de l'image ou du texte à insérer
return : true ou false suivant que l'enregistrement a fonctionné ou nom
*/
 function inserer($boolean_img, $valeur)
 {
     // inscription dans la BDD
     $req = "INSERT INTO mycontenu (boolean_img, valeur) VALUES (?, ?)";

     $cnx = new CBdd();
     if (!$cnx->actualiserEnregistrement($req, "ii", $boolean_img, $valeur)) {
         echo "Echec d'enregistrement";
         return false;
     }

     $this->boolean_img = $boolean_img;
     $this->valeur = $valeur;
     // récupération et affectation de l'attribut $id_mycontenu(lecture de l'id du dernier enregistrement effectué)
     $req = "SELECT MAX(id_mycontenu) FROM mycontenu";
     $result = $cnx->lireTousLesEnregistrements($req);
     $this->id_mycontenu = $result[0][0];

     return true;
 }


 /* 
modifie l'objet dans la BDD (nom et desciption uniquement)
return : true ou false suivant que la mise à jour à fonctionné ou non
*/
 public function modifier()
 {
     $req = "UPDATE mycontenu SET boolean_img = ?, valeur=? WHERE id_mycontenu = ?";

     $cnx = new CBdd();

     if (!$cnx->actualiserEnregistrement($req, "iii", $this->boolean_img, $this->valeur, $this->id_mycontenu)) {
         echo "Echec de modification <br>";
         return false;
     }

     return true;
 }


        /**
         * Get the value of myContenu
         */ 
        public function getMyContenu()
        {
                return $this->myContenu;
        }

        /**
         * Get the value of boolean_img
         */ 
        public function getBoolean_img()
        {
                return $this->boolean_img;
        }

        /**
         * Get the value of boolean_img
         */ 
  
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
         * Get the value of valeur
         */ 
        public function getValeur()
        {
                return $this->valeur;
        }

        /**
         * Set the value of valeur
         *
         * @return  self
         */ 
        public function setValeur($valeur)
        {
                $this->valeur = $valeur;

                return $this;
        }
}
?>
