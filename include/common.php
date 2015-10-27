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
	include_once 'mod/sign/include/prod.php';
	
}
else
{
	include_once 'include/bbcode_parser.php';
	include_once 'mod/sign/include/prod.php';
}






function get_samples()
{
	$types = array('general', 'eco' , 	'techno' , 'military' , 'military_b' , 'military_l' , 'military_d' , 'honnor' );





	$samples = array();
	$samples[] = array("[fond]", "Selection d un fond deja present" ,"[fond]default.png[/fond]" );
	$samples[] = array("[fond]", "Création d un fond" ,"[fond=350,90][/fond]" ,1);
	$samples[] = array("[fond]", "Création d un fond transparent " ,"[fond=350,90]0[/fond]" ,1);
	$samples[] = array("[color]", "Passe en mémoire une couleur ( rgb) <br /> Cette variable est utilisée par les autres balises." ,"[color=120,125,120]color1[/color]" );
	$samples[] = array("[color]", "Passe en mémoire une couleur en transparence ( rgba) <br /> Cette variable est utilisée par les autres balises.<br /> Transparence possible entre 0 et 127 ( 127 transprence totale ... )" ,"[color=120,125,120,50]color1[/color]" );
	$samples[] = array("[line]", "Dessine une ligne Il faut indiquer le point d'origine et le point d'arrivé <br />Cette balise utilise une balise color." ,"[fond=350,90][/fond]\r\n[color=120,200,120]color2[/color]\r\n[color=255,50,10,15]color1[/color]\r\n[line=0,0,50,70]color2[/line]\r\n[line=0,25,200]color1[/line]\r\n" );
	$samples[] = array("[rectangle]", "Dessine un rectangle Il faut indiquer le point d'origine et le point d'arrivé <br />Cette balise utilise une balise color." ,"[fond=200,200][/fond]\r\n[color=120,200,120]color2[/color]\r\n[color=255,0,10]color1[/color]\r\n[rectangle=50,50,40,40,color1]\r\n" );
	$samples[] = array("[rectanglefilled]", "Dessine un rectangle plein Il faut indiquer le point d'origine et le point d'arrivé <br />Cette balise utilise une balise color." ,"[fond=200,200][/fond]\r\n[color=120,200,120]color2[/color]\r\n[color=255,0,10]color1[/color]\r\n[rectanglefilled=50,50,100,100,color1]\r\n" );
	$samples[] = array("[rectanglefilled]<br />[rectangle]", "Faire un effet valable également avec elipse, line ... " ,"[fond=230,220][/fond]\r\n[color=120,120,120]color2[/color]\r\n[color=200,200,200]color1[/color]\r\n[rectanglefilled=50,50,100,100,color2]\r\n[rectangle=50,50,100,100,color1]\r\n[rectanglefilled=150,150,200,200,color2]\r\n[rectanglefilled=152,152,201,201,color1]\r\n" );
	$samples[] = array("[ellipse]", "Dessine une ellipse Il faut indiquer le point d'origine  puis hauteur largeur   <br />Cette balise utilise une balise color." ,"[fond=200,200][/fond]\r\n[color=120,200,120]color2[/color]\r\n[color=255,0,10]color1[/color]\r\n[ellipse=50,50,40,40,color1]\r\n" );
	$samples[] = array("[ellipsefilled]", "Dessine une ellipse  pleine Il faut indiquer le point d'origine puis hauteur largeur  <br />Cette balise utilise une balise color." ,"[fond=200,200][/fond]\r\n[color=120,200,120]color2[/color]\r\n[color=255,0,10]color1[/color]\r\n[ellipsefilled=50,50,120,80,color1]\r\n" );
	$samples[] = array("[string]", "Ecrit du texte <br />Il faut preciser la taille ( entre 1 et 5 ), le point d origine <br />Cette balise utilise une balise color." ,"[fond=350,90][/fond]\r\n[color=120,200,120]color1[/color]\r\n[color=120,200,120,110]color2[/color]\r\n[string=3,100,50,color2]test[/string]\r\n[string=5,100,70,color1]CONCLUANT[/string]\r\n" );
	$samples[] = array("[stringeffect]", "Ecrit du texte <br />Il faut preciser la taille ( entre 1 et 5 ) ainsi que le type d effet  (1  ou 2 ), le point d origine <br />Cette balise utilise une balise color." ,"[fond=350,90][/fond]\r\n[color=120,200,120]color2[/color]\r\n[color=150,150,150]color1[/color]\r\n[stringeffect=3,100,50,color2,color1,1]test[/stringeffect]\r\n[stringeffect=5,100,70,color2,color1,2]CONCLUANT[/stringeffect]\r\n" );
	//$samples[] = array("[degrade]", "Dessine un degradé de couleur <br />Il faut preciser les cotes du rectangle à dessiner ainsi que le sens du degradé 'h' ou 'v' et la couleur de debut et de fin <br />Cette balise utilise deux balises color." ,"[fond=350,90][/fond]\r\n[color=255,0,0]color2[/color]\r\n[color=0,0,255]color1[/color]\r\n[degrade=20,20,300,85,v,color1,color2]\r\n\r\n" );

	/// player
	
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

				
		}

	}
	$samples[] = array("[var]", "Retourne les infomations du joueurs <br />Il faut preciser le type d'information recherché aisi que le type de formatage (a, b ou c)." ,
			"[fond=350,500][/fond]\r\n[color=120,200,120]color2[/color]\r\n
			[string=2,10,1,color2]Date en cours : [var=P_date_a] ou [var=P_date_b][/string]
			[string=2,10,30,color2]Nom joueur : [var=player_name] ! [/string]
			[string=2,10,50,color2]Alliance joueur : [var=alliance_name][/string]
				
			[string=4,10,80,color2]classement joueur : [/string]".$var );

	/// alliance
	
	$var = "";
	for ($i = 0 ; $i <  count($types) ; $i++)
	{
		foreach ($types as $type)
		{
			$tmp_i = 90 + $i *45;
			$tmp_i2 = 90 + 10 + $i *45;
			$tmp_i3 = 90 + 20 + $i *45;
			$var = $var." [string=2,10,".$tmp_i.",color2]".$types[$i]." : [/string]";
			$var = $var." [string=2,10,".$tmp_i2.",color2] RANK  : [var=A_rank_".$types[$i]."_a] | [var=A_rank_".$types[$i]."_b] | [var=A_rank_".$types[$i]."_c] [/string]";
			$var = $var." [string=2,10,".$tmp_i3.",color2] POINT : [var=A_points_".$types[$i]."_a] | [var=A_points_".$types[$i]."_b] |  [var=A_points_".$types[$i]."_c] [/string]";

				
		}

	}
	$samples[] = array("[var]", "Retourne les infomations de lalliance  <br />Il faut preciser le type d'information recherché aisi que le type de formatage  (a, b ou c)." ,
			"[fond=350,500][/fond]\r\n[color=120,200,120]color2[/color]\r\n
			[string=2,10,1,color2]Date en cours : [var=A_date_a] ou [var=A_date_b][/string]
			[string=2,10,50,color2]Alliance joueur : [var=alliance_name][/string]
				
			[string=4,10,80,color2]classement Alliance : [/string]".$var );
	
	
	$var = "";
	
	// on prépare le retour
	$ress = array("M"=> "Production de Metal","C"=>"Production de Cristal","D"=>"Production de Deuterium");
	$temp = array("heure" => 1 , "jour" => 24, "semaine" => 168, "mois" => 720); /// en nb d heure
	$i = 40;
	$inc = 20;
	
	foreach ($ress as $type => $value)
	{	
		$var = $var."[string=3,10,".$i.",color2]".$value." : [/string]";
		
		foreach ($temp as $temps_type => $temps_coef)
		{
			$i += $inc;
			$var = $var."[string=2,10,".$i.",color2]Par ".$temps_type." : [/string]";
			//$i += $inc;
			$var = $var."[string=2,100,".$i.",color2][var=prod_".$type."_".$temps_type."_a][/string]";
			$i += $inc;
			$var = $var."[string=2,100,".$i.",color2][var=prod_".$type."_".$temps_type."_b][/string]";
			$i += $inc;
			$var = $var."[string=2,100,".$i.",color2][var=prod_".$type."_".$temps_type."_c][/string]";
		}
		$i += $inc * 2;
	}
	

	
	$samples[] = array("[var]", "Retourne les infomations de production du joueur  <br />Il faut preciser le type de formatage   (a, b ou c)." ,
			"[fond=350,900][/fond]\r\n[color=120,200,120]color2[/color]\r\n
			[string=5,10,20,color2]Production : [/string]".$var );
	

	

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
				"P_rank_military_b_a" => "?" ,
				"P_rank_military_b_b" => "?" ,
				"P_rank_military_b_c" => "?" ,
				"P_points_military_b_a" => "?" ,
				"P_points_military_b_b" => "?" ,
				"P_points_military_b_c" => "?" ,
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
				"P_rank_honnor_a" => "?" ,
				"P_rank_honnor_b" => "?" ,
				"P_rank_honnor_c" => "?" ,
				"P_points_military_d_a" => "?" ,
				"P_points_military_d_b" => "?" ,
				"P_points_military_d_c" => "?" ,
				"P_points_honnor_a" => "?" ,
				"P_points_honnor_b" => "?" ,
				"P_points_honnor_c" => "?" ,


		);
	}
	elseif ($type == "alliance")
	{
		
		$type = "A";
		
		
		// on initialise un tableau vide
		$retour = array(
				"A_date_a" => "?" ,
				"A_date_b" => "?" ,
				"A_rank_general_a" => "?" ,
				"A_rank_general_b" => "?" ,
				"A_rank_general_c" => "?" ,
				"A_points_general_a" => "?" ,
				"A_points_general_b" => "?" ,
				"A_points_general_c" => "?" ,
				"A_rank_military_b_a" => "?" ,
				"A_rank_military_b_b" => "?" ,
				"A_rank_military_b_c" => "?" ,
				"A_points_military_b_a" => "?" ,
				"A_points_military_b_b" => "?" ,
				"A_points_military_b_c" => "?" ,
				"A_rank_eco_a" => "?" ,
				"A_rank_eco_b" => "?" ,
				"A_rank_eco_c" => "?" ,
				"A_points_eco_a" => "?" ,
				"A_points_eco_b" => "?" ,
				"A_points_eco_c" => "?" ,
				"A_rank_techno_a" => "?" ,
				"A_rank_techno_b" => "?" ,
				"A_rank_techno_c" => "?" ,
				"A_points_techno_a" => "?" ,
				"A_points_techno_b" => "?" ,
				"A_points_techno_c" => "?" ,
				"A_rank_military_a" => "?" ,
				"A_rank_military_b" => "?" ,
				"A_rank_military_c" => "?" ,
				"A_points_military_a" => "?" ,
				"A_points_military_b" => "?" ,
				"A_points_military_c" => "?" ,
				"A_rank_military_l_a" => "?" ,
				"A_rank_military_l_b" => "?" ,
				"A_rank_military_l_c" => "?" ,
				"A_points_military_l_a" => "?" ,
				"A_points_military_l_b" => "?" ,
				"A_points_military_l_c" => "?" ,
				"A_rank_military_d_a" => "?" ,
				"A_rank_military_d_b" => "?" ,
				"A_rank_military_d_c" => "?" ,
				"A_rank_honnor_a" => "?" ,
				"A_rank_honnor_b" => "?" ,
				"A_rank_honnor_c" => "?" ,
				"A_points_military_d_a" => "?" ,
				"A_points_military_d_b" => "?" ,
				"A_points_military_d_c" => "?" ,
				"A_points_honnor_a" => "?" ,
				"A_points_honnor_b" => "?" ,
				"A_points_honnor_c" => "?" ,
		
	);
	}


	$date_key =  key($array);
	$date_key =  array_keys($array);


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
				// todo pt par membre uniquement pour alliance 
				
				
				
			}


		}

		if ($can_return )
		{
			return $retour;
		}

	}





	return $retour;
}

