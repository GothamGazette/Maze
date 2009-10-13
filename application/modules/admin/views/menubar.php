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
if ('login' !== $this->uri->segment(2) && 'signin' !== $this->uri->segment(2))
{
?>
<div id="menubar">
	<ul>
    	<li class="<?php echo ('users' === $this->uri->segment(2)) ? 'selected' : ''; ?>"><a href="<?php echo site_url('admin/users'); ?>">Edit Users</a></li>
		<li class="<?php echo ('levels' === $this->uri->segment(2)) ? 'selected' : ''; ?>"><a href="<?php echo site_url('admin/levels'); ?>">Edit Levels</a></li>
        <li class="<?php echo ('rooms' === $this->uri->segment(2)) ? 'selected' : ''; ?>"><a href="<?php echo site_url('admin/rooms'); ?>">Edit Rooms</a></li>
        <li class="<?php echo ('questions' === $this->uri->segment(2)) ? 'selected' : ''; ?>"><a href="<?php echo site_url('admin/questions'); ?>">Edit Questions</a></li>
        <li class="<?php echo ('tiles' === $this->uri->segment(2)) ? 'selected' : ''; ?>"><a href="<?php echo site_url('admin/tiles'); ?>">Edit Tiles</a></li>
        <li class="<?php echo ('badges' === $this->uri->segment(2)) ? 'selected' : ''; ?>"><a href="<?php echo site_url('admin/badges'); ?>">Edit Badges</a></li>
        <li class=""><a href="<?php echo site_url('admin/logout'); ?>">Logout</a></li>
    </ul>
</div>
<div style="clear: both;"></div>
<?php
}
?>