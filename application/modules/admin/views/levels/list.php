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

<form id="adminform" action="<?php echo site_url('admin/levels'); ?>" method="post">
	<table class="adminlist">
    	<thead>
        	<tr>
            	<th width="10">&nbsp;</th>
            	<th>Title</th>
                <th width="50">Ordering</th>
            </tr>
        </thead>
        <tbody>
<?php
foreach ($levels as $level)
{
?>
			<tr>
            	<td><input type="checkbox" name="cid[]" value="<?php echo $level->id; ?>" /></td>
                <td><?php echo $level->title; ?></td>
                <td><?php echo $level->ordering; ?></td>
            </tr>
<?php
}
?>
        </tbody>
        <tfoot>
        	<tr>
            	<td colspan="1"><?php echo $this->pagination->create_links(); ?></td>
            </tr>
        </tfoot>
    </table>
	<input type="hidden" name="task" value="" />
</form>
