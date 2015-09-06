<?php 
define("IN_SIGN", true);
define('IN_SPYOGAME', true);




//cf xtense
if (preg_match('#mod#', getcwd())) chdir('../../');
$_SERVER['SCRIPT_FILENAME'] = str_replace(basename(__FILE__), 'index.php', preg_replace('#\/mod\/(.*)\/#', '/', $_SERVER['SCRIPT_FILENAME']));
include("common.php");
require_once 'include/common.php';

// TODO mettre ca en base ulterieurement
//global $pub_action;
$pub_action = "sign" ;
$refresh =  ((int)mod_get_option("signCache")) * 60 *60 ; 





$monUrl = explode("/",$_SERVER['REQUEST_URI']); 
$idSplit = count($monUrl)-1; 
$page = explode(".",$monUrl[$idSplit]);

//var_dump($monUrl);
//var_dump($idSplit);
//var_dump($page);

//exit();

$signID = $page[0];
$error = false; 

// si pas d ilge en base, on arrete,
// vérification que la sign lui appartienne sinon redirection
$requete = 'SELECT SU.* ,  U.user_id , U.user_stat_name as name FROM  '.TABLE_SIGN_USERS.' as SU INNER JOIN '.TABLE_USER.' as U ON SU.player_id = U.user_id  WHERE sign_id='.$signID;
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
	header('Content-Type: image/png');
	readfile($pathimg);
	exit();
}

/// sinon généré ilmage via parser bbcode
$individual_ranking = galaxy_show_ranking_unique_player($sign['name'] ,TRUE);

$test = new signcode_parser( $sign['code']);




$test->set_value(individual_ranking_to_sign_code_ranking($individual_ranking , "player"));

//var_dump(individual_ranking_to_sign_code_ranking($individual_ranking , "player"));
//echo "\$tabempty = array(<br />";
//foreach(individual_ranking_to_sign_code_ranking($individual_ranking , "player") as $key => $value)
//{
//	echo "\"$key\" => \"?\" , <br />";
//}



//echo ")<br />";
$test->run();



//var_dump(explode(PHP_EOL, $sign['code']));
//var_dump($sign);
//var_dump($test);
//var_dump($sign);
//var_dump($test);




//if (preg_match('#mod#', getcwd())) chdir('../../');
//$_SERVER['SCRIPT_FILENAME'] = str_replace(basename(__FILE__), 'index.php', preg_replace('#\/mod\/(.*)\/#', '/', $_SERVER['SCRIPT_FILENAME']));
//include("common.php");
//list($root, $active) = $db->sql_fetch_row($db->sql_query("SELECT root, active FROM ".TABLE_MOD." WHERE action = 'sign'"));



//Obtenir son classement

//$error = true;

if($error ==  false)
{
// on va sauvegarder l image
	imagepng($test->get_img(),$pathimg);
	$test->affiche();
	exit();
//header('Content-Type: image/png');
//readfile("fond/default/default.png");
//exit();	
}


exit();
$my_img = imagecreate( 200, 80 );
$background = imagecolorallocate( $my_img, 0, 0, 255 );
$text_colour = imagecolorallocate( $my_img, 255, 255, 0 );
$line_colour = imagecolorallocate( $my_img, 128, 255, 0 );
imagestring( $my_img, 4, 30, 25, "thesitewizard.com", $text_colour );
imagesetthickness ( $my_img, 5 );
imageline( $my_img, 30, 45, 165, 45, $line_colour );

header( "Content-type: image/png" );
imagepng( $my_img );
imagecolordeallocate( $line_color );
imagecolordeallocate( $text_color );
imagecolordeallocate( $background );
imagedestroy( $my_img );
$my_img = imagecreate( 200, 80 );
$background = imagecolorallocate( $my_img, 0, 0, 255 );
$text_colour = imagecolorallocate( $my_img, 255, 255, 0 );
$line_colour = imagecolorallocate( $my_img, 128, 255, 0 );
imagestring( $my_img, 4, 30, 25, "thesitewizard.com", $text_colour );
imagesetthickness ( $my_img, 5 );
imageline( $my_img, 30, 45, 165, 45, $line_colour );

