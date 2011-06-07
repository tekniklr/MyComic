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
 * comic_header.php
 * Contains html/PHP code that will aid in formatting the
 * beginning of each page.
 *
 */
include('comic_config.php');
include('comic_common.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd ">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<title><?=$title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="<?php echo $path; ?>/includes/stylesheet.css" type="text/css" />
</head>

<body>

<center><table border="0" cellpadding="5" cellspacing="10"><tr>
<td valign="middle" align="left"><a href="<?php echo $path; ?>/index.php">Main</a></td>
<td valign="middle" align="left"><a href="<?php echo $path; ?>/archives.php">Archives</a></td>
<td valign="middle" align="left"><a href="<?php echo $path; ?>/gallery.php">Gallery</a></td>
<td valign="middle" align="left"><a href="<?php echo $path; ?>/rant.php">Rant</a></td>
<td valign="middle" align="left"><a href="<?php echo $path; ?>/rss.php">RSS</a></td>
<td valign="middle" align="left"><a href="<?php echo $path; ?>/admin/">Admin</a></td>
</tr></table></center>

