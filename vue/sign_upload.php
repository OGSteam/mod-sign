<?php 
// vérification des droits
if ($user_data['user_admin'] != 1 && $user_data['user_coadmin'] != 1) {
	redirection('index.php?action=message&id_message=forbidden&info');
}
$message ="";
if (!empty($_FILES))
{
	$nom = explode(".",$_FILES['file']['name'])[0];
	$size = $_FILES['file']['size'];
	$type = $_FILES['file']['type'];
	$tmp = $_FILES['file']['tmp_name'];

	$valid_file = true;
	if($_FILES['file']['error'])
	{
		$valid_file = false;
		$message = 'Erreur native';
	}

	if($size > (102400))
	{
		$valid_file = false;
		$message = 'Erreur de taille !!!';
	}
	if(! ctype_alnum($nom))
	{
		$valid_file = false;
		$message = 'Erreur dans le nom !!!';
	}
	if($type != 'image/png' )
	{
		$valid_file = false;
		$message = 'Erreur de type/mime  !!!';
	}
	if(explode(".",$_FILES['file']['name'])[1] != 'png' ) // a priori as utile
	{
		$valid_file = false;
		$message = 'Erreur dans l extension  !!!';
	}



	//if the file has passed the test
	if($valid_file)
	{
		//move it to where we want it to be
		move_uploaded_file($tmp, 'mod/sign/fond/default/'.$nom.'.png');
		$message = 'Success  !';
	}



}




?>
<?php if (!empty($_FILES)) :?>
<?php if ($message != "") :?>
<h2>
	<?php  echo $message ; ?>
</h2>
<?php endif;?>
<?php endif;?>
<form method="POST" action="index.php?action=sign&subaction=upload"
	enctype="multipart/form-data">
	<table width="800">
		<tr>
			<th colspan="2">Regle d'upload :</th>
		</tr>
		<tr>
			<th colspan="2">Fichier .png uniquement <br /> Taille max : 100 kB<br />
				Caractere alphanumerique uniquement<br />
			</th>
		</tr>


		<th>Fichier : <input type="file" name="file">
		</th>
		<th><input type="submit" name="envoyer" value="Envoyer le fichier">
		</th>
		</tr>




	</table>

</form>
