<?php

/**
 * \authors Courtin Alexis
 * \date 10/03/15
 * 
 * Description: Script qui se connecte a la base de donnée et permet de se connecter avec des identifiants et mots de passes.
 */

session_start();

if( isset( $_POST['submit'] ) || isset( $_POST['user'] ) || isset( $_POST['mdp'] ) ){
  // Connection base de donnée
  include("connexion.php");
  $id_bd = connexionBDD();

  // Recherche du login et mdp dans la base
  $req = "SELECT pseudo, password FROM user WHERE pseudo='".$_POST['user']."' and password='".$_POST['mdp']."';";
  
  $result = executionRequete( $id_bd, $req );

  if( !$result ){
    echo "Erreur dans la lecture de la base de donnee";
    return;
  }
  
  $row = mysqli_fetch_array( $result );

  if( $row[0] === $_POST['user'] && $row[1] === $_POST['mdp'] ){
    $_SESSION['session'] = true;
    $_SESSION['user'] = $row[0];
  }
  
}

if( !isset( $_SESSION['session'] ) ){
  ?>
  
<p> Connexion: </p>
<form method="post" submit="connec.php">
  Identifiant: <input type="text" name="user" /> <br/>
  Mot de passe: <input type="password" name="mdp" /> <br/>
  <input type="submit" name="submit" value="Se connecter !" /> <br/>
</form>
    
<?php
   
   } else {
   
   ?>
Bienvenu,
<?php
   echo $_SESSION['user'];
   ?>. 

<a href="deconnection.php"> Deconnection </a>

   <?php
   }
?>
