<?php

require_once 'CParametresBdd.php';

class CBdd {

  private $parametresBdd;   // association vers CParametresBdd
  private $connexion;       // association vers PDO

  public function __construct(){
    $this->parametresBdd = new CParametresBdd();
  }


  public function connecter(){
    try 
    {
      $this->connexion = mysqli_connect($this->parametresBdd->getIp() .':'. $this->parametresBdd->getPort(), $this->parametresBdd->getMotDePasse(),$this->parametresBdd->getUtilisateur(), $this->parametresBdd->getNomBase());
      return true;
    }
    catch(mysqli_sql_exception  $e){
      $msg = 'Erreur mysqli : '.$e->getFile(). 'L.' . $e->getLine().':' .$e->getMessage();
      echo $msg;
      return false;
    }
  }

  public function deconnecter(){
    $this->connexion->close();
  }


  public function lireEnregistrementParId($requete, $id){
    if (!$this->connecter()) {
      echo 'connexion KO';
      return null;
    }

    /* Crée une requête préparée */
    if ($stmt = $this->connexion->prepare($requete)) {

      /* Lecture des marqueurs */
      $stmt->bind_param("i", $id);

      /* Exécution de la requête */
      $stmt->execute();

      /* Lecture des variables résultantes */
      $result = $stmt->get_result();

      /* Fermeture du traitement */
      $this->deconnecter();
      return $result->fetch_assoc();
    } else {

      /* Fermeture de la connexion */
      $this->deconnecter();
      return null;
    }
  }

/*   public function ajouterUneImage($requete, $id, $img_nom, $img_taille, $img_type, $img_blob){
    if (!$this->connecter()) {
      echo 'connexion KO';
      return null;
    }
    // Crée une requête préparée 
    if ($stmt = $this->connexion->prepare($requete)) {

      // Lecture des marqueurs
      //$img_blob = mysqli_real_escape_string($this->connexion,$img_blob);
     // $img_blob = addslashes($img_blob);
      $stmt->bind_param("isisb", $id, $img_nom, $img_taille, $img_type, $img_blob);
      $stmt->send_long_data(0, $img_blob);

        // Exécution de la requête //
      if (!$stmt->execute()) {
        echo "Échec lors de l'exécution de la requête : (" . $stmt->errno . ") " . $stmt->error;
        $this->deconnecter();
        return false;
      } else {
        $this->deconnecter();
        return true;
      }
   }
  } */
}
?>