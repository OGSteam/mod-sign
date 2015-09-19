<?php

$player_id=$user_data['user_id'];// récuperation de l id_player
$sign_id = (int)$pub_sign_id;// récuperation du sign_id

// vérification que la sign lui appartienne sinon redirection
$requete = 'SELECT *  FROM  '.TABLE_SIGN_USERS.' WHERE sign_id='.$sign_id.' AND player_id ='.$player_id;
$result = $db->sql_query($requete);
// si pas de reponse, redirection
if($db->sql_numrows() == 0)
{
	echo '<SCRIPT LANGUAGE="JavaScript">';
	echo 'document.location.href="index.php?action=sign"';
	echo '</SCRIPT>';
	exit();
}



// récupération et enregistrement  des variables posts
$code = "";
$update = false;
if (isset($pub_code))
{
$code = $db->sql_escape_string($pub_code);
$code = trim(nl2br(htmlentities($code, ENT_QUOTES, 'UTF-8'))); 

$update = true;
}
$sign_actif = 0;	
if (isset($pub_sign_actif))
{
	$sign_actif = (int)$pub_sign_actif;
	$update = true;
}

if (isset($pub_cible))
{
	$sign_cible = (int)$pub_cible;
	$update = true;
}

// mise a jour si besoin
if($update)
{
	$db->sql_query('UPDATE '.TABLE_SIGN_USERS.' SET code = "'.$code.'", cible_id =  '.$sign_cible.' , sign_actif =  '.$sign_actif.' WHERE sign_id = '.$sign_id);
}

// on supprime l 'image du cache
$patthFile = "mod/sign/fond/cache/".$sign_id.".png";
if(file_exists($patthFile))
{
	// on utilise la mise en cache en passant création a timestamp de 0
	touch($patthFile,0);

}

// arrivé ici, les prerequis sont bons ...
$result = $db->sql_query($requete);
$sign = $db->sql_fetch_assoc();


// récupération de la liste des inscrits sur ogspy
$user=array();
$requete = 'select user_id , user_stat_name  from '.TABLE_USER.' where user_stat_name <> "" ';
// arrivé ici, les prerequis sont bons ...
$result = $db->sql_query($requete);
while($tmp_user = $db->sql_fetch_assoc($result) )
{
$user[$tmp_user['user_id']]= $tmp_user['user_stat_name'];
}

var_dump($user);

?>

<form method="POST" action="index.php?action=sign&subaction=signedit&sign_id=<?php echo $sign_id;?>">
<table width="800">
<tr>
	<td class="c_user" colspan="2">Information joueur</td>
</tr>
<tr>
	<th>Pseudo</th>
	<th><?php  echo $user_data["user_name"];?></th>
</tr>
<tr>
	<th>Signature actuelle</th>
	<th><img src="mod/sign/<?php  echo $sign_id;?>.png"></img></th>
</tr>
<tr>
	<th>Signature active</th>
	<th><input name="sign_actif" value="1" <?php if($sign['sign_actif']==1) { echo " checked " ;} ?> type="checkbox"></th>
</tr>

<tr>
	<th>Utilisateur cible</th>
	<th>
			 <select name="cible">
			 		<?php foreach ($user as $key => $value ):?>
			 		<option 
			 		<?php if ($sign['cible_id'] == $key):?>
			 		 selected
			 		<?php endif ;?>
			 		
			 		value="<?php echo $key;?>"><?php echo $value;?>
			 		</option>
			 		<?php  endforeach ;?>
				  			</select> 
	
	</th>
</tr>



<tr>
	<td class="c_tech" colspan="2">Script signature</td>
</tr>
<tr>
	<th>choix fond</th>
	<th>Non Implementé</th>
</tr>

<tr>
	<th>Script</th>
	<th>
	 <textarea rows="10" cols="200"  name="code" ><?php echo $sign['code']?></textarea> 
	</th>
</tr>

<tr >
	<th colspan="2">
	<input type="submit" value="Submit">
</th>
	</tr>
	


</table>
</form>
