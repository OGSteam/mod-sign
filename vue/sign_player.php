<?php 
// vérification que la sign lui appartien sinon redirection
$requete = 'SELECT  *  FROM  '.TABLE_SIGN_USERS.' WHERE  player_id ='.$user_data['user_id'];
$result = $db->sql_query($requete);
 ?>
<input name="action" type="hidden" value="sign_player">
<table width="800">
 <tr>
	<td class="c" colspan="3">signatures</td>
</tr>
<?php
while($sign = $db->sql_fetch_assoc($result) )
{

echo '<tr>';
echo '<th><img src="mod/sign/'.$sign['sign_id'].'.png"></img></th>';
echo '<th><a href="index.php?action=sign&subaction=signedit&sign_id='.$sign['sign_id'].'"><img src="mod/sign/icon/edit.png"></img></a></th>';
echo '<th><a href="index.php?action=sign&subaction=signdel&sign_id='.$sign['sign_id'].'"><img src="mod/sign/icon/del.png"></img></a></th>';
echo '</tr>';

}
?>


</table>


				
				<?php 
			
				
				?>	