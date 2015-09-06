<?php 
global $user_data ;
$samples = get_samples();
$individual_ranking = galaxy_show_ranking_unique_player("machine" ,TRUE);
?>
<table width="1200">
	<tr>
		<th >Balise</th>
		<th>Utilisation</th>
		<th>Exemple</th>
		<th>Resultat</th>
	</tr>
	<?php $i=0; ?>
	<?php foreach ($samples as $sample) : ?>
	<tr>
		<td class="a" ><?php echo $sample[0];?></td>
		<td class="b" ><?php echo $sample[1];?></td>
		<td class="c" ><textarea rows="10" cols="30"  name="code" ><?php echo $sample[2];?></textarea> </td>
		<td class="c" ><img src="mod/sign/samples.php?id=<?php echo $i ; ?>&player=<?php echo $user_data["user_id"] ; ?>"></td>
	</tr>
	<?php $i++; ?>
	<?php endforeach; ?>
</table>


