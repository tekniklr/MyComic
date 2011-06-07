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
 * rss.php
 * Generates a RSS feed for comic updates.
 *
 */

include('includes/comic_config.php');
include('includes/comic_common.php');
	
$dates = get_dates($home.$comic_dir);
rsort($dates);
$keys = array_keys($dates);

$shown = 0;
$num_show = 10;

header("Last-Modified: " . gmdate("D, d M Y H:i:s", filemtime($home.$path)) . " GMT");
header('Content-type: application/rss+xml; charset="utf-8"');

$link = "http://{$_SERVER['SERVER_NAME']}";

print "<?xml version=\"1.0\" encoding=\"utf-8\" ?>
<rss version=\"2.0\" xmlns:content=\"http://purl.org/rss/1.0/modules/content/\" xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\" >
<channel>
<title>$title updates</title>
<link>$link</link>
<description>$title updates</description>
<language>en</language>\n";

foreach ($keys as $key) {
	if ($shown < $num_show) {
		$comic_link = $link.$path."/index.php?id=".$dates[$key];
		$comic_title = print_title($dates[$key], true);
		$comic_time = get_date($date_array[$id_key], "r");
		$comic_desc = "";
		print "<item>
<title>$comic_title</title>
<description></description>
<content:encoded><![CDATA[
$comic_desc
]]></content:encoded>
<link>$comic_link</link>
<guid isPermaLink=\"true\">$comic_link</guid>
<pubDate>$comic_time</pubDate>
</item>\n\n";
	}
	$shown++;
}

print "</channel>
</rss>\n";

?>
