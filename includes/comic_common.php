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
 * comic_common.php
 * Contains functions that can/will be used in several places
 *
 */

// version
$comic_version = "1.0.1";

// print out the data from the news file
function print_news($date) {
	global $av_width, $av_height, $path;
	$news_array = array();
	$handle = opendir($date);
	while (false !== ($file = readdir($handle))) {
		if($file=='.'||$file=='..'||$file=='title.txt'||!strpos($file, ".txt")) {
			continue;
		}
		else {
			$place = strpos($file, '.');
			if (substr($file, $place+1) == 'txt'){
				$news_array[]=$date."/".$file;
			}
		}
	}
	if (count($news_array)<1) {
		print "<tr><td class=\"tint\">";
		print "There is no news for this comic.";
		print "</td></tr>";
	}
	else {
		sort($news_array);
		$keys = array_keys($news_array);
		foreach ($keys as $key) {
			$body = "";
			$html_array = file($news_array[$key]);	
			$html = implode("", $html_array);
			$post = split("\n", $html);
			$name = $post[0];
			if (defined($name."_mail")){
				$name = "<a class=\"change\" href=\"mailto:".constant($name."_mail")."\"><strong>$name</strong></a>";
			}
			else {
				$name = "<strong>$name</strong>";
			}
			$subject = $post[1];
			$date = date2(substr($news_array[$key], strlen($news_array[$key])-18, 14));
			$avatar = $post[2];
			$x = 3;
			while (!is_null($post[$x])) {
				$body = $body . $post[$x] . " ";
				$x++;
			}
			print "<tr><td class=\"tint\">\n";
			print "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
			print "<tr><td rowspan=\"3\">\n";
			if (strlen($avatar)>2) {
			print "<img src=\"$path$avatar\" border=\"0\" alt=\"$avatar\" width=\"$av_width\" height=\"$av_height\" />\n";
			}
			print "</td><td rowspan=\"3\">&nbsp;&nbsp;&nbsp;</td><td align=\"right\" width=\"100%\">\n";
			if (strlen($subject)>2 && substr($subject, 0, 2) =="**"){
				$subject = substr($subject, 2);
				print "<span style=\"font-size: larger;\"><strong>$subject</strong></span>\n";
			}
			print "</td></tr><tr><td align=\"left\">\n";
			print "<span style='font-size: larger;'>$name</span><br />\n";
			print "</td></tr><tr><td align=\"left\">\n";
			print "<em>$date</em>\n";
			print "</td></tr></table>\n";
			print "<hr noshade=\"noshade\" />\n";			
			print html_entity_decode($body) . "\n";	
			print "</td></tr>\n";
			print "<tr><td><br /></td></tr>\n";
		}
	}
}

// get an array of rants for the rants page
function get_rants($dirname) {
	static $result_array=array();
	$handle = opendir($dirname);
	while (false !== ($file = readdir($handle))) {
		if($file=='.'||$file=='..') {
			continue;
		}
		if(substr($dirname.$file, strlen($dirname.$file)-3, strlen($dirname.$file))=="txt") {
			$result_array[]=$file;
		}
		else {
			continue;
		}
	}
	closedir($handle);
	return $result_array;
}

// print out a rant title nicely
function print_rant_title($date){
	global $home, $path;
	$file = $home.$path."/rant/".$date;
	$html_array = file($file);
	$html = implode("", $html_array);
	$lines = split("\n", $html);
	$title = $lines[0];
	print $title;
}

// parse date into normal person readable form
function get_date($date, $format = false){
	$time = mktime(0,0,0,substr($date, 4, 2),substr($date, 6, 2),substr($date, 0, 4));
	if (!$format) {
		$format = "m/d/Y";
	}
	$out = date($format, $time);
	return $out;
}

// parse full date (ymdhms) into form used in news posts
function date2($date){
	$year = substr($date, 0, 4);
	$month = substr($date, 4, 2);
	$day = substr($date, 6, 2);
	$hour = substr($date, 8, 2);
	$minute = substr($date, 10, 2);
	$second = substr($date, 12, 2);
	$tstamp = mktime($hour, $minute, $second, $month, $day, $year);
	$out = date("D, M j, Y @ g:i A", $tstamp);
	return $out;
}

// print title of this comic
function print_title($date, $return = false){
	global $home, $comic_dir;
	$file = $home.$comic_dir.$date."/title.txt";
	$title_array = @file($file);
	if (!$title_array) {
		$title = "";
	}
	else {
		$title = @implode("", $title_array);
	}
	if (!$return) { 
		print $title;
	}
	else {
		return $title;
	}
}

// get array containing all dates that comics were made....
function get_dates($dirname) {
        static $result_array=array();
        $handle = opendir($dirname);
        while (false !== ($file = readdir($handle))) {
                if($file=='.'||$file=='..') {
                        continue;
                }
                if(is_dir($dirname.$file)) {
			$result_array[]=$file;
                }
                else {
 			continue;
                }
        }
        closedir($handle);
        return $result_array;
}

?>
