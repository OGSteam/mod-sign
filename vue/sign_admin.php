<?php
/**
 * @package [MOD] sign
 * @author machine
 */
if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

if (!(defined('IN_SPYOGAME') || defined('IN_SIGN')) )
{
	die("Hacking Attempt!");
}

// vérification des droits
if ($user_data['user_admin'] != 1 && $user_data['user_coadmin'] != 1) {
	redirection('index.php?action=message&id_message=forbidden&info');
}

// recuperation de la variable si besoin est
if (isset($pub_signCache))
{
	mod_set_option("signCache", abs((int)$pub_signCache));// en heure

}


// recuperation de la variable si besoin est
if (isset($pub_delcache))
{
	//'on supprime tous les fichier php du dossier cache'
	$files = glob('mod/sign/fond/cache/*.png');
	foreach ($files as $filename){
		unlink($filename);
	}

}

if(isset($pub_htaccess))
{

	$monht = fopen('mod/sign/.htaccess', 'r+');
	ftruncate($monht,0);
	fputs($monht, utf8_decode (trim($pub_htaccess))) ;

	fclose($monht);
}


?>


<form method="POST" action="index.php?action=sign&subaction=admin">
	<table width="800">
		<tr>
			<td class="c_tech" colspan="2">Information Serveur</td>
		</tr>

		<tr>

			<th>Vous devez voir une image :</th>
			<th><?php echo '<img src="mod/sign/vue/testgd.php" width="36" height="36" alt="image de test" title="image de test">';?>
			</th>

		</tr>


		<tr>
			<th colspan="2"><?php 
			if(function_exists("gd_info")) $composants_gd = gd_info();
			if ($composants_gd['GD Version']) {
				echo 'GD Version : ',$composants_gd['GD Version'],'<br />';
					
				// vérification du support des PNG
				if ($composants_gd['PNG Support']) {
					echo '<span style="font-weight: 800;color: green;">Support des PNG activé !</span>';
				}
			} else {
				echo '<span style="font-weight: 800;color: red;">La librairie GD n\'est pas activée ! le mod ne pourra pas fonctionner !</span>';
			}
			?></th>
		</tr>


		<tr>
			<th colspan="2"><?php
			$filename = 'mod/sign/fond/cache';
			if (is_writable($filename)) {
				echo '<span style="font-weight: 800;color: green;">Le dossier est accessible en écriture.</span>';
			} else {
				echo '<span style="font-weight: 800;color: red;">Le dossier n\'est pas accessible en écriture !</span>';
			}
			?>
			</th>
		</tr>


		<tr>
			<td class="c_tech" colspan="2">Configuration</td>
		</tr>



		<tr>

			<th>Temps de cache (heure)</th>
			<th><input name="signCache"
				value="<?php echo abs((int)mod_get_option("signCache")); ?>"
				type="textbox">
			</th>

		</tr>

		<tr>

			<th>Effacer cache</th>
			<th><input name="delcache" value="1" type="checkbox">
			</th>
		</tr>


		<?php if(isset($pub_delcache)) :?>
		<tr>
			<th colspan="2"><span style="font-weight: 800; color: red;">Cache
					supprimé.</span>
			</th>
		</tr>
		<?php endif;?>


		<tr>
			<td class="c_tech" colspan="2">.htaccess</td>
		</tr>
		<tr>
			<td colspan="2">indiquer la bonne valeur errorDocument<br /> c'est le
				chemin complet depuis la racine !<br /> ce n'est PAS à partir de
				"http"...<br /> ne pas oublier le "/" au début du chemin<br /> un
				exemple, si votre serveur est à l'adresse
				http://hébergeur.fr/login/OGSpy/<br /> la ligne sera de la forme :
				ErrorDocument 404 /OGSpy/mod/sign/sign.php<br /> <br />


			</td>
		</tr>
		<tr>

			<th colspan="2">Valeurs possibles ErrorDocument : <br /> <?php $shtaccess = str_replace("/vue", "",  dirname (__FILE__) )."/sign.php";?>
				<?php $ahtaccess  = explode("/", $shtaccess)?> <?php $ahtaccess = array_reverse($ahtaccess)?>
				<?php $temps = "";?> <?php foreach ($ahtaccess as $value):?> <?php if ($temps == "" ){
					$temps = $value;
				}else {$temps = $value."/".$temps;
				}?> <?php echo "/".$temps ;?> <br /> <?php endforeach ;?> <br /> <br />
				ELLE DOIT ABSOLUMENT ETRE INSCRITE CI-DESSOUS !!!<br /> <br />


			</th>
		</tr>
		</tr>
		<tr>
			<th colspan="2"><textarea rows="10" cols="200" name="htaccess">
					<?php echo file_get_contents('mod/sign/.htaccess'); ?>
				</textarea></th>
		
		
		<tr>
		
		
		<tr>
			<th colspan="2"><input type="submit" value="Submit">
			</th>
		</tr>


	</table>
</form>

