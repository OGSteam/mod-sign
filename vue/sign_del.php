<?php
/**
 * @package [MOD] sign
 * @author machine
 */
if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

$player_id=$user_data['user_id'];// récuperation de l id_player

//présence d un id signature
if (!isset($pub_sign_id))
{
	echo '<SCRIPT LANGUAGE="JavaScript">';
	echo 'document.location.href="index.php?action=sign"';
	echo '</SCRIPT>';
	exit();
}
$sign_id = (int)$pub_sign_id;// récuperation du sign_id

// vérification que la sign lui appartienne sinon redirection
$requete = 'SELECT  sign_actif , 	code  FROM  '.TABLE_SIGN_USERS.' WHERE sign_id='.$sign_id.' AND player_id ='.$player_id;
$result = $db->sql_query($requete);
// si pas de reponse, redirection
if($db->sql_numrows() == 0)
{
	echo '<SCRIPT LANGUAGE="JavaScript">';
	echo 'document.location.href="index.php?action=sign"';
	//echo '$db->sql_numrows() == 0"';
	echo '</SCRIPT>';
	exit();
}


/// il y a bien un id, celui ci correspond a l user / sign

$requete =' DELETE FROM  '.TABLE_SIGN_USERS.'   WHERE sign_id='.$sign_id.' AND player_id ='.$player_id;
$db->sql_query($requete);
echo '<SCRIPT LANGUAGE="JavaScript">';
echo 'document.location.href="index.php?action=sign"';
echo '</SCRIPT>';
exit();
