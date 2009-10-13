<?php
/**
 * @package		Gotham Gazette Budget Game
 * @subpackage	Maze
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
<?php echo link_tag('styles/styles.css'); ?>
<!--[if IE 6]>
<?php echo link_tag('styles/ie.css'); ?>
<![endif]-->
<?php echo script_tag('scripts/jquery-1.2.3.pack.js'); ?>
<?php echo script_tag('scripts/maze.js'); ?>
<?php echo script_tag('scripts/plugins/jquery.tooltips.js'); ?>
<?php echo script_tag('scripts/plugins/jquery.dimensions.js'); ?>
<?php echo script_tag('scripts/plugins/jquery.bgiframe.js'); ?>
<?php echo script_tag('scripts/plugins/jquery.blockUI.js'); ?>
<?php echo script_tag('scripts/plugins/jquery.ifixpng.js'); ?>
<?php echo script_tag('scripts/plugins/jquery.domec.js'); ?>
<?php echo script_tag('scripts/firebug/firebug.js'); ?>

<base href="<?php echo site_url(''); ?>" />

<script type="text/javascript">
$(document).ready(function() {
	$.blockUI.defaults.css = {};
	$.blockUI.defaults.message = '<img src="<?php echo site_url('images/ajax-loader.gif'); ?>" />';
	$.blockUI.defaults.overlayCSS.opacity =  '0.8';
	
	if (!$.browser.msie || $.browser.version >= 7) {
    	$().ajaxStart(function() {
    		$('#maze').block();
    	}).ajaxStop(function() {
    		$('#maze').unblock();
    	});
	}

});
</script>
</head>

<body>
