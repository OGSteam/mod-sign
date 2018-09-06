<?php  
/// fichier temporaire en attendant intégration du fork ogspy

function _user_get_empire($user_id)
{
	global $db;

	$planet = array(false, "user_id" => "", "planet_name" => "", "coordinates" => "",
			"fields" => "", "fields_used" => "", "boosters" => booster_encode(),
			"temperature_min" => "", "temperature_max" =>"",
			"Sat" => 0, "Sat_percentage" => 100, "M" => 0, "M_percentage" => 100, "C" => 0,
			"C_Percentage" => 100, "D" => 0, "D_percentage" =>100, "CES" => 0, "CES_percentage" => 100,
			"CEF" => 0, "CEF_percentage" => 100, "UdR" => 0, "UdN" => 0, "CSp" => 0,
			"HM" => 0, "HC" => 0, "HD" => 0, "CM" => 0,"CC" => 0,"CD" => 0, "Lab" => 0,
			"Ter" => 0, "Silo" => 0, "BaLu" => 0, "Pha" => 0, "PoSa" => 0, "DdR" => 0,
			"C_percentage" => 100);

	$defence = array("LM" => 0, "LLE" => 0, "LLO" => 0, "CG" => 0, "AI" => 0, "LP" =>
			0, "PB" => 0, "GB" => 0, "MIC" => 0, "MIP" => 0);

	// pour affichage on selectionne 9 planetes minis
	if (_find_nb_planete_user($user_id) < 9) {
		$nb_planete = 9;
	} else {
		$nb_planete = _find_nb_planete_user($user_id);
	}

	// on met les planete a 0
	for ($i = 101; $i <= ($nb_planete + 100); $i++) {
		$user_building[$i] = $planet;
	}

	// on met les lunes a 0
	for ($i = 201; $i <= ($nb_planete + 200); $i++) {
		$user_building[$i] = $planet;
	}

	$request = "SELECT planet_id, planet_name, coordinates, fields, boosters, temperature_min, temperature_max, Sat, Sat_percentage, M, M_percentage, C, C_Percentage, D, D_percentage, CES, CES_percentage, CEF, CEF_percentage, UdR, UdN, CSp, HM, HC, HD,  Lab, Ter, Silo, BaLu, Pha, PoSa, DdR";
	$request .= " FROM " . TABLE_USER_BUILDING;
	$request .= " WHERE user_id = " . $user_id;
	$request .= " ORDER BY planet_id";
	$result = $db->sql_query($request);


	//	$user_building = array_fill(101,$nb_planete , $planet);
	while ($row = $db->sql_fetch_assoc($result)) {
		$arr = $row;
		unset($arr["planet_id"]);
		unset($arr["planet_name"]);
		unset($arr["coordinates"]);
		unset($arr["fields"]);
		unset($arr["boosters"]);
		unset($arr["temperature_min"]);
		unset($arr["temperature_max"]);
		unset($arr["Sat"]);
		unset($arr["Sat_percentage"]);
		unset($arr["M_percentage"]);
		unset($arr["C_Percentage"]);
		unset($arr["D_percentage"]);
		unset($arr["CES_percentage"]);
		unset($arr["CEF_percentage"]);
		$fields_used = array_sum(array_values($arr));


		$row["fields_used"] = $fields_used;
		$row["boosters"] = booster_verify_str($row["boosters"]);    //Correction et mise à jour booster from date
		$row["C_percentage"] = $row["C_Percentage"];
		$user_building[$row["planet_id"]] = $row;
		$user_building[$row["planet_id"]][0] = true;
	}


	$request = "SELECT Esp, Ordi, Armes, Bouclier, Protection, NRJ, Hyp, RC, RI, PH, Laser, Ions, Plasma, RRI, Graviton, Astrophysique";
	$request .= " FROM " . TABLE_USER_TECHNOLOGY;
	$request .= " WHERE user_id = " . $user_id;
	$result = $db->sql_query($request);

	$user_technology = $db->sql_fetch_assoc($result);

	$request = "SELECT planet_id, LM, LLE, LLO, CG, AI, LP, PB, GB, MIC, MIP";
	$request .= " FROM " . TABLE_USER_DEFENCE;
	$request .= " WHERE user_id = " . $user_id;
	$request .= " ORDER BY planet_id";
	$result = $db->sql_query($request);


	// on met les def planete a 0
	for ($i = 101; $i <= ($nb_planete + 100); $i++) {
		$user_defence[$i] = $defence;
	}

	// on met les def lunes a 0
	for ($i = 201; $i <= ($nb_planete + 200); $i++) {
		$user_defence[$i] = $defence;
	}

	//$user_defence = array_fill(1, $nb_planete_lune, $defence);
	while ($row = $db->sql_fetch_assoc($result)) {
		$planet_id = $row["planet_id"];
		unset($row["planet_id"]);
		$user_defence[$planet_id] = $row;
	}

	return array("building" => $user_building, "technology" => $user_technology,
			"defence" => $user_defence, );
}
/**
 * Récuperation du nombre de  planete de l utilisateur
 * TODO => cette fonction sera a mettre en adequation avec astro
 * ( attention ancien uni techno a 1 planete mais utilisateur 9 possible  !!!!!)
 */
