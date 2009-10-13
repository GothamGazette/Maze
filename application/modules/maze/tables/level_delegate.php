<?php
/**
 * @package		Gotham Gazette Budget Game
 * @subpackage	Maze
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

class Level_delegate extends Table_delegate
{
    public $id;
    public $title;
    public $tooltip;
    public $introduction;
    public $complete_text;
    public $failed_text;
    public $css_class;
    public $ordering;
    
    public function __construct($id = null)
    {
        parent::__construct('levels', 'id', $id);
    }
}
?>
