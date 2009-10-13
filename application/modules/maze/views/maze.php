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
<div id="maze">
	<table id="maze_message">
		<tr>
			<td width="100%" height="100%">
        		<p id="message_title"></p>
        		<p id="message_content"></p>
        		<p id="message_action"><a href="#"></a></p>
        	</td>
        </tr>
	</table>
	<div id="maze_content">
    	<div id="level_selection">
    		<table id="levels">
    			<tr>
<?php
foreach ($levels as $level)
{
?>
    				<td>
    					<a href="<?php echo site_url('maze/describe/' . $level->id); ?>" title="<?php echo $level->tooltip; ?>" class="level <?php echo $level->css_class; ?>" onclick="loadLevel(this.href); return false;">&nbsp;</a>
    				</td>
<?php
}
?>			
    			</tr>
    		</table>
    	</div>
	</div>
</div>

<script>
$(document).ready(function() {
	$('a.level').tooltip({
		track: true,
		delay: 0,
		fixPNG: true,
		showURL: false
	}).click(function() {
		return false;
	}).ifixpng();
});
</script>
