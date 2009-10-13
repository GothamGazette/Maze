<?php
/**
 * @package		Gotham Gazette Budget Game
 * @subpackage	Helpers
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

if (false === class_exists('Security_helper'))
{
    class Security_helper
    {
        function getRoles()
        {
            $query = 'SELECT CONCAT( REPEAT(\'&nbsp;&nbsp;&nbsp;\', COUNT(parent.name) - 1), node.name) AS name, node.link AS role_id, node.id'
            . ' FROM acl_aros AS node,'
            . ' acl_aros AS parent'
            . ' WHERE node.lft BETWEEN parent.lft AND parent.rgt'
            . ' GROUP BY node.name'
            . ' ORDER BY node.lft';

            $ci = &get_instance();

            $rs = $ci->db->query($query);
            return $rs->result();
        }

        function getRoleInput($input_name, $user_id)
        {
            $ci = &get_instance();
            
            $user_roles = Security_helper::getUserRoles($user_id);

            $value_groups = array();
            
            foreach ($user_roles as $role)
            {
                $value_groups[] = $role->role_id;    
            }
            
            $html = '<select size="8" name="' . $input_name. '">';

            $optgroup = '';

            $roles = Security_helper::getRoles();

            foreach ($roles as $row)
            {
                if (true === empty($row->role_id))
                {
                    if ($optgroup != $row->name)
                    {
                        if (true === empty($optgroup))
                        {
                            $html .= '</optgroup>';
                        }

                        $html .= '<optgroup label="' . $row->name . '">';
                        $optgroup = $row->name;
                    }
                }
                else
                {
                    $html .= '<option value="' . $row->role_id . '"' . (true == in_array($row->role_id, $value_groups) ? ' selected="selected"' : '') . '>' . $row->name . '&nbsp;&nbsp;&nbsp;</option>';
                }
            }

            $html .= '</optgroup></select>';

            return $html;
        }

        function getUserRoles($user_id)
        {
            $ci = &get_instance();

            $query = 'SELECT ur.role_id, r.name'
            . ' FROM user_roles AS ur'
            . ' INNER JOIN roles AS r ON r.id = ur.role_id'
            . ' WHERE ur.user_id = ?';

            $rs = $ci->db->query($query, array($user_id));

            return $rs->result();
        }
    }
}
?>