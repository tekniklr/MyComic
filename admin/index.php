<?php
/*  Copyright (C) 2002 tekniklr
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
 * admin.php
 * Contains functions for administration:
 * adding news, comics, gallery art, rants, etc
 * 
 * There aren't any tools here to modify or delete existing content-
 * But a FTP client works  :)
 *
 */


function printform($name){
	global $news_group, $comic_group, $gallery_group, $rant_group;

	// processing forms
	if ($_POST['function']){

		if ($_POST['function']=="news_preview"){
			preview_news();
		}
		else if ($_POST['function']=="news_add"){
			add_news();
		}
		else if ($_POST['function']=="comic_add"){
			add_comic();
		}
		else if ($_POST['function']=="gallery_add"){
			add_gallery();
		}
		else if ($_POST['function']=="rant_add"){
			add_rant();
		}
		else {
			print "Good job, you broke it. (nimrod)";
		}
	}
	
	// first time, show the forms
	else {
		print "<center><span style=\"font-size: 200%;\">Welcome, " . $name . "</span></center>\n";
		print "<br /><center>\n";

		if (in_array($name, $news_group)){
			print "<a class=\"change\" href=\"#news\">Add News Post</a><br />\n";
		}
		if (in_array($name, $comic_group)){
			print "<a class=\"change\" href=\"#comic\">Add New Comic</a><br />\n";
		}
		if (in_array($name, $gallery_group)){
			print "<a class=\"change\" href=\"#art\">Add New Gallery Art</a><br />\n";
		}
		if (in_array($name, $rant_group)){
			print "<a class=\"change\" href=\"#rant\">Add New Rant</a><br />\n";
		}
		print "</center><br />\n";
		print "<hr noshade=\"noshade\" />\n";
		if (in_array($name, $news_group)){
			print_news_add($name);
		}
		if (in_array($name, $comic_group)){
			print "<hr noshade=\"noshade\" />\n";
			print_comic_add();
		}
		if (in_array($name, $gallery_group)){
			print "<hr noshade=\"noshade\" />\n";	
			print_gallery_add();
		}
		if (in_array($name, $rant_group)){
			print "<hr noshade=\"noshade\" />\n";
			print_rant_add();
		}
	}
}

######################################################################
// FUNCTIONS TO PRINT FORMS
######################################################################

function print_news_add($name){
	global $home, $path, $comic_dir, $av_height, $av_width;

	// identify current comic...
	$dates = get_dates($home.$comic_dir);
	rsort($dates);
	$latest = $dates[0];

	print "<center><span style=\"font-size: 200%;\"><strong><a name=\"news\"></a>Add News Post</strong></span></center>\n";
	print "<center>Adds news to current comic - <strong><u>" . get_date($latest) . "</u></strong> - only!!!!!<br /><strong>MAKE SURE THIS IS THE RIGHT DATE!</strong> If it's not- REFRESH THE PAGE ^^</center><br />\n";

	// find avatar for user...
	$av_dir = $home.$path."/images/avatars";
	$handle = opendir($av_dir);
	$avatar = "none";
	while (false !== ($file = readdir($handle))) {
		$place = strpos($file, '.');
		$av_name = substr($file, 0, $place);
		if ($av_name == $name) {
			$avatar = "/images/avatars/".$file;
		}
	}
	if ($avatar == "none") {
		$avatar = "/images/avatars/404.gif";
	}

	// print form
	print "<form name=\"news\" method=\"post\" action=\"$PHP_SELF\">\n";
	print "<input type=\"hidden\" name=\"function\" value=\"news_preview\" />\n";
	print "<input type=\"hidden\" name=\"latest\" value=\"$latest\" />\n";
	print "<input type=\"hidden\" name=\"name\" value=\"$name\" />\n";
	print "<input type=\"hidden\" name=\"avatar\" value=\"$avatar\" />\n";
	print "<center><table border=\"0\" cellpadding=\"0\" cellspacing=\"20\">\n";
	print "<tr><td>\n";
	print "<img src=\"$path$avatar\" border=\"0\" height=\"$av_height\" width=\"$av_width\" alt=\"$avatar\" />\n";
	print "</td><td>\n";
	print "Subject: (optional) <input type=\"text\" name=\"subject\" size=\"35\" /><br />\n";
	print "<textarea name=\"body\" cols=\"50\" rows=\"10\" style=\"width: 400px;\"></textarea>\n";
	print "</td></tr><tr><td colspan=\"2\" align=\"center\">\n";
	print "<input type=\"submit\" value=\"Preview\" />\n";
	print "</td></tr></table></center></form>\n";
	print "The preview is your friend.  Have fun.  ^^<br />\n";
	input_format();
	print "<br clear=\"all\" />\n\n";
}


