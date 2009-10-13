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

<div id="login_wrapper">
	<div id="login_box"> 
    	<span class="b1h"></span><span class="b2h"></span><span class="b3h"></span><span class="b4h"></span>
    	<div class="headh">
    		<h3>Administration Login</h3>
    	</div>
        <div class="contenth">  
            <?php echo form_open('admin/signin', array('class' => 'cmxform')); ?>
                <ol class="fields">
                    <li>
                        <label for="username">Username</label>
                        <input type="text" name="username" value="<?php echo (true === isset($username)) ? $username : ''; ?>" maxlength="16" />
                    </li>
                    <li>
                        <label for="password">Password</label>
                        <input type="password" name="password" value="" />
                    </li>
                    <li>
                    	<label></label>
                    	<button type="submit">Login</button>
                    </li>
                </ol>
            <?php echo form_close(); ?>
        </div>
    	<span class="b4bh"></span><span class="b3bh"></span><span class="b2bh"></span><span class="b1h"></span>
    </div>
</div>