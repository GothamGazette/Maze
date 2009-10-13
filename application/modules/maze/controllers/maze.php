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

class Maze extends Controller
{
    const PROGRESS_METER_PREFIX = 'images/dashboard/Level';

    /**
     * Constructor
     *
     * @return Maze
     */
    public function Maze()
    {
        parent::Controller();

        $this->load->library('gamesession');
        $this->load->helper('valueobjects');

        $this->load->table('level');
        $this->load->table('room');
    }

    /**
     * Show level selection
     *
     */
    public function index()
    {
        $this->load->model('level_selection');
        $data = array();

        $data['levels'] = &$this->level_selection->getLevels();

        $this->load->view('header');
        $this->load->view('maze', $data);
        $this->load->view('footer');
    }
    
    public function test($hash = '')
    {
        $session = new Gamesession_delegate();

        if (true === empty($hash))
        {
            
            $session->load($this->gamesession->getId());
        }
        else
        {
            $session->load($hash, 'hash');
        }
        
        $this->load->helper('badge');
        echo Badge_helper::getImageMagickCommand($session);
    }

    /**
     * Describe a level
     *
     * @param int $id	level id
     */
    public function describe($id)
    {
        $level = new Level_delegate($id);
        $level->load();
        echo json_encode($level);
    }
    
    /**
     * Enter a level
     *
     * @param int $id	level id
     */
    public function enter($id)
    {
        $this->load->model('current_room');
        $this->load->model('level_detail');

        $this->level_detail->setId($id);

        $level = &$this->level_detail->getLevel();
        $rooms = &$this->level_detail->getRooms();

        $initial_room = &$this->current_room->getInitialRoom($level->id);

        $this->gamesession->reset();
        $this->gamesession->setLevel($level->id);
        $this->gamesession->setRoom($initial_room->id);
        $this->gamesession->setPoints(0);
        $this->gamesession->setTimeRemaining($this->config->item('max_budget_days'));

        if (false === empty($initial_room->force_orientation))
        {
            $this->gamesession->setCurrentOrientation($initial_room->force_orientation);
        }
        else
        {
            $this->gamesession->setCurrentOrientation('north');
        }

        $room_vo = $this->_serializeRoom($initial_room);

        $data = array();
        $data['level'] = $level;
        $data['initial_room'] = $initial_room;
        $data['room_vo'] = $room_vo;
        $data['rooms'] = $rooms;
        $data['responses'] = &$this->level_detail->getResponses();
        
        $this->load->view('dashboard', $data);
    }

    /**
     * Move forward
     *
     */
    public function forward()
    {
        echo $this->navigate('forward');
    }

    /**
     * Move backward
     *
     */
    public function back()
    {
        echo $this->navigate('back');
    }

    /**
     * Turn right
     *
     */
    public function right()
    {
        echo $this->navigate('right');
    }

    /**
     * Turn left
     *
     */
    public function left()
    {
        echo $this->navigate('left');
    }

    /**
     * Change orientation based on direction
     *
     * @param string $direction
     * @param string $current_orientation
     * @return string
     */
    private function _getOrientationFromDirection($direction, $current_orientation = null)
    {
        $orientations = array('north','east','south','west');

        $current_orientation = (false === empty($current_orientation)) ? $current_orientation : $this->gamesession->getCurrentOrientation();
        $orientation = array_search($current_orientation, $orientations);

        switch ($direction)
        {
            case 'back':
                $orientation += 2;
                break;

            case 'right':
                $orientation += 1;
                break;

            case 'left':
                $orientation += 3;
                break;

            default:
                break;
        }

        $orientation = ($orientation >= sizeof($orientations)) ? ($orientation - sizeof($orientations)) : $orientation;

        return $orientations[$orientation];
    }

    /**
     * Is a direction allowed based on a tile
     *
     * @param string $orientation
     * @param string $direction
     * @param Tile_delegate $tile
     * @return boolean
     */
    private function _isDirectionAllowed($orientation, $direction, &$tile)
    {
        $check_orientation = $this->_getOrientationFromDirection($direction, $orientation);
        $navigation_attribute = 'exit_' . $check_orientation;

        return isset($tile->$navigation_attribute) && 1 == $tile->$navigation_attribute;
    }

