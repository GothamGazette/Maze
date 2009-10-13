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

if (false === class_exists('User_helper'))
{
    class User_helper
    {
        public function loginUser($name, $password, &$usersession)
        {
            $ci = &get_instance();
            $query = 'SELECT * FROM ' . $ci->db->protect_identifiers('users')
            . ' WHERE username = ?';

            $rs = $ci->db->query($query, array($name));

            if (0 < $rs->num_rows())
            {
                $row = $rs->row();

                $pwd_arr = explode(':', $row->password);

                if (1 < sizeof($pwd_arr))
                {
                    $password = $password . $pwd_arr[1];
                }

                if (md5($password) == $pwd_arr[0])
                {
                    $usersession->id = $row->id;
                    $usersession->name = $row->username;
                    $usersession->roles = array();

                    $roles = Security_helper::getUserRoles($usersession->id);

                    foreach ($roles as $role)
                    {
                        $usersession->roles[] = $role->name;
                    }

                    return true;
                }
            }

            return false;
        }

        public function isUserAuthorized(&$usersession, $aco, $axo)
        {
            $ci = &get_instance();

            $authorized = false;

            foreach($usersession->roles as $role)
            {
                $authorized = $authorized || $ci->khacl->check($role, $aco, $axo);
            }

            return $authorized;
        }

        function logoutUser()
        {
            $ci = &get_instance();

            $ci->session->sess_destroy();
        }
    }
}
?>