<?php
/**
* testgd.php petite image de test pour v�rifier le fonctionnement de la lib GD
* @package OGSign
* @author oXid_FoX
* @link http://www.ogsteam.fr
* created	: 09/12/2006 10:46:40
*/

// requiert la biblioth�que GD 2.0.1 ou sup�rieure
// honteusement copi� mod pour sign

// pour interdire la mise en cache
header('Cache-Control: no-cache, must-revalidate'); // HTTP/1.1
header('Pragma: no-cache'); // HTTP/1.0
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date du pass�
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // toujours modifi�

// affiche l'image de test
// Modification du header
if (!headers_sent()) {
	header ('Content-type: image/png');

	$im = imagecreatetruecolor(18, 18); // Cr�ation d'une image blanche
	$bgc = imagecolorallocate($im, 255, 128, 32); // couleur orange
	$tc	= imagecolorallocate($im, 0, 0, 0);	// couleur noire
	imagefilledrectangle($im, 1, 1, 16, 16, $bgc);	// rectangle orange centr�
	imagestring($im, 2, 3, 2, 'OK', $tc); // "OK" en noir
	imagepng($im);	// affichage de l'image
}
?>