function print_comic_add(){
	print "<center><span style=\"font-size: 200%;\"><strong><a name=\"comic\"></a>Add New Comic</strong></span></center>\n";
	
	// get current date string...
	$date = date("Ymd");
	print "<center>(Add comic for " .  get_date($date) . ")</center><br />";

	print "<form name=\"comic\" method=\"post\" action=\"$PHP_SELF\" enctype=\"multipart/form-data\">\n";
	print "<input type=\"hidden\" name=\"function\" value=\"comic_add\" />\n";
	print "<input type=\"hidden\" name=\"date\" value=\"$date\" />\n";
	print "<center><input type=\"file\" name=\"comic\" size=\"35\" /></center>\n";
	print "<br /><center>Title: <input type=\"text\" name=\"title\" size=\"35\" /></center>\n";
	print "<br /><center><input type=\"submit\" value=\"Upload\" /></center>\n";
print "</form>\n";
	print "<br /><br />Comic must be gif, jpg, or png.<br />\n";
print "<br clear=\"all\" />\n\n";
}


function print_gallery_add(){
	print "<center><span style=\"font-size: 200%;\"><strong><a name=\"art\"></a>Add Gallery Art</strong></span></center>\n";
	print "<br /><br /><form name=\"gallery\" method=\"post\" action=\"$PHP_SELF\" enctype=\"multipart/form-data\">\n";
	print "<input type=\"hidden\" name=\"function\" value=\"gallery_add\" />\n";	
	print "<center><strong>Gallery Image:</strong>\n";
	print "<input type=\"file\" name=\"art\" size=\"35\" /></center><br />\n";
	print "<center><strong>Thumbnail Image:</strong>\n";
	print "<input type=\"file\" name=\"thumbnail\" size=\"35\" /></center><br />\n";
	print "<center><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td><strong>Image
Description:</strong> <br /> Make sure what you
enter here looks right.  Copy it and preview it up above (in the <a
class=\"change\" href=\"#news\">news section</a>) if you must.</td>\n";
	print "<td><textarea style=\"width: 400px;\" name=\"info\" cols=\"50\" rows=\"10\"></textarea></td></tr></table></center><br />\n";
	print "<br /><center><input type=\"submit\" value=\"Upload Files\" /></center></form>\n";
	print "<br /><br />Images must be in gif, jpg, or png format.<br /><br />\n";
	input_format();
	print "<br clear=\"all\" />\n\n";
}

function print_rant_add(){
	print "<center><span style=\"font-size: 200%;\"><strong><a name=\"rant\"></a>Add New Rant</strong></span></center>\n";
	// get current date string...
	$date = date("YmdHis");
	print "<br /><br /><form name=\"rant\" method=\"post\" action=\"$PHP_SELF\" enctype=\"multipart/form-data\">\n";
	print "<input type=\"hidden\" name=\"function\" value=\"rant_add\" />\n";
	print "<input type=\"hidden\" name=\"date\" value=\"$date\" />\n";
	print "<br /><center>Title: <input type=\"text\" name=\"title\" size=\"35\" /></center>\n";
	print "<br /><center>Image location:
		<input type=\"radio\" name=\"imageloc\" value=\"no\" checked=\"checked\" /> No Image
	 	<input type=\"radio\" name=\"imageloc\" value=\"top\" /> Top
		<input type=\"radio\" name=\"imageloc\" value=\"bottom\" /> Bottom\n";
	print "<br /><input type=\"file\" name=\"imagefile\" size=\"35\" /></center><br />\n";
	print "<center><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td><strong>Image Description:</strong> <br /> Make sure what you enter here looks right.  Copy it and preview it up above (in the <a class=\"change\" href=\"#news\">news section</a>) if you must.</td>\n";
	print "<td><textarea name=\"info\" cols=\"50\" rows=\"10\" style=\"width: 400px;\"></textarea></td></tr></table></center><br />\n";
	print "<br /><center><input type=\"submit\" value=\"Go For It!\" /></center></form>\n";
	print "<br /><br />Images must be in gif, jpg, or png format.<br /><br />\n";
	input_format();
	print "<br clear=\"all\" />\n\n";
}

######################################################################
// FUNCTIONS TO PREVIEW THINGS
######################################################################


function preview_news(){
	global $home, $path, $comic_dir, $av_height, $av_width;
	$body = input_convert($_POST['body']);
	$_POST['body'] = $body;
	$_POST['subject'] = str_replace("\"", "&quot;", $_POST['subject']);

	// print it out as it will be seen later....
	print "<center><table border=\"0\" cellpadding=\"10\" cellspacing=\"0\" width=\"95%\">\n";
	print "<tr><td class=\"tint\">\n";
	print "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
	print "<tr><td rowspan=\"3\">\n";
	print "<img src=\"$path" . $_POST['avatar'] . "\" border=\"0\" alt=\"" . $_POST['avatar'] . "\" width=\"$av_width\" height=\"$av_height\" />\n";
	print "</td><td rowspan=3>&nbsp;&nbsp;&nbsp;</td><td align=\"right\" width=\"100%\">\n";
	if (strlen($_POST['subject'])>2){
		print stripslashes($_POST['subject']);
	}
	print "</td></tr><tr><td align=\"left\">\n";
	print "<span style='font-size: larger;'><strong>" . $_POST['name'] . "</strong></span><br />\n";
	print "</td></tr><tr><td align=\"left\">\n";
	print "<em>" . date("D, M j, Y @ g:i A") . "</em><br />\n";
	print "</td></tr></table>\n";
	print "<hr noshade=\"noshade\" />\n";
	print html_entity_decode($body) . "\n";
	print "</table></center><br />\n";

	// make the form
	print "<form method=\"post\" action=\"$PHP_SELF\">\n";
	print "<input type=\"hidden\" name=\"function\" value=\"news_add\" />\n";
	print "<input type=\"hidden\" name=\"latest\" value=\"" . $_POST['latest'] . "\" />\n";
	print "<input type=\"hidden\" name=\"name\" value=\"" . $_POST['name'] . "\" />\n";
	print "<input type=\"hidden\" name=\"subject\" value=\"" . $_POST['subject'] . "\" />\n";
	print "<input type=\"hidden\" name=\"avatar\" value=\"" . $_POST['avatar'] . "\" />\n";
	print "<input type=\"hidden\" name=\"body\" value=\"" . htmlentities($body) . "\" />\n";
	print "<center><input type=\"submit\" value=\"Go for it!\" /></center>\n";
	print "</form>\n";
	print "<center>Something borken?  Go <a class=\"change\"
href=\"javascript:history.back(1)\">back</a> and fix it!</center>";
}


######################################################################
// FUNCTIONS THAT DO THE WORK IN ADDING THINGS
######################################################################


function add_news(){
	global $home, $comic_dir, $mask;
	$_POST['subject'] = stripslashes($_POST['subject']);
	$_POST['body'] = stripslashes($_POST['body']);
	$output = $_POST['name'] . "\n" .
		"**" . stripslashes($_POST['subject']) . "\n" .
		$_POST['avatar'] . "\n" .
		stripslashes($_POST['body']);
	$date = date("YmdHis");
	$dir = $home.$comic_dir.$_POST['latest'];
	$news_file = fopen($dir."/".$date.".txt", w);
	if (!$news_file) {
		print "Couldn't create the file.... check permissions.";
	}
	else {
		fwrite($news_file, $output);
		fclose($news_file);
		chmod("$dir/$date.txt", $mask);
		print "News added successfully!";
	}
}

function add_comic(){
	global $home, $comic_dir, $mask;
	$dir = $home.$comic_dir.$_POST['date'];
	print "Trying to create directory " . $dir . "...<br />\n";
	if (mkdir($dir, $mask)) {
		chmod($dir, $mask);
		print "Directory created successfully!<br /><br />\n";
		$loc = $_FILES['comic']['tmp_name'];
		$imagesize = getimagesize($loc);
		switch ( $imagesize[2] ) {
			case 0:
				print "Unknown file type.<br /><br />\n";
				break;
			case 1:
				$dest = $dir."/comic.gif";
				break;
			case 2:
				$dest = $dir."/comic.jpg";
				break;
			case 3:
				$dest = $dir."/comic.png";
				break;
		}
		print "Trying to create comic file....<br />\n";
		if (move_uploaded_file($loc, $dest)){
			chmod($dest, $mask);
			print "File created successfully.<br /><br />\n";
			print "Trying to create title...<br />\n";
			$title_file = fopen($dir."/title.txt", w);
			if (!$title_file) {
				print "Couldn't create the file.... check permissions.<br /><br />\n";
			}
			else {
				$_POST['title'] = htmlspecialchars($_POST['title']);
				fwrite($title_file, stripslashes($_POST['title']));
				fclose($title_file);
				chmod("$dir/title.txt", $mask);
				print $_POST['title'] . " added successfully for " . $_POST['date'] . "!!!<br /><br />\n";
			}
		}
		else {
			print "Couldn't create file.  Check permissions.<br /><br />\n";
			rmdir($dir);
		}
	} 
	else {
		print "Error creating directory! Check file permissions!<br /><br />\n";
		print "If you already created a comic today, then don't be so enthusiastic.  Wait a day or two  ^^";
	}
}

function add_gallery(){
	global $home, $path, $comic_diri, $mask;	
	$dir = $home.$path."/gallery/";
	$file = $dir."gallery.txt";
	$date = date("F Y");
	$info = input_convert($_POST['info']);
	$art_name = $_FILES['art']['name'];
	$art_loc = $_FILES['art']['tmp_name'];
	$art_size = round($_FILES['art']['size']/1024, 2) . " K";
	$art_dest = $dir.$art_name;
	$art_http = '<?php echo $path; ?>/gallery/'.$art_name;
	$thumb_name = $_FILES['thumbnail']['name'];
	$thumb_loc = $_FILES['thumbnail']['tmp_name'];
	$thumb_dest = $dir.$thumb_name;
	$thumb_http = '<?php echo $path; ?>/gallery/'.$thumb_name;
	$out = "<tr><td align=\"left\" valign=\"top\">
<a class=\"art\" href=\"$art_http\">
<img class=\"art\" src=\"$thumb_http\" align=\"top\" height=\"100\" width=\"100\" alt=\"$art_http\" /><br /><br /><br />
</a></td>
<td valign=\"top\">\n".html_entity_decode($info)."<br /><em class=\"date\">[$date - $art_size]</em></td></tr>\n";
	if (move_uploaded_file($art_loc, $art_dest)) {
		chmod($art_dest, $mask);
		if (move_uploaded_file($thumb_loc, $thumb_dest)) {
			chmod($thumb_dest, $mask);
			$fout = fopen($file, 'r+');
			$file_c = file($file);
			$old = implode(" ", $file_c);
			$output = $out."\n\n".$old;
			fwrite($fout, $output);
			fclose($fout);
			print "Gallery art added successfully.\n";
		}
		else {
			print "Couldn't create thumbnail.  Check permissions.<br /><br />\n";
		}
	}
	else {
		print "Couldn't create image.  Check permissions.<br /><br />\n";
	}
}

function add_rant(){
	global $home, $path, $comic_dir, $mask;	
	$dir = $home.$path."/rant/";
	$imageloc = $_POST['imageloc'];
	$fname = $dir.$_POST['date'].".txt";
	$file = fopen($fname, "w");
	$title = str_replace("\"", "&quot;", $_POST['title']);
	$title = stripslashes($title);
	$info = input_convert($_POST['info']);
	$img_name = $_FILES['imagefile']['name'];
	$img_loc = $_FILES['imagefile']['tmp_name'];
	$img_dest = $dir.$img_name;
	$img_http = "rant/".$img_name;
	if (strlen($img_name)<4){
		$imageloc = "no";	
	}
	if ($imageloc=="no"){ // no image
		$out = "$title\n".html_entity_decode($info)."\n";
		$continue = true;
	}
	else if ($imageloc=="top"){ // image at top of rant
		if (move_uploaded_file($img_loc, $img_dest)) {
			chmod($img_dest, $mask);
			$im_info = getimagesize($img_dest);
			$out = "$title\n<center><img src=\"$img_http\" border=\"0\" height=\"$im_info[1]\" width=\"$im_info[0]\" alt=\"$img_http\" /></center><br /><br />".html_entity_decode($info)."\n";
			$continue = true;
		}
		else {
			print "<br /><br /><strong>Could not create the image.  Make sure you do not already have another image with the same filename!!!</strong>\n\n";
			$continue = false;
		}
	}
	else if ($imageloc=="bottom"){ // image at bottom of rant
		if (move_uploaded_file($img_loc, $img_dest)) {
			chmod($img_dest, $mask);
			$im_info = getimagesize($img_dest);
			$out = "$title\n$info<br /><br />\n<center><img src=\"$img_http\" border=\"0\" height=\"$im_info[1]\" width=\"$im_info[0]\" alt=\"$img_http\" /></center>\n";
			$continue = true;
		}
		else {
			print "<br /><br /><strong>Could not create the image.  Make sure you do not already have another image with the same filename!!!</strong>\n\n";
			$continue = false;
		}
	}
	if ($continue) {
		fwrite($file, $out);
		fclose($file);
		chmod($fname, $mask);
		print "<br /><br /><strong>$title added successfully!!!</strong><br /><br />\n";
	}
	else {
		print "<br /><br /><strong>Did not try to create the rant because of previous errors.</strong>\n\n";
	}
}

######################################################################
# Functions that do common, trivial tasks
######################################################################
// block of text describing what is allowed in descriptions
function input_format() {
	print "The following BBCode is supported in the description, newlines are converted to &lt;br&gt; tags automagically.<br />\n";
	print "<code>
[url=http://...]<a href=\"#\">linkname</a>[/url]<br />
[b]<strong>bold</strong>[/b]<br />
[i]<em>italic</em>[/i]<br />
[u]<u>underline</u>[/u]<br />
[s]<s>strikethrough</s>[/s]<br />
</code>\n";
}

// converts description to the form it will be saved in
function input_convert($info) {
	$info = nl2br(htmlspecialchars(html_entity_decode($info), ENT_QUOTES));
	$info = preg_replace("/\[url=(.*?)\]/", "<a href=\\1>", $info);
	$info = str_replace("[/url]", "</a>", $info);
	$info = str_replace("[b]", "<strong>", $info);
	$info = str_replace("[/b]", "</strong>", $info);
	$info = str_replace("[i]", "<em>", $info);
	$info = str_replace("[/i]", "</em>", $info);
	$info = str_replace("[u]", "<u>", $info);
	$info = str_replace("[/u]", "</u>", $info);
	$info = str_replace("[s]", "<s>", $info);
	$info = str_replace("[/s]", "</s>", $info);
	$info = str_replace("\"", "&quot;", $info);
	$info = stripslashes($info);
	return $info;
}

######################################################################
// Stuff happens here!
######################################################################
include('../includes/comic_header.php');
print "<table class=\"tint\" width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td>\n";
print "<center><span style=\"font-size: 200%;\"><strong>$title Admin Page</strong></span></center><br />\n";
$username = @$_SERVER['REMOTE_USER'];
if (empty($username)) {
	$username = $_SERVER['REDIRECT_REMOTE_USER'];
}
printform($username);
print "</td></tr></table>\n";
include('../includes/comic_footer.php');

?>

