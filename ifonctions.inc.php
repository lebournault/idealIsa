<?php

function afficher_tableau($tableau,$titre="",$niveau=0) {

  // Paramètres
  //    - $tableau = tableau dont il faut afficher le contenu
  //    - $titre = titre à afficher au dessus du contenu
  //    - $niveau = niveau d'affichage

  // s'il y a un titre, l'afficher
  if ($titre != "") {
    echo "<P><B>$titre</B><BR>\n";
  }

  // tester s'il y des données
  if (isset($tableau)) { // il y a des données

    // parcourir le tableau passé en paramètre
    reset ($tableau);
    while (list ($cle, $valeur) = each ($tableau)) {

      // afficher la clé (avec indentation fonction 
      // du niveau)
      echo
        str_pad("",12*$niveau, "&nbsp;").
            htmlentities($cle)." = ";

      // afficher la valeur
      if (is_array($valeur)) { // c'est un tableau ...

        // mettre une balise <BR>
        echo "<BR>";
        // et appeler récursivement afficher_tableau pour 
        // afficher le tableau en question (sans titre et au
        // niveau supérieur pour l'indentation)
        afficher_tableau($valeur,"",$niveau+1);

      } else { // c'est une valeur scalaire

        // afficher la valeur
        echo htmlentities($valeur)."<BR>";

      }
      
    }

  } else { // pas de données

    // mettre une simple balise <BR>
    echo "<BR>\n";

  }

}

function vers_formulaire($valeur) {

  // affichage dans un formulaire

  // encoder tous les caractères HTML spéciaux
  //  - ENT_QUOTES : dont " et '
  return htmlentities($valeur,ENT_QUOTES,'UTF-8');

}


function vers_page($valeur) {

  // affichage direct dans une page

  // 1. encoder tous les caractères HTML spéciaux
  //  - ENT_QUOTES : dont " et '
  // 2. transformer les sauts de ligne en <BR>
  return nl2br(htmlentities($valeur,ENT_QUOTES,'UTF-8'));

}


function construire_requête($db,$sql) {

  // Récupérer le nombre de paramètre.
  $nombre_param = func_num_args();

  // Boucler sur tous les paramètres à partir du troisième
  // (le premier contient la requête de base).
  for($i=2;$i<$nombre_param;$i++) {

    // Récupérer la valeur du paramètre.
    $valeur = func_get_arg($i);

    // Si c'est une chaîne, l'échapper.
    if (is_string($valeur)) {
      $valeur = mysqli_escape_string($db,$valeur);
    }

    // Mettre la valeur à son emplacement %n (n = $i-1).
    $sql = str_replace('%'.($i-1),$valeur,$sql);

  }

  // Retourner la requête.
  return $sql;

}


function identifiant_unique() {

  // génération de l'identifiant
  return md5(uniqid(rand()));

}


function url($url) {

  // si la directive de configuration session.use_trans_sid 
  // est à 0 (pas de transmission automatique par l'URL) et 
  // si SID est non vide (le poste a refusé le cookie) alors
  // il faut gérer soi même la transmission

  if ((get_cfg_var("session.use_trans_sid") == 0) and (SID != "")) {
  
    // ajouter la constante SID derrière l'URL avec un ? 
    // s'il n'y a pas encore de paramètre ou avec un & dans
    // le cas contraire

    $url .= ((strpos($url,"?") === FALSE)?"?":"&").SID;

  }

  return $url;

}

?>
