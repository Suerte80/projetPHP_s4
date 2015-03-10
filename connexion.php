<?php

function connexionBDD()
/* Fonction qui se connecte a la base de donnée */
{
  include("connex.inc.php");

  $id_bd = connex( "projet_s4", "myparam" );	
  
  if( !$id_bd )
    $connec = false;  

  return $id_bd;
}

function executionRequete( $id_bd, $requete )
{ 
  $result = @mysqli_query( $id_bd, $requete );
  
  return $result;
}

?>
