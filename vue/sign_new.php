<?php
/**
 * @package [MOD] sign
 * @author machine
 */
if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

$requete = 'INSERT INTO '.TABLE_SIGN_USERS.' (player_id, cible_id , sign_actif, code) VALUES ('.$user_data['user_id'].', '.$user_data['user_id'].',  0 ,""  )';
$db->sql_query($requete);
//redirection sur la sign créé
$id = (int)$db->sql_insertid();
?>
<SCRIPT LANGUAGE="JavaScript">
     document.location.href="index.php?action=sign&subaction=signedit&sign_id=<?php echo $id ; ?>"
</SCRIPT>
