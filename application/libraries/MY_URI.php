<?php
class MY_URI extends CI_URI
{
    function MY_URI()
    {
        parent::CI_URI();
    }

    /**
     * Remove the suffix from the URL if needed
     *
     * @access	private
     * @return	void
     */
    function _remove_url_suffix()
    {
        if  ($this->config->item('url_suffix') != "")
        {
            $this->uri_string = preg_replace("|".preg_quote($this->config->item('url_suffix'))."$|", "", $this->uri_string);
        }
        
        $this->uri_string = preg_replace("|".preg_quote(EXT)."$|", "", $this->uri_string);
    }
}
?>