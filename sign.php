<?php 
define("IN_SIGN", true);
define('IN_SPYOGAME', true);




//cf xtense
if (preg_match('#mod#', getcwd())) chdir('../../');
$_SERVER['SCRIPT_FILENAME'] = str_replace(basename(__FILE__), 'index.php', preg_replace('#\/mod\/(.*)\/#', '/', $_SERVER['SCRIPT_FILENAME']));
include("common.php");
require_once 'include/common.php';

$pub_action = "sign" ;
$refresh =  abs((int)mod_get_option("signCache")) * 60 *60 ;





$monUrl = explode("/",$_SERVER['REQUEST_URI']);
$idSplit = count($monUrl)-1;
$page = explode(".",$monUrl[$idSplit]);


$signID = $page[0];
$error = false;

// si pas  en base, on arrete,
// recuperation de la sign , laison sur cible_id et plus player_id
$requete = 'SELECT SU.* ,  U.user_id , U.user_stat_name as name FROM  '.TABLE_SIGN_USERS.' as SU INNER JOIN '.TABLE_USER.' as U ON SU.cible_id = U.user_id  WHERE sign_id='.$signID;
$result = $db->sql_query($requete);
$sign = $db->sql_fetch_assoc();
// si pas de reponse, redirection
if ($sign['sign_actif'] != 1)
{
	echo 'image desactivé ...';
	$error= true;
	exit();
}

if($db->sql_numrows() == 0)
{
	echo 'pas d image en base';
	$error= true;
	exit();
}


/// verifier si l image  n existe pas et si ne depasse pas la date de "cache"
$pathimg = "mod/sign/fond/cache/".$signID.".png";
if (file_exists($pathimg) && filemtime($pathimg) >  (time() -$refresh) )//l mage existe si elle ne depasse pas la tmeporisation on l affiche
{
	// ici on affiche l'image on ne la genere pas
	add_compteur($signID."_vue");
	header('Content-Type: image/png');
	readfile($pathimg);
	exit();
}

/// sinon généré ilmage via parser bbcode
$individual_ranking = galaxy_show_ranking_unique_player($sign['name'] );

$test = new signcode_parser( $sign['code']);
$value = individual_ranking_to_sign_code_ranking($individual_ranking , "player");
$value["player_name"] = $sign['name'];
$value["alliance_name"] = "A Implementer";

$test->set_value($value);

$test->run();


if($error ==  false)
{
	// on va sauvegarder l image
	// ici on affiche et genere l image
	add_compteur($signID."_vue");
	add_compteur($signID."_generate");
	imagepng($test->get_img(),$pathimg);
	$test->affiche();
	exit();

}


exit();