function add_compteur($name )
{
	//cf http://www.supportduweb.com/scripts_tutoriaux-code-source-65-php-compteur-de-visites-scripts-php.html
	$name = "mod/sign/compteur/".$name.".txt";
	if(file_exists($name))
	{
		$compteur = fopen($name, 'r+');
		$compte = fgets($compteur);
	}
	else
	{
		$compteur = fopen($name, 'a+');
		$compte = 0;
	}
	$compte++;
	fseek($compteur, 0);
	fputs($compteur, $compte);
	fclose($compteur);

}

function get_compteur($name )
{
	//cf http://www.supportduweb.com/scripts_tutoriaux-code-source-65-php-compteur-de-visites-scripts-php.html
	$name = "mod/sign/compteur/".$name.".txt";
	$compte = 0;
	if(file_exists($name))
	{
		$compteur = fopen($name, 'r+');
		$compte = fgets($compteur);
			
		fclose($compteur);
	}
	else
	{
		$compte = 0;
	}

	return $compte;
}


function get_prod($prod)
{
	$retour = array();
	$M = 0;
	$C = 0;
	$D = 0;
	
	// on récupere le total
	foreach ($prod["reel"] as $p)
	{
		$M += $p["M"];
		$C += $p["C"];
		$D += $p["D"];
	}
	
	// on prépare le retour
	$ress = array("M"=>$M,"C"=>$C,"D"=>$C);
	$temp = array("heure" => 1 , "jour" => 24, "semaine" => 168, "mois" => 720); /// en nb d heure
	
	foreach ($ress as $type => $value)
	{
		foreach ($temp as $temps_type => $temps_coef)
		{
		$retour["prod_".$type."_".$temps_type."_a"]= $temps_coef * $value  ; //* temps_coef;
		$retour["prod_".$type."_".$temps_type."_b"]= number_format( $temps_coef * $value , 0, ',', ' ') ;
		$retour["prod_".$type."_".$temps_type."_c"]=  number_format( $temps_coef * $value , 0, ',', '.') ;
		}
	}
	
	return $retour;
	
	
}