    /**
     * General navigation function
     *
     * @param string $direction
     * @return string
     */
    private function navigate($direction)
    {
        $result = new NavigationVO();

        $new_orientation = $this->_getOrientationFromDirection($direction);

        try
        {
            $result->success = true;

            $this->load->model('current_room');

            $this->current_room->setId($this->gamesession->getRoom());
            $current_room =  &$this->current_room->getRoom();

            if (true === empty($current_room->id))
            {
                $result->success = false;
                $result->message = $this->_createMessage('Failed to load room');
            }
            else if (0 >= $this->gamesession->getTimeRemaining())
            {
                $result->success = false;
                $result->message = $this->_createMessage($this->config->item('out_of_time_message'), 'Out of Time', 'Exit Maze', 'restartGame');
            }
            else
            {
                $navigation_attribute = 'exit_' . $direction;

                if (false === $this->_isDirectionAllowed($this->gamesession->getCurrentOrientation(), $direction, &$current_room))
                {
                    $result->success = false;
                    $result->message = $this->_createMessage('This direction is not allowed');
                }
                else
                {
                    $row = $current_room->row;
                    $column = $current_room->column;

                    switch ($new_orientation)
                    {
                        case 'north':
                            $row--;
                            break;

                        case 'south':
                            $row++;
                            break;
                             
                        case 'east':
                            $column++;
                            break;

                        case 'west':
                            $column--;
                            break;

                        default:
                            $result->success = false;
                            $result->message = $this->_createMessage('This direction is not allowed');
                            break;
                    }

                    if (0 > $row || 0 > $column)
                    {
                        $result->success = false;
                        $result->message = $this->_createMessage('This direction would take you off the map');
                    }

                    if (true === $result->success)
                    {
                        $this->current_room->setRow($row);
                        $this->current_room->setColumn($column);

                        $new_room = &$this->current_room->getRoom();

                        if (true === empty($new_room))
                        {
                            $result->success = false;
                            $result->message = $this->_createMessage('Unable to locate room');
                        }
                        else if (1 == $new_room->end_point && 0 == $new_room->question_id)
                        {
                            $result->success = true;
                            $result->redirect = site_url('maze/finish');
                        }
                        else
                        {
                            /**
                             * If the new room forces an orientation use that.
                             * If we're going backwards keep the current orientation.
                             * Otherwise set it to the new orientation.
                             */
                            if (false === empty($new_room->force_orientation))
                            {
                                $this->gamesession->setCurrentOrientation($new_room->force_orientation);
                            }
                            else if ('back' != $direction)
                            {
                                $this->gamesession->setCurrentOrientation($new_orientation);
                            }
                             
                            $room_vo = $this->_serializeRoom($new_room);

                            $result->room = $room_vo;

                            $this->gamesession->setRoom($new_room->id);
                        }

                        $result->debug = $this->_getDebug($new_room);
                    }
                }
            }
        }
        catch (Exception $e)
        {
            $result->success = false;
            $result->message = $this->_createMessage($e->getMessage());
        }

        return json_encode($result);
    }

    /**
     * Create a message
     *
     * @param string $text
     * @param string $title
     * @param string $actiontext
     * @param string $action
     * @return MessageVO
     */
    private function _createMessage($text, $title = 'Error', $actiontext = 'Continue', $action = 'hideMessage')
    {
        $message = new MessageVO();
        $message->title = $title;
        $message->message = $text;
        $message->actiontext = $actiontext;
        $message->action = $action;

        return $message;
    }

    /**
     * Answer a question
     *
     * @param int $id	response id
     */
    public function answer($id) {
        $result = new AnswerVO();
        $result->success = true;

        $this->load->model('current_room');
        $this->load->table('response');
        $this->load->table('response_log');

        try
        {
            $response = new Response_delegate($id);
            $response->load();

            $this->current_room->setId($this->gamesession->getRoom());
            $current_room = &$this->current_room->getRoom();

            /**
             * Log the response for later analysis
             */
            $response_log = new Response_log_delegate();
            $response_log->gamesession_id = $this->gamesession->getId();
            $response_log->response_id = $id;
            $response_log->store();

            if ($id != $response->id)
            {
                $result->success = false;
                $result->message = $this->_createMessage('Unable to load response');
            }
            else if (1 == $response->end_game_immediately)
            {
                $result->success = false;
                $result->message = $this->_createMessage($response->response, '', 'Exit Maze', 'restartGame');
            }
            else
            {
                $this->gamesession->setPoints($this->gamesession->getPoints() + $response->points_awarded);
                $this->gamesession->setTimeRemaining($this->gamesession->getTimeRemaining() - $response->schedule_change);

                ObjectHelper::shallowCopy($this->gamesession, &$result);
                ObjectHelper::shallowCopy($response, &$result);

                if (1 == $response->move_ahead)
                {
                    $this->gamesession->addCompletedQuestion($response->question_id);

                    $this->current_room->setId($this->gamesession->getRoom());
                    $new_room = &$this->current_room->getRedirectRoom();

                    if (false === empty($new_room))
                    {
                        if (false === empty($new_room->force_orientation))
                        {
                            $this->gamesession->setCurrentOrientation($new_room->force_orientation);
                        }

                        $result->new_room = $this->_serializeRoom($this->current_room->getRedirectRoom());
                        $this->gamesession->setRoom($new_room->id);
                    }

                    if (1 == $current_room->end_point)
                    {
                        $result->success = false;
                        $result->message = $this->_createMessage($response->response, '', 'See Results', 'showFinish');
                    }
                }

                $result->progress_img = site_url(self::PROGRESS_METER_PREFIX . $this->gamesession->getLevel() . '_' . sizeof($this->gamesession->getCompletedQuestions()) . '.gif');
            }
        }
        catch (Exception $e)
        {
            $result->success = false;
            $result->message = $result->message = $this->_createMessage($e->getMessage());
        }

        if (0 >= $this->gamesession->getTimeRemaining())
        {
            $result->success = false;
            $result->message = $this->_createMessage($response->response, 'Out of Time', 'See Results', 'showFinish');
        }

        echo json_encode($result);
    }

