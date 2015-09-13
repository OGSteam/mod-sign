<?php
/**
 * uninstall.php Désinstall le mod
 * @package [MOD] sign
 * @author machine
 */
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

$mod_uninstall_name = "sign";
require_once('mod/'.$mod_uninstall_name.'/include/common.php');
$mod_uninstall_table = TABLE_SIGN_USERS.','.TABLE_SIGN_BAN;
uninstall_mod($mod_unistall_name, $mod_uninstall_table);

//'on supprime tous les fichier php du dossier cache'
$files = glob('mod/sign/compteur/*.txt');
foreach ($files as $filename){
	unlink($filename);
}



mod_del_all_option();
?>

