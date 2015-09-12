<?php
if (!(defined('IN_SPYOGAME') || defined('IN_SIGN')) )
{
	die("Hacking Attempt!");
}




global $table_prefix;

define('TABLE_SIGN_USERS', $table_prefix.'sign_users');


if (file_exists('mod/sign/include/bbcode_parser.php'))
{
	include_once 'mod/sign/include/bbcode_parser.php';
}
else
{
	include_once 'include/bbcode_parser.php';
}






function get_samples()
{
	$types = array('general', 'eco' , 	'techno' , 'military' , 'military_b' , 'military_l' , 'military_d' , 'honnor' );





	$samples = array();
	$samples[] = array("[fond]", "Selection d un fond deja present" ,"[fond]default.png[/fond]" );
	$samples[] = array("[fond]", "Création d un fond" ,"[fond=350,90][/fond]" ,1);
	$samples[] = array("[color]", "Passe en mémoire un couleur ( rgb) <br /> Cette variable est utilisée par les autres balises." ,"[color=120,125,120]color1[/color]" );
	$samples[] = array("[line]", "Dessine une ligne Il faut indiquer le point d'origine et le point d'arrivé <br />Cette balise utilise une balise color." ,"[fond=350,90][/fond]\r\n[color=120,200,120]color2[/color]\r\n[color=255,0,10]color1[/color]\r\n[line=0,0,50,70]color2[/line]\r\n[line=0,25,200,25]color1[/line]\r\n" );
	$samples[] = array("[rectangle]", "Dessine un rectangle Il faut indiquer le point d'origine et le point d'arrivé <br />Cette balise utilise une balise color." ,"[fond=200,200][/fond]\r\n[color=120,200,120]color2[/color]\r\n[color=255,0,10]color1[/color]\r\n[rectangle=50,50,40,40,color1]\r\n" );
	$samples[] = array("[rectanglefilled]", "Dessine un rectangle plein Il faut indiquer le point d'origine et le point d'arrivé <br />Cette balise utilise une balise color." ,"[fond=200,200][/fond]\r\n[color=120,200,120]color2[/color]\r\n[color=255,0,10]color1[/color]\r\n[rectanglefilled=50,50,100,100,color1]\r\n" );
	$samples[] = array("[rectanglefilled]<br />[rectangle]", "Faire un effet" ,"[fond=230,220][/fond]\r\n[color=120,120,120]color2[/color]\r\n[color=200,200,200]color1[/color]\r\n[rectanglefilled=50,50,100,100,color2]\r\n[rectangle=50,50,100,100,color1]\r\n[rectanglefilled=150,150,200,200,color2]\r\n[rectanglefilled=152,152,201,201,color1]\r\n" );
	$samples[] = array("[string]", "Ecrit du texte <br />Il faut preciser la taille ( entre 1 et 5 ), le point d origine <br />Cette balise utilise une balise color." ,"[fond=350,90][/fond]\r\n[color=120,200,120]color2[/color]\r\n[string=3,100,50,color2]test[/string]\r\n[string=5,100,70,color2]CONCLUANT[/string]\r\n" );
	$samples[] = array("[stringeffect]", "Ecrit du texte <br />Il faut preciser la taille ( entre 1 et 5 ) ainsi que le type d effet  (1  ou 2 ), le point d origine <br />Cette balise utilise une balise color." ,"[fond=350,90][/fond]\r\n[color=120,200,120]color2[/color]\r\n[color=150,150,150]color1[/color]\r\n[stringeffect=3,100,50,color2,color1,1]test[/stringeffect]\r\n[stringeffect=5,100,70,color2,color1,2]CONCLUANT[/stringeffect]\r\n" );
	//$samples[] = array("[degrade]", "Dessine un degradé de couleur <br />Il faut preciser les cotes du rectangle à dessiner ainsi que le sens du degradé 'h' ou 'v' et la couleur de debut et de fin <br />Cette balise utilise deux balises color." ,"[fond=350,90][/fond]\r\n[color=255,0,0]color2[/color]\r\n[color=0,0,255]color1[/color]\r\n[degrade=20,20,300,85,v,color1,color2]\r\n\r\n" );
	

	$var = "";
	for ($i = 0 ; $i <  count($types) ; $i++)
	{
		foreach ($types as $type)
		{
			$tmp_i = 90 + $i *45;
			$tmp_i2 = 90 + 10 + $i *45;
			$tmp_i3 = 90 + 20 + $i *45;
			$var = $var." [string=2,10,".$tmp_i.",color2]".$types[$i]." : [/string]";
			$var = $var." [string=2,10,".$tmp_i2.",color2] RANK  : [var=P_rank_".$types[$i]."_a] | [var=P_rank_".$types[$i]."_b] | [var=P_rank_".$types[$i]."_c] [/string]";
			$var = $var." [string=2,10,".$tmp_i3.",color2] POINT : [var=P_points_".$types[$i]."_a] | [var=P_points_".$types[$i]."_b] |  [var=P_points_".$types[$i]."_c] [/string]";
				
		//	'P_rank_general_a' => string '212' (length=3)
		//	'P_rank_general_b' => string '212' (length=3)
		//	'P_rank_general_c' => string '212' (length=3)
		//	'P_points_general_a' => string '22163742' (length=8)
		//	'P_points_general_b' => string '22 163 742' (length=10)
		//	'P_points_general_c' => string '22.163.742' (length=10)
			
		//	$var = $var." [string=2,10,".$tmp_i.",color2]".$types[$i]."  : [player=".$types[$i].",rank,0][/string] | [player=".$types[$i].",rank,1][/string] | [player=".$types[$i].",rank,2][/string]";
			//$var = $var." [string=2,10,".$tmp_i2.",color2]".$types[$i]."  : [player=".$types[$i].",rank,0][/string] | [player=".$types[$i].",rank,1][/string] | [player=".$types[$i].",rank,2][/string]";
		//	$var = $var." [string=2,10,".$tmp_i3.",color2]".$types[$i]."  : [player=".$types[$i].",points,0][/string] /r/n [player=".$types[$i].",points,1][/string] | [player=".$types[$i].",points,2][/string]";

				
		}

	}
	$samples[] = array("[var]", "Retourne les infomations du joueurs <br />Il faut preciser le type d'information recherché aisi que le type de formatage   (0,1  ou 2)." ,
			"[fond=350,800][/fond]\r\n[color=120,200,120]color2[/color]\r\n
			[string=2,10,1,color2]Date en cours : [var=P_date_a] ou [var=P_date_b][/string]
			[string=2,10,30,color2]Nom joueur : [var=player_name] ! [/string]
			[string=2,10,50,color2]Alliance joueur : [var=alliance_name][/string]
			
			[string=4,10,80,color2]classement joueur : [/string]".$var );
//	$retour[$type."_date_a"] = date("d/m/Y", $date_key);
	//$retour[$type."_date_b"]

	//$samples[] = array("[player]", "Retourne les infomations du joueurs <br />Il faut preciser le type d'information recherché aisi que le type de formatage   (0,1  ou 2)." ,"[fond=350,90][/fond]\r\n[color=120,200,120]color2[/color]\r\n[string=4,10,20,color2][player=date,rank,0][/string]\r\n[string=4,100,50,color2][player=date,rank,1][/string]\r\n[string=4,150,20,color2][player=date,rank,2][/string]" );


	return $samples;


}




function individual_ranking_to_sign_code_ranking($array, $type)
{
	$retour = array(); 
	if ($type == "player")
	{
		$type = "P";
		
		
		// on initialise un tableau vide
		$retour = array(
				"player_name" => "XXX" ,
				"alliance_name" => "XXX" ,
				"P_date_a" => "?" ,
				"P_date_b" => "?" ,
				"P_rank_general_a" => "?" ,
				"P_rank_general_b" => "?" ,
				"P_rank_general_c" => "?" ,
				"P_points_general_a" => "?" ,
				"P_points_general_b" => "?" ,
				"P_points_general_c" => "?" ,
				"P_rank_eco_a" => "?" ,
				"P_rank_eco_b" => "?" ,
				"P_rank_eco_c" => "?" ,
				"P_points_eco_a" => "?" ,
				"P_points_eco_b" => "?" ,
				"P_points_eco_c" => "?" ,
				"P_rank_techno_a" => "?" ,
				"P_rank_techno_b" => "?" ,
				"P_rank_techno_c" => "?" ,
				"P_points_techno_a" => "?" ,
				"P_points_techno_b" => "?" ,
				"P_points_techno_c" => "?" ,
				"P_rank_military_a" => "?" ,
				"P_rank_military_b" => "?" ,
				"P_rank_military_c" => "?" ,
				"P_points_military_a" => "?" ,
				"P_points_military_b" => "?" ,
				"P_points_military_c" => "?" ,
				"P_rank_military_l_a" => "?" ,
				"P_rank_military_l_b" => "?" ,
				"P_rank_military_l_c" => "?" ,
				"P_points_military_l_a" => "?" ,
				"P_points_military_l_b" => "?" ,
				"P_points_military_l_c" => "?" ,
				"P_rank_military_d_a" => "?" ,
				"P_rank_military_d_b" => "?" ,
				"P_rank_military_d_c" => "?" ,
				"P_points_military_d_a" => "?" ,
				"P_points_military_d_b" => "?" ,
				"P_points_military_d_c" => "?" ,
		);
	}
	elseif ($type == "alliance")
	{
		$type = "A";
	}


	$date_key =  key($array);
	$date_key =  array_keys($array);
	
	//var_dump( $date_key);
	//exit();

	///on va travailler en cle => valeur
	$retour[$type."_date_a"] = date("d/m/Y", $date_key[0]);
	$retour[$type."_date_b"] = date("d F Y", $date_key[0]);

	$aselect = array("rank","points");

	
	foreach ($date_key  as $date)
	{
			$can_return = true; // tant que tout ne sera pas rempli on passera la valeur a false 		
		foreach ($array[$date]  as $key => $value)
		{
			// on prepare une eventuelle sortie ( => pas la peine de boucler jusqu au bout si toutest renseigné
		
			foreach ( $aselect as $select)
			{
				if ( isset($retour[$type."_".$select."_".$key."_a"]) && $retour[$type."_".$select."_".$key."_a"]  == "?" ) // si pas encore chargé ( isset pour partie help ... )
				{
					$retour[$type."_".$select."_".$key."_a"] = $value[$select];
					$retour[$type."_".$select."_".$key."_b"] =  number_format($value[$select], 0, ',', ' ') ;
					$retour[$type."_".$select."_".$key."_c"] = number_format($value[$select], 0, ',', '.') ;
					$can_return = false;
				}
			}
		

		}

			if ($can_return )
			{
				return $retour; 
			}
		
	}
		
	



	return $retour;
}




