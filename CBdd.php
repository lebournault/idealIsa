<?php

require_once 'CParametresBdd.php';
//require_once 'CImage.php';


class CBdd
{

  private $parametresBdd;   // association vers CParametresBdd
  private $connexion;       // association vers PDO

  public function __construct()
  {
    $this->parametresBdd = new CParametresBdd();
  }


  public function connecter()
  {
    try {
      $this->connexion = mysqli_connect($this->parametresBdd->getIp() . ':' . $this->parametresBdd->getPort(), $this->parametresBdd->getUtilisateur(), $this->parametresBdd->getMotDePasse(), $this->parametresBdd->getNomBase());
      return true;
    } catch (mysqli_sql_exception  $e) {
      $msg = 'Erreur mysqli : ' . $e->getFile() . 'L.' . $e->getLine() . ':' . $e->getMessage();
      echo $msg;
      return false;
    }
  }

  public function deconnecter()
  {
    $this->connexion->close();
  }


  public function lireEnregistrementParId($requete, $id)
  {
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

  public function lirePlusieursEnregistrementsParId($requete, $id)
  {
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
      return $result->fetch_all(MYSQLI_BOTH);
    } else {

      /* Fermeture de la connexion */
      $this->deconnecter();
      return null;
    }
  }


  public function lirePlusieursEnregistrements()
  {
    if (!$this->connecter()) {
      echo 'connexion KO';
      return false;
    }

    $nb = func_num_args();
    $args = func_get_args();

    if ($nb == 0 || $nb == 2) {
      echo "Nombre d'arguments incorrects";
      return false;
    }

    $requete = $args[0];

    if ($nb != 1) {
      $type = $args[1];
    }


    if ($stmt = $this->connexion->prepare($requete)) {

      switch ($nb) {
        case 1:
          break;
        case 3:
          $stmt->bind_param($type, $args[2]);
          break;
        case 4:
          $stmt->bind_param($type, $args[2], $args[3]);
          break;
        case 5:
          $stmt->bind_param($type, $args[2], $args[3], $args[4]);
          break;
        case 6:
          $stmt->bind_param($type, $args[2], $args[3], $args[4], $args[5]);
          break;
        case 7:
          $stmt->bind_param($type, $args[2], $args[3], $args[4], $args[5], $args[6]);
          break;
        case 8:
          $stmt->bind_param($type, $args[2], $args[3], $args[4], $args[5], $args[6], $args[7]);
          break;
        case 9:
          $stmt->bind_param($type, $args[2], $args[3], $args[4], $args[5], $args[6], $args[7], $args[8]);
          break;

        default:
          echo "Nombre d'arguments incorrects";
          return false;
      }

      /* Exécution de la requête */
      $stmt->execute();

      /* Lecture des variables résultantes */
      $result = $stmt->get_result();

      /* Fermeture du traitement */
      $this->deconnecter();
      return $result->fetch_all(MYSQLI_BOTH);
    } else {

      /* Fermeture de la connexion */
      $this->deconnecter();
      return null;
    }
  }



  public function lireTousLesEnregistrements($requete)
  {
    if (!$this->connecter()) {
      echo 'connexion KO';
      return null;
    }

    /* Crée une requête préparée */
    if ($stmt = $this->connexion->prepare($requete)) {

      /* Exécution de la requête */
      if (!$stmt->execute()) {
        echo "Échec lors de l'exécution de la requête : (" . $stmt->errno . ") " . $stmt->error;
        $this->deconnecter();
        return null;
      }

      /* Lecture des variables résultantes */
      $result = $stmt->get_result();

      /* Fermeture du traitement */
      $this->deconnecter();
      return $result->fetch_all(MYSQLI_BOTH);
    } else {

      /* Fermeture de la connexion */
      $this->deconnecter();
      return null;
    }
  }


  /* Réalise les modifications de la BDD (insert, delete, update) 
  @args: $requete, $types des variables, $variables
  @return : true ou false suivant que la requete a réussi ou échoué

  types des variables : voir documentation bind_param()
  */
  public function actualiserEnregistrement()
  {
    if (!$this->connecter()) {
      echo 'connexion KO';
      return false;
    }

    $nb = func_num_args();
    $args = func_get_args();
//var_dump($args);
    if ($nb == 0 || $nb == 2) {
      echo "Nombre d'arguments incorrects";
      return false;
    }

    $requete = $args[0];

    if ($nb != 1) {
      $type = $args[1];
    }


    if ($stmt = $this->connexion->prepare($requete)) {

      switch ($nb) {
        case 1:
          break;
        case 3:
          $stmt->bind_param($type, $args[2]);
          break;
        case 4:
          $stmt->bind_param($type, $args[2], $args[3]);
          break;
        case 5:
          $stmt->bind_param($type, $args[2], $args[3], $args[4]);
          break;
        case 6:
          $stmt->bind_param($type, $args[2], $args[3], $args[4], $args[5]);
          break;
        case 7:
          $stmt->bind_param($type, $args[2], $args[3], $args[4], $args[5], $args[6]);
          break;
        case 8:
          $stmt->bind_param($type, $args[2], $args[3], $args[4], $args[5], $args[6], $args[7]);
          break;
        case 9:
          $stmt->bind_param($type, $args[2], $args[3], $args[4], $args[5], $args[6], $args[7], $args[8]);
          break;

        default:
          echo "Nombre d'arguments incorrects";
          return false;
      }

      /* Exécution de la requête */
      if (!$stmt->execute()) {
        echo "Échec lors de l'exécution de la requête : (" . $stmt->errno . ") " . $stmt->error;
        $this->deconnecter();
        return false;
      }

      /* Fermeture du traitement */
      $this->deconnecter();
      return true;
    } else {

      /* Fermeture de la connexion */
      $this->deconnecter();
      echo "Echec de préparation de la requete <br>";
      return false;
    }
  }
}
