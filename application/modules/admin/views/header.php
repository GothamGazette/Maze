<?php
/**
 * @package		Gotham Gazette Budget Game
 * @subpackage	Admin
 * @copyright	Copyright (C) 2008 Gotham Gazette. All rights reserved.
 * @license		GNU/GPL, see LICENSE.txt
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title></title>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<?php $this->output->enable_profiler(true); ?>
<?php echo link_tag('styles/admin.css'); ?>
<?php echo script_tag('scripts/jquery-1.2.3.pack.js'); ?>
<?php echo script_tag('scripts/maze.js'); ?>
<?php echo script_tag('scripts/plugins/cmxform.js'); ?>
<?php echo script_tag('scripts/plugins/jquery.domec.js'); ?>
<?php echo script_tag('scripts/plugins/jquery.simplemodal.js'); ?>

<!-- IE 6 hacks -->
<!--[if lt IE 7]>
<?php echo link_tag('styles/admin_ie6.css'); ?>
<![endif]-->

<script>
	$(document).ready(function() {
		$('.adminlist tr:has(:checkbox)').each(function() {
			$(this).find('td:eq(1)').click(function() {
				editRow(this);
			}).wrapInner('<a href="#"></a>');
		});
	});
</script>
</head>

<body>
	<div id="wrapper">
		<div id="content">
<?php
$this->load->view('menubar');
$this->load->view('toolbar');
?>