<?php
class Complete_level extends Model
{
    const WIDGET_PATH_PREFIX = 'maze/badges/';
    
    private $_id;
    private $_level;
    private $_widget;
    private $_complete_text;

    /**
     * Constructor
     *
     * @return Complete_level
     */
    public function Complete_level()
    {
        parent::Model();
        $this->load->table('level');
    }

    /**
     * Sets level id
     *
     * @param int $id
     */
    public function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * Current level
     *
     * @return Level_delegate
     */
    public function &getLevel()
    {
        if (null === $this->_level)
        {
            $this->_level = new Level_delegate($this->_id);
            $this->_level->load();
        }

        return $this->_level;
    }

    /**
     * Completion text
     *
     * @param int $time_remaining
     * @param int $points
     * @param int $bonus_points
     * @return string
     */
    public function getCompleteText($time_remaining, $points, $bonus_points)
    {
        if (null === $this->_complete_text)
        {
            $level = &$this->getLevel();

            $this->_complete_text = sprintf($level->complete_text, $time_remaining, $points, $bonus_points);
        }

        return $this->_complete_text;
    }
    
    /**
     * Widget url
     *
     * @return string
     */
    public function getWidget()
    {
        if (null === $this->_widget)
        {
            $this->_createWidget();
        }
        
        return $this->_widget;
    }
    
    /**
     * Create widget
     *
     */
    private function _createWidget()
    {
        $session = new Gamesession_delegate($this->gamesession->getId());
        $session->load();
        
        //TODO: Actual image generation
        
        $this->_widget = img(self::WIDGET_PATH_PREFIX . $session->hash);
    }
}
?>