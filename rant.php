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
 * rant.php
 * Shows rant items.  Very similar to the gallery page.
 *
 */
?>
<?php include('includes/comic_header.php'); ?>

<?php

// leave these blank if you don't want to use them

// this is the title of the intro rant
$introname = "Intro";
// this is the body of the intro rant
$introtext = "This is an optional built-in intro rant.";

?>

<center>
<?php
$dates = get_rants($home.$path."/rant/");
$id = $_GET['id'];

if (in_array($id, $dates)){ // id is a valid rant.  show rant.
	print "<table class=\"tint\" width=\"100%\" border=\"0\" cellpadding=\"10\" cellspacing=\"0\">
	<tr><td class=\"tint\">\n";
	print "<center><h1>";
	print_rant_title($id);
	print "</h1></center><br />\n\n";
	$html_array = file($home.$path."/rant/".$id);
	$html = implode("", $html_array);
	$lines = split("\n", $html);
	$x = 1; // line to start at
	$body = "";
	while (!is_null($lines[$x])) {
		$body = $body . $lines[$x] . " ";
		$x++;
	}
	print $body;
	print "</td></tr></table>\n\n";
}

else if (($id == "WTF")&&(!empty($introtext))&&(!empty($introname))){ // WTF? Is going on?
	print "<table width=\"100%\" border=\"0\" cellpadding=\"10\" cellspacing=\"0\">\n";
	print "<tr><td class=\"tint\">\n";
	print $introtext;
	print "</td></tr></table>\n\n";
}

else{ // id is not given or is not valid.  show list.
	rsort($dates);
	$keys = array_keys($dates);
	print "<table border=\"0\" cellpadding=\"3\">";
	if ((!empty($introtext))&&(!empty($introname))) {
		print "<tr><td class=\"tint\"><a class=\"change\" href=\"$path/rant.php?id=WTF\"><strong>$introname</strong></a><br /><br /></td></tr>\n";
	}
	foreach ($keys as $key) {
		print "<tr><td class=\"tint\"><a class=\"change\" href=\"$path/rant.php?id=" . $dates[$key] . "\">" . get_date($dates[$key]) . ": ";
		print_rant_title($dates[$key]);
		print "</a></td></tr>\n";
	}
	print "</table>";
}

?>
</center>

<?php include('includes/comic_footer.php'); ?>
