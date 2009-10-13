<?php
/**
 * @package		Gotham Gazette Budget Game
 * @subpackage	Libraries
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


define('MEMBER_SESSION_KEY', 'usersession');

class UserSession
{
    var $id;
    var $name;
    var $roles = array();

    function UserSession()
    {
        $ci = &get_instance();
        $ci->load->library('session');
        $ci->load->helper('object');
        $ci->load->helper('array');

        $session = $ci->session->userdata(MEMBER_SESSION_KEY);

        if (false === empty($session))
        {
            ArrayHelper::bindArrayToObject($session, $this);
        }
        else
        {
            $this->id = 0;
            $this->roles[] = 'Guest';

            $this->_refreshSession();
        }
    }
    
    public function __destruct()
    {
        $this->_refreshSession();
    }

    private function _refreshSession()
    {
        $ci = &get_instance();
        $ci->session->set_userdata(MEMBER_SESSION_KEY, ObjectHelper::toArray($this, false));
    }

    function isAuthorized($aco, $axo = null)
    {
        return User_helper::isUserAuthorized($this, $aco, $axo);
    }

    function login($name, $password)
    {
        $ci = &get_instance();

        $result = User_helper::loginUser($name, $password, &$this);

        if ($result)
        {
            $this->_refreshSession();
        }

        return $result;
    }

    function logout()
    {
        return User_Helper::logoutUser();
    }
}
?>
