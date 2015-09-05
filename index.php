<?php
include "vue/header.php";

if (!isset($pub_subaction))
{
	$pub_subaction = "";
}
	
	
	
switch ($pub_subaction) {
	case "newsign":
		require_once  "mod/sign/vue/sign_new.php";
		break;
	case "admin":
		require_once  "mod/sign/vue/sign_admin.php";
		break;
	case "signedit":
		require_once  "mod/sign/vue/sign_edit.php";
		break;
	case "signdel":
		require_once  "mod/sign/vue/sign_del.php";
		break;
	case "help":
		require_once  "mod/sign/vue/sign_help.php";
		break;
	default:
		require_once  "mod/sign/vue/sign_player.php";
		break;
}

	
	
	


include "vue/footer.php";