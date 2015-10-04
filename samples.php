<?php 
define("IN_SIGN", true);
define('IN_SPYOGAME', true);

// TODO mettre ca en base ulterieurement
$refresh = 2 ; // en seconde



//cf xtense
if (preg_match('#mod#', getcwd())) chdir('../../');
$_SERVER['SCRIPT_FILENAME'] = str_replace(basename(__FILE__), 'index.php', preg_replace('#\/mod\/(.*)\/#', '/', $_SERVER['SCRIPT_FILENAME']));
include("common.php");
require_once 'include/common.php';

$pub_id= (int)$pub_id;
$pub_player= (int)$pub_player;

$samples = get_samples();


// recuperation info player
$requete = 'SELECT  U.user_stat_name as name FROM   '.TABLE_USER.' as U   WHERE user_id='.$pub_player;
$result = $db->sql_query($requete);
$sign = $db->sql_fetch_assoc();


// récuperation du nom de l 'alliance
$sign['ally'] =  "";
$request = "select ally from " . TABLE_RANK_PLAYER_POINTS . "  where player = '".$sign['name']."' order by datadate DESC LIMIT 1 ";
$result = $db->sql_query($request);
while ($row = $db->sql_fetch_assoc($result)) {
	if ($row["ally"] != "")
		$sign['ally'] = $row["ally"];
}






$test = new signcode_parser( $samples[$pub_id][2]);
/// sinon généré ilmage via parser bbcode
$individual_ranking = galaxy_show_ranking_unique_player($sign['name'] );
$value = individual_ranking_to_sign_code_ranking($individual_ranking, "player" );
$value["player_name"] = $sign['name'];
$value["alliance_name"] =$sign['ally'] ;

$test->set_value($value);

$test->run();

$test->affiche();
