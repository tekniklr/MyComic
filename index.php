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
 * index.php
 * Prints comics/news
 * Defaults to showing the newest comic, but archives are viewed through here, too
 *
 */
?>
<?php include('includes/comic_header.php'); ?>

<?php

// get all the dates into the array.
$date_array = get_dates($home.$comic_dir);
sort($date_array);

// boolean telling whether this is the newest comic
$is_latest = true;

// are we trying to view a (valid) archived comic?
$id = $_GET['id'];
$keys = array_keys($date_array);
foreach ($keys as $key) {
	if ($id == $date_array[$key]) {
		$is_latest = false;
		$id_key = $key;
	}
}

if ($is_latest) {
	$id_key = count($date_array)-1;
}
// get correct comic
$extss = array_keys($exts);
foreach ($extss as $ext) {
	$temp = $comic_dir . $date_array[$id_key] . "/comic." . $exts[$ext];
	if (file_exists($home.$temp)) {
		$show_comic = $temp;
		$im_info = getimagesize($home.$temp);
	}
}

?>

<center>
<img src="<?php echo $show_comic; ?>" border="0" height="<?php echo $im_info[1]; ?>" width="<?php echo $im_info[0]; ?>" alt="Comic" /><br /><br />
<span class="title"><?php
print get_date($date_array[$id_key]) . ": ";
print_title($date_array[$id_key]);
?></span>

<br /><br />
<center>
<?php
if ($date_array[$id_key] == $date_array[0]) { // first
	print "<table border=\"0\" cellpadding=\"0\" cellspacing=\"20\"><tr>\n";

	print "<td align=\"center\" valign=\"top\">\n";
	print "<a href=\"$path/archives.php\">View Archives</a><br />\n";
	print "</td>\n";

	print "<td align=\"center\" valign=\"top\">\n";
	print "<a href=\"$path/index.php\">Current Comic</a><br />\n";
	print "</td>\n";

	print "<td align=\"center\" valign=\"top\">\n";
	print "<a href=\"$path/index.php?id=" . substr($date_array[$id_key+1], 0, place+8) . "\">Next Comic</a><br />\n";
	print "</td>\n";

	print "</tr></table>\n";
}
else if ($date_array[$id_key] == $date_array[count($date_array)-1]) { // current
	print "<table border=\"0\" cellpadding=\"0\" cellspacing=\"20\"><tr>\n";

	print "<td align=\"center\" valign=\"top\">\n";
	print "<a href=\"$path/index.php?id=" . substr($date_array[0], 0, place+8) . "\">First Comic</a><br />\n";
	print "</td>\n";

	print "<td align=\"center\" valign=\"top\">\n";
	print "<a href=\"$path/archives.php\">View Archives</a><br />\n";
	print "</td>\n";

	print "<td align=\"center\" valign=\"top\">\n";
	print "<a href=\"$path/index.php?id=" . substr($date_array[$id_key-1], 0, place+8) . "\">Previous Comic</a><br />\n";
	print "</td>\n";

	print "</tr></table>\n";
}
else { // not on either end
	print "<table border=\"0\" cellpadding=\"0\" cellspacing=\"20\"><tr>\n";

	print "<td align=\"center\" valign=\"top\">\n";
	print "<a href=\"$path/index.php?id=" . substr($date_array[0], 0, place+8) . "\">First Comic</a><br />\n";
	print "</td>\n";

	print "<td align=\"center\" valign=\"top\">\n";
	print "<a href=\"$path/archives.php\">View Archives</a><br />\n";
	print "</td>\n";

	print "<td align=\"center\" valign=\"top\">\n";
	print "<a href=\"$path/index.php\">Current Comic</a><br />\n";
	print "</td>\n";

	print "<td align=\"center\" valign=top\">\n";
	print "<a href=\"$path/index.php?id=" . substr($date_array[$id_key-1], 0, place+8) . "\">Previous Comic</a><br />\n";
	print "</td>\n";

	print "<td align=\"center\" valign=\"top\">\n";
	print "<a href=\"$path/index.php?id=" . substr($date_array[$id_key+1], 0, place+8) . "\">Next Comic</a><br />\n";
	print "</td>\n";

	print "</tr></table>\n";
}

?>
</center>

<br /><strong><u>News</u></strong><br /><br />
<table border="0" cellpadding="10" cellspacing="0" width="95%">
<?php print_news($home.$comic_dir.$date_array[$id_key]); ?>
</table>
</center>

<?php include('includes/comic_footer.php'); ?>
