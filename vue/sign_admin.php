<?php
if (!(defined('IN_SPYOGAME') || defined('IN_SIGN')) )
{
	die("Hacking Attempt!");
}

// vérification des droits
// vérification des droits
if ($user_data['user_admin'] != 1 && $user_data['user_coadmin'] != 1) {
	redirection('index.php?action=message&id_message=forbidden&info');
}

// recuperation de la variable si besoin est
if (isset($pub_signCache))
{
	mod_set_option("signCache", $pub_signCache);// en heure

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




?>


<form method="POST" action="index.php?action=sign&subaction=admin">
	<table width="300">
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
				value="<?php echo mod_get_option("signCache"); ?>" type="textbox"></th>

		</tr>

		<tr>

			<th>Effacer cache</th>
			<th><input name="delcache" value="1" type="checkbox"></th>
		</tr>

		
		<?php if(isset($pub_delcache)) :?>
		<tr>
			<th  colspan="2"><span style="font-weight: 800;color: red;">Cache supprimé.</span>			</th>
		</tr>
		<?php endif;?>
		
		
		
		
		
		
		<tr>
			<th colspan="2"><input type="submit" value="Submit">
			</th>
		</tr>


	</table>
</form>

