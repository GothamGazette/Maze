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

<?php 
if (false === empty($actions))
{
	$actions = array_reverse($actions);
?>
<div id="toolbar">
	<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>  
    <div class="contentb">  
    	<h2><?php echo $title; ?></h2>
<?php
	foreach ($actions as $action)
	{
?>
		<div><a href="#" onclick="submit_form('<?php echo strtolower($action); ?>'); return false;" class="action_<?php echo strtolower($action); ?>" title="<?php echo $action; ?>">&nbsp;</a></div>
<?php
	}
?>    	
	</div> 
    <b class="b4"></b><b class="b3"></b><b class="b2"></b><b class="b1"></b>
</div>
<?php
}
?>