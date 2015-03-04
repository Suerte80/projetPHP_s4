<?php
	session_start();
?>

<script type="text/javascript">
	function verif_inscription()
	{
		var b = true;
		if( document.forms.form.user.value == "" ){
			document.getElementById("user_th").style.color = "red";
			b = false;
		}
		if( document.forms.form.mdp.value != document.forms.form.mdp_.value ){
			document.getElementById("mdp_th").style.color = "red";
			document.getElementById("mdp__th").style.color = "red";
			b = false;
		}
		if( document.forms.form.lastname.value == "" ){
			document.getElementById("lastname_th").style.color = "red";
			b = false;
		}
		if( document.forms.form.name.value == "" ){
			document.getElementById("name_th").style.color = "red";
			b = false;
		}
		if( document.forms.form.mail.value == "" ){
			document.getElementById("mail_th").style.color = "red";
			b = false;
		}
		if( document.forms.form.adress.value == "" ){
			document.getElementById("adress_th").style.color = "red";
			b = false;
		}
		if( document.forms.form.city.value == "" ){
			document.getElementById("city_th").style.color = "red";
			b = false;
		}
		if( document.forms.form.zipcode.value == "" ){
			document.getElementById("zipcode_th").style.color = "red";
			b = false;
		}
		if( !/^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}/.test( document.forms.form.mail.value ) ){
			alert("Adresse mail incorrecte !");
			b = false;
		}
		if( !/[0-9]{5}/.test( document.forms.form.zipcode.value ) ){
			alert("Code postale incorrecte !");
			b = false;
		}
		
		return true && b;
	}
	
</script>

<?php
	
	if( isset( $_SESSION['session'] ) && $_SESSION['session'] ){
?>

<p>Vous etes deja connecter !</p>

<?php
	} else if( isset( $_POST['user'] ) && isset( $_POST['mdp'] ) ){
		include("connex.inc.php");
		/* Connection a la base de donnée */
		$id_bd = connex("projet_s4", "myparam");
		
		/* Vérification qu'il n'y est pas de doublon dans la BDD */
		$req = "SELECT pseudo, mail FROM user where pseudo='".$_POST['user']."';";
		$result = @mysqli_query( $id_bd, $req );
		if( !$result ){
			echo "Erreur lors de la lecture de la base de donnee.";
			return;
		}
		
		/* Si pas de doublon alors on inscrit le Mr/Mme dans la BDD */
		$row = mysqli_fetch_array( $result );
		if( $row[0] == $_POST['user'] ){
			echo "Nom utilisateur deja utilise !";
		} else if( $row[1] == $_POST['mail'] ){
			echo "Adresse mail d&eacute;j&agrave; utilis&eacute; !";
		} else{ // Inscription dans la bdd
			
			if( $_POST['description'] != "" ){
				$req = "INSERT INTO `projet_s4`.`user` (`id_user`, `pseudo`, `password`, `last_name`, `name`, `description`, `mail`, `adress`, `city`, `zip`) VALUES (NULL, '".$_POST['user']."', '".$_POST['mdp']."', '".$_POST['lastname']."', '".$_POST['name']."','".$_POST['description']."', '".$_POST['mail']."', '".$_POST['adress']."', '".$_POST['city']."', '".$_POST['zipcode']."' );";	
			} else{
				$req = "INSERT INTO `projet_s4`.`user` (`id_user`, `pseudo`, `password`, `last_name`, `name`, `mail`, `adress`, `city`, `zip`) VALUES (NULL, '".$_POST['user']."', '".$_POST['mdp']."', '".$_POST['lastname']."', '".$_POST['name']."', '".$_POST['mail']."', '".$_POST['adress']."', '".$_POST['city']."', '".$_POST['zipcode']."' );";
			}
			
			$result = @mysqli_query( $id_bd, $req );
			if( !$result ){
				echo "Impossible de vous identifier !";
				return;
			}
			header("location:start.php");
		}
		
	} else{
	
?>

<form method="POST" submit="enregistrement.php" name="form" onSubmit="return verif_inscription()">

	<table border="0">
		<tr align="left"> <th>Enregistremenent: </th></tr>
		<tr align="left">
			<th id="user_th">Nom d'utilisateur: (*)</th>
			<td><input type="text" name="user"/> <br/></td>
		</tr>
		<tr align="left">
			<th id="mdp_th">Mot de passe: (*)</th>
			<td><input type="password" name="mdp"/> <br/></td>
		</tr>
		<tr align="left">
			<th id="mdp__th">R&eacute;p&eacute;ter mot de passe: (*)</th>
			<td><input type="password" name="mdp_"/> <br/></td>
		</tr>
		<tr align="left">
			<th id="lastname_th">Nom: (*)</th>
			<td><input type="text" name="lastname" /> <br/></td>
		</tr>
		<tr align="left">
			<th id="name_th">Pr&eacute;nom: (*)</th>
			<td><input type="text" name="name" /> <br/></td>
		</tr>
		<tr align="left">
			<th id="mail_th">Adresse mail: (*)</th>
			<td><input type="text" name="mail" /> <br/></td>
		</tr>
		<tr align="left">
			<th id="adress_th">Adresse: (*)</th>
			<td><input type="text-area" name="adress" /> <br/></td>
		</tr>
		<tr align="left">
			<th id="city_th">Ville: (*)</th>
			<td><input type="text" name="city" /> <br/></td>
		</tr>
		<tr align="left">
			<th id="zipcode_th">Code postal: (*)</th>
			<td><input type="text" name="zipcode" /> <br/></td>
		</tr>
		<tr align="left">
			<th id="description_th">Description: </th>
			<td><input type="text" name="description" /> <br/></td>
		</tr>
		<tr align="center">
			<td><input type="submit" name="submit" value="Enregistrement !"/> <br/> </td>
		</tr>
	</table>
	
</form>

<?php
	
	}
?>
