<?php 
$cache = "";
$title = "";
$path = "";
if (isset($pub_gal) && $pub_gal == "default")
{
	$cache = glob("mod/sign/fond/default/*.png");
	$title = "Fonds utilisables ";
	$path = "";
}
else
{
	$title = "Signatures présentes dans le cache";
	$cache = glob("mod/sign/fond/cache/*.png");
	$temp = explode("/index.php?action=sign&subaction=galerie", $_SERVER['HTTP_REFERER']);
	$path  = $temp[0]."/mod/sign/";
}

?>

<table width="800">
<tr>
	<th class="c_user" colspan="2"><a href="index.php?action=sign&subaction=galerie">Signature active</a></th>
	<th class="c_user" colspan="2"><a href="index.php?action=sign&subaction=galerie&gal=default">Fond Present</a></th>
</tr>

</table>

<table width="1000">
<tr>
<th class="c">
<h2><?php  echo $title;?></h2>
</th>
</tr>
<tr>
<th>

<?php foreach ($cache as $filename ) :?>

	<p align ="center"><img src="<?php echo $filename ;?>"<img><br />
	<input type=text value="<?php echo $path.basename($filename) ;?>" style="width:600px;"/>
	<br /> _________</p>
	
<?php endforeach;?>
</th>
</tr>

</table>
