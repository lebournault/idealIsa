<?php
class CParametresBDD {
  
  // paramètres d'accès à la base de donnée
  private $ip='localhost';
  private $port='3306';
  private $nomBase='flipbook';
  private $utilisateur='Dt5[uctF@A_048Nf';
  private $motDePasse='flipbook';

  // getters des paramètres
  
  public function getIp(){
    return $this->ip;
  }

  public function getPort(){
    return $this->port;
  }

  public function getNomBase(){
    return $this->nomBase;
  }

  public function getUtilisateur(){
    return $this->utilisateur;
  }

  public function getMotDePasse(){
    return $this->motDePasse;
  }
}

?>
