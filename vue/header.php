<?php
/**
 * @package [MOD] sign
 * @author machine
 */
if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

require_once 'views/page_header.php';
require_once 'mod/sign/include/common.php';?>

<table>
	<tr>
		<td class='c' align='center' width='150' style='cursor: pointer'><a
			href="index.php?action=sign"> Mes signatures </a>
		</td>
		<td class='c' align='center' width='150' style='cursor: pointer'><a
			href="index.php?action=sign&subaction=newsign"> Nouvelle signature </a>
		</td>
		<td class='c' align='center' width='150' style='cursor: pointer'><a
			href="index.php?action=sign&subaction=galerie"> Galerie </a>
		</td>
		<td class='c' align='center' width='150' style='cursor: pointer'><a
			href="index.php?action=sign&subaction=help"> Aide </a>
		</td>
		<?php if ($user_data['user_admin'] == 1 || $user_data['user_coadmin'] == 1)  :?>
		<!--  espace admin -->
		<td class='c' align='center' width='150' style='cursor: pointer'><a
			href="index.php?action=sign&subaction=upload"> Upload </a>
		</td>
		<td class='c' align='center' width='150' style='cursor: pointer'><a
			href="index.php?action=sign&subaction=admin"> Admin </a>
		</td>
		<!-- fin espace admin -->
		<?php endif;?>
	</tr>
</table>
