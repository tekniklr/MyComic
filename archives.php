<?php
/*  Copyright (C) 2002-2003 tekniklr
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
 *  USA
 *
 *
 * MyComic
 * Basic scripts to maintain a webcomic using PHP, without needing
 * a database
 *
 * Pretty lightweight, but it does the job.
 *
 *  Original author: tekniklr
 *  apps@tekniklr.com
 *  https://github.com/tekniklr
 *
 *
 * archives.php
 * Contains code to get and print the archives-
 * You can change the display of this easily, if you know a bit of PHP/HTML
 * (e.g. to fill a dropdown box instead of a table, etc)
 *
 */
?>

<?php include('includes/comic_header.php'); ?>

<center><table border="0" cellpadding="3">
<?php

$dates = get_dates($home.$comic_dir);
rsort($dates);
$keys = array_keys($dates);

foreach ($keys as $key) {
	print "<tr><td><span class=\"tint\"><a class=\"change\" href=\"$path/index.php?id=" . $dates[$key] . "\">" . get_date($dates[$key]) . ": ";
	print_title($dates[$key]);
	print "</a></span></td></tr>\n";
}

?>
</table></center>

<?php include('includes/comic_footer.php'); ?>
