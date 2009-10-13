<?php
if (false === function_exists('getRequestState'))
{
	function getRequestState($session_name, $request_name, $default = null)
	{
		$ci = &get_instance();
		
		$old_value = $ci->session->userdata($session_name);
		$current_value = (false !== $old_value) ? $old_value : $default;
		$new_value = (true === isset($_REQUEST[$request_name])) ? $_REQUEST[$request_name] : $current_value;
		$ci->session->set_userdata($session_name, $new_value);
		
		return $new_value;
	}
}
?>
