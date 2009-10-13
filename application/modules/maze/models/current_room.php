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

/**
 * Model for current room
 *
 */
class Current_room extends Model
{
    /**
     * Room id
     *
     * @var int
     */
    private $_room_id;

    /**
     * Room
     *
     * @var object
     */
    private $_room;

    /**
     * Current row
     *
     * @var int
     */
    private $_row;

    /**
     * Current column
     *
     * @var int
     */
    private $_column;

    /**
     * Question
     *
     * @var Question_delegate
     */
    private $_question;

    /**
     * Responses
     *
     * @var array
     */
    private $_responses;

    /**
     * Room user is redirected to after answering a question
     *
     * @var object
     */
    private $_redirect_room;

    /**
     * Constructor
     *
     * @return Current_room
     */
    public function Current_room()
    {
        parent::Model();
    }

    /**
     * Sets the current row
     *
     * @param int $row
     */
    public function setRow($row)
    {
        if (null !== $this->_room && $row != $this->_room->row)
        {
            $this->_room = null;
            $this->_room_id = null;
        }

        $this->_row = $row;
    }

    /**
     * Sets current columng
     *
     * @param int $column
     */
    public function setColumn($column)
    {
        if (null !== $this->_room && $column != $this->_room->column)
        {
            $this->_room = null;
            $this->_room_id = null;
        }

        $this->_column = $column;
    }

    /**
     * Sets room id
     *
     * @param int $id
     */
    public function setId($id)
    {
        if (null !== $this->_room && $id != $this->_room->id)
        {
            $this->_room = null;
            $this->_row = null;
            $this->_column = null;
        }

        $this->_room_id = $id;
    }

    /**
     * Returns room id
     *
     * @return int
     */
    public function getId()
    {
        return $this->_room_id;
    }

    /**
     * Returns room
     *
     * @return object
     */
    public function &getRoom()
    {
        if (null == $this->_room)
        {
            $this->_loadRoom();
        }

        return $this->_room;
    }

    /**
     * Loads room from database
     *
     */
    private function _loadRoom()
    {
        $room = new stdClass();

        if (true === isset($this->_room_id))
        {
            $room = &$this->_loadRoomById();
        }
        else if (true === isset($this->_row)  && true === isset($this->_column))
        {
            $room = &$this->_loadRoomByRowColumn();
        }

        $this->_room = $room;

        if (true === isset($room->id))
        {
            $this->_processRoom($room);

            if (false === empty($room))
            {
                $this->_room_id = (int)$room->id;
                $this->_row = (int)$room->row;
                $this->_column = (int)$room->column;
            }
        }
    }

    private function _processRoom(&$room)
    {
        if (true === is_object($room))
        {
            /**
             * Override the default image of the tile if one is specified by the room
             */
            $room->image = (true === empty($room->image) && false === empty($room->default_image)) ? $room->default_image : $room->image;

            /**
             * Override the exits of the tile is specified by the room
             */
            $room->exit_north = (1 == $room->exit_north && 0 == $room->override_exit_north);
            $room->exit_south = (1 == $room->exit_south && 0 == $room->override_exit_south);
            $room->exit_east = (1 == $room->exit_east && 0 == $room->override_exit_east);
            $room->exit_west = (1 == $room->exit_west && 0 == $room->override_exit_west);
        }
    }

    /**
     * Loads room from database by id
     *
     * @return object
     */
    private function &_loadRoomById()
    {
        $query = $this->_getSQL();

        $query .= ' WHERE r.id = ?'
        . ' LIMIT 0,1';

        $rs = $this->db->query($query, array($this->_room_id));

        $room = $rs->row();
        return $room;
    }

    /**
     * Loads froom from database by row and column
     *
     * @return object
     */
    private function &_loadRoomByRowColumn()
    {
        $query = $this->_getSQL();

        $query .= ' WHERE r.row = ? AND r.column = ? AND level_id = ?'
        . ' LIMIT 0,1';

        $rs = $this->db->query($query, array($this->_row, $this->_column, $this->gamesession->getLevel()));
        $room = $rs->row();
        return $room;
    }

    /**
     * Returns the initial room for a level
     *
     * @param int $level_id
     * @return object
     */
    public function &getInitialRoom($level_id)
    {
        $query = $this->_getSQL();
        $query .= ' WHERE r.level_id = ? AND r.start_point = 1'
        . ' LIMIT 0,1';

        $rs = $this->db->query($query, array($level_id));
        $room = $rs->row();

        $this->_processRoom($room);
         
        $this->_room = $room;

        $this->_room_id = $this->_room->id;
        $this->_row = $this->_room->row;
        $this->_column = $this->_room->column;

        return $this->_room;
    }

