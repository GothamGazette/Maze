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

<div id="maze_complete">
	<div class="enter"><?php echo $title; ?></div>
	<p><?php echo $text; ?></p>
	<div id="budget_widget">
		<div id="treasure_chest_left"></div>
		<div id="treasure_chest_right"></div>
		<div id="widget"><?php echo $widget; ?></div>
	</div>
	<p style="clear: both;">Invite your friends to descend into the budget dungeon by cutting and pasting the HTML below to place a badge on your blog or website:</p>
	<p id="widget_code">&lt;!-- GOTHAM GAZETTE  --&gt;&lt;a href="http://www.gothamgazette.com/article/issueoftheweek/20080519/200/2525" target="_blank" title="Can you navigate the budget?"&gt;<?php echo htmlentities($widget); ?>&lt;/a&gt;&lt;!-- GOTHAM GAZETTE --&gt;</p>
	<p><a class="enter" href="<?php echo site_url('maze'); ?>">Play another level</a></p>
	<p>Visit <a onclick="window.opener.open('/city/'); window.opener.focus(); return false" title="Gotham Gazette City Government">Gotham Gazette's City Government </a> section to find regular coverage of budget deliberations and city policy debates, or to sign up for Searchlight, our weekly newsletter that delivers news from City Hall right to your inbox.</p>
</div>
<script>
$('#maze_complete img').ifixpng();
$('#treasure_chest_left').ifixpng();
$('#treasure_chest_right').ifixpng();
</script>
