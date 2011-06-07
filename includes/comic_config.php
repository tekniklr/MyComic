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
 * comic_config.php
 * Contains global variables and configuration settings.
 *
 */

// The name of your site.  This will be used in the RSS feed, but you can also
// call it in the header or footer functions.
$title = "My Comic Demo";
 
// Path to files on the server-
// e.g. the output of the 'pwd' unix command for the document root directory
$home = "/path/to/documentroot/";

// Path to comic dir relative to the document root-
// e.g. "" if the comics are in the root of "http://mycomic.com"
//      "/comic" if they are in "http://mystuff.com/comic/"
$path = "/path/to/MyComic";

// Directory where comics live
$comic_dir = $path."/archives/";

// Permissions that new files will have.
// Files will be owned by the user/group that apache runs as-
// so this must be at least 0775 if you are in the same group
// (and you want to be able to easily delete/move/edit these
// files later)
// If you are not in the same group, it must be 0777
$mask = 0777;

// Valid file types to consider as comics
$exts = array("gif", "GIF", "png", "PNG", "jpg", "JPG", "jpeg", "JPEG", "bmp", "BMP", "mng", "MNG");

// Avatar dimensions - avatar images will be scaled to this
// width and height in the news display
$av_height = 100;
$av_width = 100;

// Email addresses for each user
define("user1_mail", "user1@example.com");
define("user2_mail", "user2@example.com");
define("user3_mail", "user3@example.com");

// Arrays of usernames who have access to the various admin functions
$news_group = array("user1", "user2", "user3"); // e.g. everyone can post news
$comic_group = array("user1");
$gallery_group = array("user1", "user2");
$rant_group = array("user1", "user3");

?>
