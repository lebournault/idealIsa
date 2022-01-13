<?php
require_once 'CBdd.php';

class CGestionTables {

  private $bdd;	//association vers la classe CBddIdealIsa
  public function __construct(){
    $this->bdd = new CBdd();
  }

  public function lireConventionsParIdEtudiant($idEtudiant){
    if($this->bdd->connecter()) {
      return $this->bdd->executerRequeteQuery("select * from tableperiodesstages  WHERE `tableperiodesstages`.`idEtudiant` = " . $idEtudiant);

    } else {
      echo 'connexion KO';
      return null;
    }

  }

  public function lireUneConventionParId($idPeriodeStage){
    if($this->bdd->connecter()) {
      $lesEnregistrements = $this->bdd->executerRequeteQuery("select * from tableperiodesstages  WHERE `tableperiodesstages`.`idPeriodeStage` = " . $idPeriodeStage);
      if (isset($lesEnregistrements[0])){   // si l'enregistrement 0 existe 
        return $lesEnregistrements[0];
      } else {
        echo 'connexion KO';
        return null;
      }

    }
  }
  

  public function lireEntrepriseParId($idEntreprise){
    if($this->bdd->connecter()) {

      $lesEnregistrements = $this->bdd->executerRequeteQuery("select * from tableentreprises  WHERE `tableentreprises`.`idEntreprise` = " . $idEntreprise);
      if (isset($lesEnregistrements[0])){   // si l'enregistrement 0 existe (idEntreprise présent dans tableentreprises)
        return $lesEnregistrements[0];
      } 
      else {
        return null;
      }    

    } else {
      echo 'connexion KO';
      return null;
    }

  }

  public function lireEntreprises(){
    if($this->bdd->connecter()) {
      return $this->bdd->executerRequeteQuery("select * from tableentreprises");
    } else {
      echo 'connexion KO';
      return null;
    }

  }

  public function lirePersonneParId($idPersonne){
    if($this->bdd->connecter()) {

      $lesEnregistrements = $this->bdd->executerRequeteQuery("select * from tablepersonnes  WHERE tablepersonnes.idPersonnes = " . $idPersonne);
      if (isset($lesEnregistrements[0])){   // si l'enregistrement 0 existe (id dans tabletuteursentreprise)
        return $lesEnregistrements[0];
      } 
      else {
        return null;
      }              

    } else {
      echo 'connexion KO';
      return null;
    }
  }

  public function lirePersonnesParRole($role){
     if($this->bdd->connecter()) {
      return $this->bdd->executerRequeteQuery("select * from tablepersonnes  WHERE tablepersonnes.role = " . "'".$role."'");

    } else {
      echo 'connexion KO';
      return null;
    }
  }

  
  public function AjouterConvention($idEtudiant, $idPersonnelPedagogique, $idTuteurEntreprise, $idEntreprise, $dateDebut, $dateFin, $dureeHebdomadaire){
    if($this->bdd->connecter()) {
     $this->bdd->executerRequeteUpdate("INSERT INTO `tableperiodesstages` (`idEtudiant`, `idPersonnelPedagogique`, `idTuteurEntreprise`, `idEntreprise`, `sujet`, `dateDebut`, `dateFin`, `dureeHebdomadaire`, `etatConvention`) VALUES ('".$idEtudiant."', '".$idPersonnelPedagogique."', '".$idTuteurEntreprise."', '".$idEntreprise."', 'Non renseigné', '".$dateDebut."', '".$dateFin."', '".$dureeHebdomadaire."', 'Non signée')");
    }
  }

}
?>
