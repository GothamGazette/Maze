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

if (false === class_exists('NavigationVO'))
{
    class NavigationVO
    {
        /**
         * Room
         *
         * @var RoomVO
         */
        public $room;

        /**
         * Success
         *
         * @var boolean
         */
        public $success;

        /**
         * Error message
         *
         * @var MessageVO
         */
        public $message;
        
        /**
         * URI to redirect to
         *
         * @var string
         */
        public $redirect;
		
		/**
		 * Debugging
		 *
		 * @var string
		 */
		public $debug;
		
    }
}

if (false === class_exists('RoomVO'))
{
    class RoomVO
    {
        /**
         * Image
         *
         * @var string
         */
        public $image;

        /**
         * Question
         *
         * @var QuestionVO
         */
        public $question;

        /**
         * Navigation
         *
         * @var array
         */
        public $navigation = array('forward' => null, 'back' => null, 'right' => null, 'left' => null);

        /**
         * Map position X
         *
         * @var int
         */
        public $row;

        /**
         * Map position Y
         *
         * @var int
         */
        public $column;

        /**
         * Map image
         *
         * @var string
         */
        public $map_image;
    }
}

if (false === class_exists('AllowedNavigationVO'))
{
    class AllowedNavigationVO
    {
        public $allowed = false;
        
        public $message;
    }
}

if (false === class_exists('QuestionVO'))
{
    class QuestionVO
    {
        /**
         * Title
         *
         * @var string
         */
        public $title;

        /**
         * Description
         *
         * @var string
         */
        public $description;

        /**
         * Javascript function
         *
         * @var string
         */
        public $action_function;

        /**
         * Target image
         *
         * @var string
         */
        public $target_image;
        
        /**
         * Target position X
         *
         * @var int
         */
        public $target_pos_x;

        /**
         * Target position Y
         *
         * @var int
         */
        public $target_pos_y;

        /**
         * Target position height
         *
         * @var int
         */
        public $target_height;

        /**
         * Target position width
         *
         * @var int
         */
        public $target_width;

        /**
         * Responses
         *
         * @var array
         */
        public $responses = array();
        
        /**
         * Completed
         *
         * @var boolean
         */
        public $completed;
    }
}

if (false === class_exists('ResponseVO'))
{
    class ResponseVO
    {
        /**
         * Id
         *
         * @var int
         */
        public $id;

        /**
         * Title
         *
         * @var string
         */
        public $title;

        /**
         * Image
         *
         * @var string
         */
        public $image;

        /**
         * Hover image
         *
         * @var string
         */
        public $image_hover;

        /**
         * Position X
         *
         * @var int
         */
        public $image_pos_x;

        /**
         * Position Y
         *
         * @var int
         */
        public $image_pos_y;
        
        /**
         * Height
         *
         * @var int
         */
        public $height;
        
        /**
         * Width
         *
         * @var int
         */
        public $width;
    }
}

if (false === class_exists('AnswerVO'))
{
    class AnswerVO
    {
        /**
         * Success
         *
         * @var boolean
         */
        public $success;

        /**
         * Messages
         *
         * @var array
         */
        public $messages = array();
        
        /**
         * Whether correct
         *
         * @var boolean
         */
        public $move_ahead;
        
        /**
         * End game immediately
         *
         * @var boolean
         */
        public $end_game_immediately;
        
        /**
         * Total points
         *
         * @var int
         */
        public $points;
        
        /**
         * Response
         *
         * @var string
         */
        public $response;
        
        /**
         * Time remaining
         *
         * @var int
         */
        public $time_remaining;
        
        /**
         * Progress image
         *
         * @var string
         */
        public $progress_img;
        
        /**
         * New room if answer correct
         *
         * @var RoomVO
         */
        public $new_room;
    }
}

if (false === class_exists('MessageVO'))
{
    class MessageVO
    {
        /**
         * Title
         *
         * @var string
         */
        public $title;
        
        /**
         * Message
         *
         * @var string
         */
        public $message;
        
        /**
         * Action text
         *
         * @var string
         */
        public $actiontext;
        
		/**
         * Javascript action
         *
         * @var string
         */
        public $action;
    }
}
?>
