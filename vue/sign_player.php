<?php 
// vérification que la sign lui appartien sinon redirection
$requete = 'SELECT  *  FROM  '.TABLE_SIGN_USERS.' WHERE  player_id ='.$user_data['user_id'];
$result = $db->sql_query($requete);
 ?>
<input name="action" type="hidden" value="sign_player">
<table width="800">
 <tr>
	<td class="c" colspan="5">signatures</td>
</tr>

<?php
echo '<tr>';
echo '<th>Appercu</th>';
echo '<th class="c" >Vue</th>';
echo '<th class="c" >Généré</th>';
echo '<th></th>';
echo '<th></th>';
echo '</tr>';
while($sign = $db->sql_fetch_assoc($result) )
{

echo '<tr>';
echo '<th><img src="mod/sign/'.$sign['sign_id'].'.png"></img></th>';
echo '<th>'.get_compteur($sign['sign_id'].'_vue').'</th>';
echo '<th>'.get_compteur($sign['sign_id'].'_generate').'</th>';
echo '<th><a href="index.php?action=sign&subaction=signedit&sign_id='.$sign['sign_id'].'"><img src="mod/sign/icon/edit.png"></img></a></th>';
echo '<th><a href="index.php?action=sign&subaction=signdel&sign_id='.$sign['sign_id'].'"><img src="mod/sign/icon/del.png"></img></a></th>';
echo '</tr>';

}
?>


</table>


				
				<?php 
			
				
				?>	