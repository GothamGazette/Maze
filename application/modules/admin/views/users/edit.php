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
            	<label for="username">User name <em>*</em></label>
                <input type="text" name="username" value="<?php echo $user->username; ?>" />
            </li>
            <li>
            	<label for="email">Email <em>*</em></label>
                <input type="text" name="email" value="<?php echo $user->email; ?>" />
            </li>
            <li>
            	<label for="email">Password <em>*</em></label>
                <input type="password" name="password" value="" />
            </li>
            <li>
            	<label for="email">Confirm password <em>*</em></label>
                <input type="password" name="confirm_password" value="" />
            </li>
            <li>
            	<label for="roles">Role</label>
            	<?php echo Security_helper::getRoleInput('roles', $user->id); ?>
            </li>
        </ol>
    </fieldset>
	<input type="hidden" name="id" value="<?php echo $user->id; ?>" />
	<input type="hidden" name="task" value="" />
</form>