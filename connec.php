<?php
	session_start();
	
	if( !isset( $_SESSION['session'] ) ){
?>

<p> Connexion: </p>
<form method="post" submit="connec.php">
	Identifiant: <input type="text" name="user" /> <br/>
	Mot de passe: <input type="password" name="mdp" /> <br/>
	<input type="submit" name="submit" value="Se connecter !" /> <br/>
</form>

<?php
	} else{
?>
Bienvenu,
<?php
	echo $_SESSION['user'];
?>. 

<a href="deconnection.php"> Deconnection </a>

<?php
	}
	
	if( isset( $_POST['submit'] ) || isset( $_POST['user'] ) || isset( $_POST['mdp'] ) ){		
			// Connection base de donnée
			include("connex.inc.php");
			$id_bd = connex( "projet_s4", "myparam" );
			
			// Recherche du login et mdp dans la base
			$req = "SELECT pseudo, password FROM user WHERE pseudo='".$_POST['user']."' and password='".$_POST['mdp']."';";
						
			$result = @mysqli_query( $id_bd, $req );
			if( !$result ){
				echo "Erreur dans la lecture de la base de donnee";
				return;
			}
			
			$row = mysqli_fetch_array( $result );
			
			if( $row[0] == $_POST['user'] && $row[1] == $_POST['mdp'] ){
				$_SESSION['session'] = true;
				$_SESSION['user'] = $row[0];
			}
			
	}
?>