    /**
     * Serialize a room to JSON
     *
     * @param Room_delegate $room
     * @return RoomVO
     */
    private function _serializeRoom(&$room)
    {
        $this->load->helper('badge');
        $public_dir = Badge_helper::getPublicDirectoryPath();
        
        $room_vo = new RoomVO();

        ObjectHelper::shallowCopy($room, $room_vo);

        $question = &$this->current_room->getQuestion();

        if (false === empty($question))
        {
            $question_vo = new QuestionVO();
            ObjectHelper::shallowCopy($question, $question_vo);
             
            $question_vo->completed = in_array($question->id, $this->gamesession->getCompletedQuestions());
            $responses = &$this->current_room->getResponses();
            foreach ($responses as $response)
            {
                $response_vo = new ResponseVO();
                ObjectHelper::shallowCopy($response, $response_vo);
                
                $filename = $public_dir . DIRECTORY_SEPARATOR . $response_vo->image;
                
                /**
                 * Get image sizes to avoid issues in IE6
                 */
                if (true === file_exists($filename))
                {
                    $sizes = getimagesize($filename);
                    $response_vo->width = $sizes[0];
                    $response_vo->height = $sizes[1];
                }
                
                $response_vo->image = site_url($response_vo->image);
                $response_vo->image_hover = site_url($response_vo->image_hover);
                $question_vo->responses[] = $response_vo;
            }

            $room_vo->question = $question_vo;
        }

        $room_vo->image = site_url($room_vo->image);
        $room_vo->map_image = site_url($room_vo->map_image);

        foreach ($room_vo->navigation as $direction => $value)
        {
            $navigation_allowed = new AllowedNavigationVO();
            $navigation_allowed->allowed = $this->_isDirectionAllowed($this->gamesession->getCurrentOrientation(), $direction, &$room);

            if (true == $navigation_allowed->allowed)
            {
                switch ($direction)
                {
                    case 'left':
                    case 'right':
                        $navigation_allowed->message = 'Turn ' . $this->_getOrientationFromDirection($direction, $this->gamesession->getCurrentOrientation());
                        break;

                    case 'forward':
                        $navigation_allowed->message = 'Proceed ' . $this->_getOrientationFromDirection($direction, $this->gamesession->getCurrentOrientation());
                        break;

                    case 'back':
                        $navigation_allowed->message = 'Backtrack';
                        break;
                }
            }

            $room_vo->navigation[$direction] = $navigation_allowed; //$this->_isDirectionAllowed($this->gamesession->getCurrentOrientation(), $direction, &$room);
        }

        return $room_vo;
    }

    /**
     * Leave a room
     *
     */
    public function leaveRoom()
    {
        $result = new NavigationVO();
        $result->success = true;

        try
        {
            $this->load->model('current_room');
            $this->current_room->setId($this->gamesession->getRoom());
            $result->room = &$this->current_room->getRedirectRoom();
        }
        catch (Exception $e)
        {
            $result->success = false;
            $result->message = $result->message = $this->_createMessage($e->getMessage());
        }

        echo json_encode($result);
    }

    /**
     * Complete a level
     *
     */
    public function finish()
    {
        $gamesession = new Gamesession_delegate($this->gamesession->getId());
        $gamesession->load();

        $this->load->model('complete_level');
        $this->complete_level->setId($this->gamesession->getLevel());

        $data = array();
        $data['widget'] = $this->complete_level->getWidget();
        $total_points = (1 == $gamesession->completed) ? (int)$this->gamesession->getTimeRemaining() * $this->gamesession->getPoints() : 0;

        $level = &$this->complete_level->getLevel();

        $text = (0 < $total_points) ? $level->complete_text : $level->failed_text;
        
        $data['text'] = sprintf($text, $this->gamesession->getTimeRemaining(), $this->gamesession->getPoints(), $total_points);
        $data['title'] = (0 < $total_points) ? 'Congratulations' : 'You Lose';
        
        $this->load->helper('badge');
        Badge_helper::createBadge($gamesession);

        $this->load->view('finish', $data);
    }

    /**
     * Get the badge
     *
     * @param string $hash
     */
    public function badges($hash)
    {
        $session = new Gamesession_delegate();
        $session->load($hash, 'hash');

        if (true === empty($session->id))
        {
            show_404();
        }
        else
        {
            //TODO: Show actual widget
            $this->load->helper('badge');
            Badge_helper::displayBadge($session);
        }
    }

    /**
     * Load debug information
     *
     * @param RoomVO $room
     * @return string
     */
    private function _getDebug(&$room)
    {
        if (true == $this->config->item('debug'))
        {
            try
            {
                $data = array('room' => $room);
                ob_start();
                $this->load->view('debug', $data);
                return ob_get_clean();
            }
            catch (Exception $e)
            {
                var_dump($e);
            }
        }

        return '';
    }
}
?>
