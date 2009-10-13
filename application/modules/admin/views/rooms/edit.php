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
            	<label for="row">Row <em>*</em></label>
                <input type="text" name="row" value="<?php echo $room->row; ?>" />
            </li>
            <li>
            	<label for="column">Column <em>*</em></label>
                <input type="text" name="column" value="<?php echo $room->column; ?>" />
            </li>
            <li>
            	<label for="tile">Tile <em>*</em></label>
                <?php echo $tiles; ?>
            </li>
            <li>
            	<label for="level">Level <em>*</em></label>
                <?php echo $levels; ?>
            </li>
            <li>
            	<label for="image">Image</label>
                <input type="text" name="image" value="<?php echo $room->image; ?>" />
            </li>
            <li>
            	<label for="question">Question</label>
                <?php echo $questions; ?>
            </li>
            <li><label for="force_orientation">Force Orientation</label>
            <?php echo $force_orientations; ?>
            </li>
            <li>
            	<label for="start_point">Start Point</label>
                <input type="radio" name="start_point" value="1" <?php echo (1 == $room->start_point) ? 'checked="checked"' : ''; ?> /> Yes
                <input type="radio" name="start_point" value="0" <?php echo (0 == $room->start_point) ? 'checked="checked"' : ''; ?> /> No
            </li>
            <li>
            	<label for="end_point">End Point</label>
                <input type="radio" name="end_point" value="1" <?php echo (1 == $room->end_point) ? 'checked="checked"' : ''; ?> /> Yes
                <input type="radio" name="end_point" value="0" <?php echo (0 == $room->end_point) ? 'checked="checked"' : ''; ?> /> No
            </li>
            <li>
            	<label>Direction Overrides</label>
            	<fieldset>
            		<ol class="fields">
                		<li>
                			<label for="override_exit_north">Disallow North</label>
                			<input type="checkbox" name="override_exit_north" value="1" <?php echo (1 == $room->override_exit_north) ? 'checked="checked"' : ''; ?> />
                		</li>
                		<li>
                			<label for="override_exit_south">Disallow South</label>
                			<input type="checkbox" name="override_exit_south" value="1" <?php echo (1 == $room->override_exit_south) ? 'checked="checked"' : ''; ?> />
                		</li>
                		<li>
                			<label for="override_exit_east">Disallow East</label>
                			<input type="checkbox" name="override_exit_east" value="1" <?php echo (1 == $room->override_exit_east) ? 'checked="checked"' : ''; ?> />
                		</li>
                		<li>
                			<label for="override_exit_west">Disallow West</label>
                			<input type="checkbox" name="override_exit_west" value="1" <?php echo (1 == $room->override_exit_west) ? 'checked="checked"' : ''; ?> />
                		</li>
                	</ol>
            	</fieldset>
            </li>
    	</ol>
    </fieldset>
	<input type="hidden" name="id" value="<?php echo $room->id; ?>" />
	<input type="hidden" name="task" value="" />
</form>