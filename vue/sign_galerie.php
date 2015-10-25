<?php 
$cache = "";
$title = "";
$path = "";
$msg = "";

if (isset($pub_del))
{

	if(file_exists("mod/sign/fond/default/".$pub_del.".png") && ctype_alnum($pub_del) )
	{
			
		$msg = "Fichier ".$pub_del.".png supprimé ";
		unlink("mod/sign/fond/default/".$pub_del.".png");
	}
	else
	{

		$msg = "Impossible de supprimer le fichier ".$pub_del.".png ";
	}
}


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
	$temp = explode("/index.php?action=", $_SERVER['HTTP_REFERER']);
	$path  = $temp[0]."/mod/sign/";
}


?>




<table width="800">
	<tr>
		<th class="c_user" colspan="2"><a
			href="index.php?action=sign&subaction=galerie">Signature active</a></th>
		<th class="c_user" colspan="2"><a
			href="index.php?action=sign&subaction=galerie&gal=default">Fond
				Present</a></th>
	</tr>

</table>
<?php if($msg !=""):?>
<p align="center">
<h2>
	<span style="font-weight: 800; color: red;"> <?php echo $msg?>
	</span>
</h2>

</p>
<?php endif; ?>

<table width="1000">
	<tr>
		<th class="c">
			<h2>
				<?php  echo $title;?>
			</h2>
		</th>
	</tr>
	<tr>
		<th><?php foreach ($cache as $filename ) :?>
			<table width="1000">
				<tr>
					<th colspan="2">
						<center>
							<img src="<?php echo $filename ;?>">
						</center>
					</th>
				</tr>
				<th><input type=textDefault
					value="<?php echo $path.basename($filename) ;?>"
					style="width: 600px;" />
				</th>
				<th><?php if (isset($pub_gal) &&  $pub_gal == "default"):?> <a
					href="index.php?action=sign&subaction=galerie&gal=default&del=<?php echo $path.explode(".",basename($filename))[0]?>"><img
						src="mod/sign/icon/del.png"></img> </a> <?php endif ;?>
				</th>


			</table> <?php endforeach;?>
		</th>
	</tr>

</table>
