<?php

require_once 'CParametresBdd.php';

class CBdd {

  private $parametresBdd;   // association vers CParametresBdd
  private $connexion;       // association vers PDO

  public function __construct(){
    $this->parametresBdd = new CParametresBdd();
    $this->connecter();
  }


  public function connecter(){
    try 
    {
      $this->connexion = new PDO('mysql:host='.$this->parametresBdd->getIp().';port='.$this->parametresBdd->getPort().';dbname='.$this->parametresBdd->getNomBase().';charset=utf8', $this->parametresBdd->getUtilisateur(), $this->parametresBdd->getMotDePasse());
      return true;
    }
    catch(PDOException $e){
      $msg = 'Erreur PDO : '.$e->getFile(). 'L.' . $e->getLine().':' .$e->getMessage();
      return false;
    }
  }

  public function deconnecter(){
    $this->connexion = null;
  }

  public function executerRequeteQuery($requete){      //requête lecture
    try {
      $req = $this->connexion->prepare($requete);      //requete préparée pour éviter les injections sql
      $req->execute();                                 // renvoie un booléen (requete réussie ou pas)
      $result = $req -> fetchAll();                    // renvoie un tableau à deux dimensions
      $req->closeCursor();
      return $result;
    }
    catch(PDOException $e){
      $msg = 'Erreur PDO : '.$e->getFile(). 'L.' . $e->getLine().':' .$e->getMessage();
      return null;
    }
  }

  public function executerRequeteModif($requete){    //Suppression, insertion et mise à jour d'un enregistrement
    try {
      $req = $this->connexion->prepare($requete);    //requete préparée pour éviter les injections sql
      $req->execute();                                  
      $this->connexion->commit();
      return true;
    }
    catch(PDOException $e){
      $msg = 'Erreur PDO : '.$e->getFile(). 'L.' . $e->getLine().':' .$e->getMessage();
      return false;
    }

  }
}

?>