    /**
     * Basic selection SQL
     *
     * @return string
     */
    private function _getSQL()
    {
        $query = 'SELECT r.*, t.map_image, t.exit_north, t.exit_south, t.exit_west, t.exit_east, t.default_image, t.name AS tile_name, l.title AS level_title '
        . ' FROM ' . $this->db->protect_identifiers('rooms') . ' AS r'
        . ' INNER JOIN ' . $this->db->protect_identifiers('tiles') . ' AS t ON t.id = r.tile_id'
        . ' INNER JOIN ' . $this->db->protect_identifiers('levels') . ' AS l ON l.id = r.level_id';

        return $query;
    }

    /**
     * Returns question
     *
     * @return Question_delegate
     */
    public function &getQuestion()
    {
        if (null === $this->_question)
        {
            $this->_loadQuestion();
        }

        return $this->_question;
    }

    /**
     * Loads the question from the database
     *
     */
    private function _loadQuestion()
    {
        $query = 'SELECT q.* FROM ' . $this->db->protect_identifiers('questions') . ' AS q'
        . ' INNER JOIN ' . $this->db->protect_identifiers('rooms') . ' AS r ON q.id = r.question_id'
        . ' WHERE r.id = ?';

        $rs = $this->db->query($query, array($this->_room_id));
        $this->_question = $rs->row();

        if (false === empty($this->_question->target_image))
        {
            $this->_question->target_image = site_url($this->_question->target_image);
        }
    }

    /**
     * Returns responses
     *
     * @return array
     */
    public function &getResponses()
    {
        if (null === $this->_responses)
        {
            $this->_loadResponses();
        }

        return $this->_responses;
    }

    /**
     * Loads responses from the database
     *
     */
    private function _loadResponses()
    {
        $question = &$this->getQuestion();

        if (false === empty($question))
        {
            $query = 'SELECT * FROM ' . $this->db->protect_identifiers('responses')
            . ' WHERE question_id = ?';

            $rs = $this->db->query($query, array($question->id));
            $this->_responses = $rs->result();
        }
    }

    /**
     * Returns the room a user is redirected to after answering a question
     *
     * @return object
     */
    public function &getRedirectRoom()
    {
        if (null === $this->_redirect_room)
        {
            $this->_loadRedirectRoom();
        }

        return $this->_redirect_room;
    }

    /**
     * Loads the room a user is redirected to after answering a question from the database
     *
     */
    private function _loadRedirectRoom()
    {
        /**
         * First load the room
         */
        $current_room = &$this->getRoom();

        /**
         * Get possible locations for exit room
         */
        $possibilities = array();
        $possibilities_pattern = '(r.' . $this->db->protect_identifiers('row') . ' = %d AND r.' . $this->db->protect_identifiers('column') . ' = %d)';

        if (1 == $current_room->exit_south)
        {
            $new_row = (int)$this->_row + 1;
            $new_column = (int)$this->_column;
            $possibilities[] = sprintf($possibilities_pattern, $new_row, $new_column);
        }

        if (1 == $current_room->exit_north)
        {
            $new_row = (int)$this->_row - 1;
            $new_column = (int)$this->_column;
            $possibilities[] = sprintf($possibilities_pattern, $new_row, $new_column);
        }

        if (1 == $current_room->exit_east)
        {
            $new_row = (int)$this->_row;
            $new_column = (int)$this->_column + 1;
            $possibilities[] = sprintf($possibilities_pattern, $new_row, $new_column);
        }

        if (1 == $current_room->exit_west)
        {
            $new_row = (int)$this->_row;
            $new_column = (int)$this->_column - 1;
            $possibilities[] = sprintf($possibilities_pattern, $new_row, $new_column);
        }

        $query = $this->_getSQL();
        $query .= ' WHERE (' . implode(' OR ', $possibilities) . ') AND r.id <> ' . $this->gamesession->getPreviousRoom()
        . ' AND r.level_id = ' . $this->gamesession->getLevel()
        . ' LIMIT 0,1';

        $rs = $this->db->query($query);

        $room = $rs->row();

        $this->_processRoom($room);

        $this->_redirect_room = $room;
    }
}
?>
