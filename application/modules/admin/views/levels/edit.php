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
            	<label for="title">Title<em>*</em></label>
                <input type="text" name="title" value="<?php echo $level->title; ?>" size="35" />
            </li>
            <li>
            	<label for="tooltip">Tooltip <em>*</em></label>
                <input type="text" name="tooltip" value="<?php echo $level->tooltip; ?>" size="35" />
            </li>
            <li>
            	<label for="introduction">Introduction <em>*</em></label>
                <textarea name="introduction" rows="8" cols="50"><?php echo $level->introduction; ?></textarea>
            </li>
            <li>
            	<label for="complete_text">Completion Text <em>*</em></label>
                <textarea name="complete_text" rows="8" cols="50"><?php echo $level->complete_text; ?></textarea>
            </li>
            <li>
            	<label for="failed_text">Failed Text <em>*</em></label>
                <textarea name="failed_text" rows="8" cols="50"><?php echo $level->failed_text; ?></textarea>
            </li>
            <li>
            	<label for="css_class">CSS Class <em>*</em></label>
                <input type="text" name="css_class" value="<?php echo $level->css_class; ?>" />
            </li>
            <li>
            	<label for="ordering">Ordering</label>
            	<input type="text" name="ordering" value="<?php echo $level->ordering; ?>" size="5" />
            </li>
        </ol>
    </fieldset>
	<input type="hidden" name="id" value="<?php echo $level->id; ?>" />
	<input type="hidden" name="task" value="" />
</form>
