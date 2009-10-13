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

if (false === function_exists('script_tag'))
{
    function script_tag($href = '', $type = 'text/javascript', $index_page = FALSE)
    {
        $CI =& get_instance();

        $link = '<script ';

        if (is_array($href))
        {
            foreach ($href as $k=>$v)
            {
                if ($k == 'href' AND strpos($k, '://') === FALSE)
                {
                    if ($index_page === TRUE)
                    {
                        $link .= ' src="'.$CI->config->site_url($v).'" ';
                    }
                    else
                    {
                        $link .= ' src="'.$CI->config->slash_item('base_url').$v.'" ';
                    }
                    
                    $link .= ' type="' . $type . '"';
                }
                else
                {
                    $link .= "$k=\"$v\" ";
                }
            }
            	
            $link .= "/></script>\n";
        }
        else
        {
            if ( strpos($href, '://') !== FALSE)
            {
                $link .= ' src="'.$href.'" ';
            }
            elseif ($index_page === TRUE)
            {
                $link .= ' src="'.$CI->config->site_url($href).'" ';
            }
            else
            {
                $link .= ' src="'.$CI->config->slash_item('base_url').$href.'" ';
            }

            $link .= ' type="' . $type . '"';
            
            $link .= '/></script>'."\n";
        }


        return $link;
    }
}
?>