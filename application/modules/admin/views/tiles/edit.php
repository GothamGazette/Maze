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

<form id="adminform" class="cmxform" action="<?php echo site_url($this->uri->uri_string()); ?>" method="post">
	<fieldset>
        <ol class="fields">
        	<li>
            	<label for="name">Name<em>*</em></label>
                <input type="text" name="name" value="<?php echo $tile->name; ?>" size="35" />
            </li>
            <li>
            	<label for="category">Category <em>*</em></label>
                <input type="text" name="category" value="<?php echo $tile->category; ?>" size="35" />
            </li>
            <li>
            	<label for="map_image">Map Image <em>*</em></label>
                <input type="text" name="map_image" size="64" value="<?php echo $tile->map_image; ?>" />
            </li>
            <li>
            	<label for="default_image">Default Image</label>
                <input type="text" name="default_image" size="64" value="<?php echo $tile->default_image; ?>" />
            </li>
            <li>
            	<label for="exit_north">Exit North <em>*</em></label>
                <input type="radio" name="exit_north" value="1" <?php echo (1 == $tile->exit_north) ? 'checked="checked"' : ''; ?> /> Yes
                <input type="radio" name="exit_north" value="0" <?php echo (0 == $tile->exit_north) ? 'checked="checked"' : ''; ?> /> No
            </li>
            <li>
            	<label for="exit_east">Exit East <em>*</em></label>
                <input type="radio" name="exit_east" value="1" <?php echo (1 == $tile->exit_east) ? 'checked="checked"' : ''; ?> /> Yes
                <input type="radio" name="exit_east" value="0" <?php echo (0 == $tile->exit_east) ? 'checked="checked"' : ''; ?> /> No
            </li>
            <li>
            	<label for="exit_south">Exit South <em>*</em></label>
                <input type="radio" name="exit_south" value="1" <?php echo (1 == $tile->exit_south) ? 'checked="checked"' : ''; ?> /> Yes
                <input type="radio" name="exit_south" value="0" <?php echo (0 == $tile->exit_south) ? 'checked="checked"' : ''; ?> /> No
            </li>
            <li>
            	<label for="exit_west">Exit West <em>*</em></label>
                <input type="radio" name="exit_west" value="1" <?php echo (1 == $tile->exit_west) ? 'checked="checked"' : ''; ?> /> Yes
                <input type="radio" name="exit_west" value="0" <?php echo (0 == $tile->exit_west) ? 'checked="checked"' : ''; ?> /> No
            </li>
        </ol>
    </fieldset>
	<input type="hidden" name="id" value="<?php echo $tile->id; ?>" />
	<input type="hidden" name="task" value="" />
</form>