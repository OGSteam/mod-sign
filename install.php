<?php
/**
 * @package [MOD] sign
 * @author machine
 */
if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}
// Ajout du module dans la table des mod de OGSpy
$is_ok = false;
$mod_folder = "sign";
$is_ok = install_mod($mod_folder);
if ($is_ok == true) {
	require_once('mod/'.$mod_folder.'/include/common.php');
	 
	// création table pour les signatures
	$db->sql_query("CREATE TABLE IF NOT EXISTS ".TABLE_SIGN_USERS." (
			`sign_id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
			`player_id` INT( 255 ) NOT NULL  ,
			`cible_id` INT( 255 ) NOT NULL  ,
			`sign_actif` INT( 11 ) NOT NULL ,
			`code` TEXT NOT NULL ,
			PRIMARY KEY ( `sign_id` )
	) DEFAULT CHARSET=utf8;");


	mod_set_option("signCache", "10");// en heure

	// il faut également copier un fichier htaccess
	if (!file_exists("mod/sign/.htaccess"))
	{
		copy("mod/sign/sign.htaccess", "mod/sign/.htaccess");
	}



} else {
	echo "<script>alert(\"Désolé, un problème a eu lieu pendant l'installation, corrigez les problèmes survenue et réessayez.\");</script>";
}

