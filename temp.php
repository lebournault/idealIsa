public function supprimerTousLesEnregistrements($requete)
  {
    if (!$this->connecter()) {
      echo 'connexion KO';
      return false;
    }

    /* Crée une requête préparée */
    if ($stmt = $this->connexion->prepare($requete)) {

      /* Exécution de la requête */
      if (!$stmt->execute()) {
        echo "Échec lors de l'exécution de la requête : (" . $stmt->errno . ") " . $stmt->error;
        $this->deconnecter();
        return false;
      }

      /* Lecture des variables résultantes */
      $result = $stmt->get_result();

      /* Fermeture du traitement */
      $this->deconnecter();
      return true;
    } else {

      /* Fermeture de la connexion */
      $this->deconnecter();
      return false;
    }
  }

  public function supprimerUnEnregistrementParId($requete, $id)
  {
    if (!$this->connecter()) {
      echo 'connexion KO';
      return false;
    }

    /* Crée une requête préparée */
    if ($stmt = $this->connexion->prepare($requete)) {

      /* Lecture des marqueurs */
      $stmt->bind_param("i", $id);

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
      return false;
    }
  }

  public function insererEnregistrement($requete)
  {
    if (!$this->connecter()) {
      echo 'connexion KO';
      return false;
    }
    if (!$this->connexion->query($requete)) {
      printf("Erreur : %s\n", $this->connexion->error);
      return false;
    }
    return true;
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
     //a tester
      $stmt->bind_param("isisb", $id, $img_nom, $img_taille, $img_type, addslashes($img_blob));
      //$stmt->send_long_data(0, $img_blob);

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