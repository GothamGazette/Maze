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
                <input type="text" name="name" value="<?php echo $badge->name; ?>" size="35" />
            </li>
            <li>
            	<label for="level_id">Level<em>*</em></label>
                <?php echo $levels; ?>
            </li>
            <li>
            	<label for="image">Image <em>*</em></label>
                <input type="text" name="image" value="<?php echo $badge->image; ?>" size="64" />
            </li>
            <li>
            	<label for="minimum_points">Min. Points <em>*</em></label>
                <input type="text" name="minimum_points" size="5" value="<?php echo $badge->minimum_points; ?>" size="5" />
            </li>
        </ol>
    </fieldset>
	<input type="hidden" name="id" value="<?php echo $badge->id; ?>" />
	<input type="hidden" name="task" value="" />
</form>