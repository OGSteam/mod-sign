<?php
/**
 * @package [MOD] sign
 * @author machine
 */
if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

$mod_folder = "sign";
$mod_name = "sign";
require_once('mod/'.$mod_folder.'/include/common.php');



update_mod($mod_folder, $mod_name);

/// v 0.1.0 to 0.1.1
$requete = "SHOW COLUMNS FROM ".TABLE_SIGN_USERS." LIKE 'cible_id' ";
$result = $db->sql_query($requete);
if ( count($db->sql_fetch_assoc($result)) == 0)
{
	update_to_0_1_1();
}










function update_to_0_1_1()
{
	global $db;

	//modif table
	$query = 'ALTER TABLE `'.TABLE_SIGN_USERS.'` ADD `cible_id` INT(10) NOT NULL';
	$db->sql_query($query);

	// fix pb, toutes les anciennes sign pointent vers le createur ....
	$query = 'UPDATE `'.TABLE_SIGN_USERS.'`  SET `cible_id`= `player_id` ';
	$db->sql_query($query);

}
?>