function _find_nb_planete_user($id)
{
	global $db, $user_data;


	$request = "SELECT planet_id ";
	$request .= " FROM " . TABLE_USER_BUILDING;
	$request .= " WHERE user_id = " . $user_data["user_id"];
	$request .= " AND planet_id < 199 ";
	$request .= " ORDER BY planet_id";

	$result = $db->sql_query($request);

	//mini 9 pour eviter bug affichage
	if ($db->sql_numrows($result) <= 9)
		return 9;

	return $db->sql_numrows($result);

}
function _find_nb_moon_user($id)
{
	global $db, $user_data;


	$request = "select planet_id ";
	$request .= " from " . TABLE_USER_BUILDING;
	$request .= " where user_id = " . $user_data["user_id"];
	$request .= " and planet_id > 199 ";
	$request .= " order by planet_id";

	$result = $db->sql_query($request);

	//mini 9 pour eviter bug affichage
	if ($db->sql_numrows($result) <= 9)
		return 9;

	return $db->sql_numrows($result);

}

/**
 * Calcul production de l'empire
 * @param array $user_empire
 */
function _user_empire_production($user_empire, $off = NULL)
{
	$prod = array();

	if ($off == NULL)
	{
		$off['off_commandant'] = 0;
		$off['off_amiral']  = 0;
		$off['off_ingenieur'] = 0;
		$off['off_geologue']  = 0;
		$off['off_technocrate'] = 0;
	}
	//!\\ prepa officier
	$officier = $off['off_commandant'] + $off['off_amiral'] + $off['off_ingenieur']
	+ $off['off_geologue'] + $off['off_technocrate'];
	if ($officier == 5) {
		$off_full = 1;
		$officier = 2; //full officier
	} else {
		$off_full = 0;
		$officier = $off['off_geologue'];
	}
	//!\\ fin prepa officier

	//!\\ prepa techno
	$plasma = $user_empire['technology']['Plasma'] != "" ? $user_empire['technology']['Plasma'] : "0";
	$NRJ = $user_empire['technology']['NRJ'] != "" ? $user_empire['technology']['NRJ'] : "0";
	//!\\ fin prepa techno
	// prepa ration E
	$product = array("M" => 0, "C" => 0, "D" => 0, "ratio" => 1, "conso_E" => 0, "prod_E" => 0);
	$ratio = array();
	$NRJ = $user_empire['technology']['NRJ'] != "" ? $user_empire['technology']['NRJ'] : "0";
	$temp_max = 0;
		// FIN prepa ration E
	
	

	foreach ($user_empire["building"] as  $content)
	{
		if (isset($content["planet_id"]) && $content["planet_id"] < 200 )
		{// parcours des planetes ( < 200 )
			
			// les different type de prod (generique)
			$type = array("M","C","D");
			foreach ($type as $mine)
			{
				$level = $content[$mine] != "" ? $content[$mine] : "0";
				if ($level != "")
				{	
					if (isset($content["temperature_max"]))
					{
						$temp_max = $content["temperature_max"];
					}
					
					if ($mine == "D")
					{ // specificité deut puisque les cef pompe la prod
						$CEF = $content["CEF"];
						$CEF_consumption = consumption("CEF", $CEF);
						$tmp =  production($mine, $level, $officier, $temp_max, $NRJ, $plasma) -$CEF_consumption ;
						$prod["theorique"][$content["planet_id"]][$mine] = number_format(floor($tmp), 0, ',', ' ');
					}
					else
					{
						$tmp =  production($mine, $level, $officier, $temp_max, $NRJ, $plasma) ;
						$prod["theorique"][$content["planet_id"]][$mine] = number_format(floor($tmp), 0, ',', ' ');
					}
				}
			}
			
			
			
			
				// si pas de temperature impossible de calculer le ration et donc prod theorique ...
			if (isset($content["temperature_max"]))
			{
				// calcul ratio
			$ratio[$content["planet_id"]] = $product;
			$ratio[$content["planet_id"]] = bilan_production_ratio($content["M"], $content["C"], $content["D"],
					$content["CES"], $content["CEF"], $content["Sat"],$content["temperature_max"], $off['off_ingenieur'], $off['off_geologue'], $off_full,
					$NRJ, $plasma, $content["M_percentage"] / 100, $content["C_percentage"] / 100,
					$content["D_percentage"] / 100, $content["CES_percentage"] / 100, $content["CEF_percentage"] / 100,
					$content["Sat_percentage"] / 100);
				
			
			$prod["reel"][$content["planet_id"]] = $ratio[$content["planet_id"]];
			
			}
			
		}

	}
		

	return $prod;


}
