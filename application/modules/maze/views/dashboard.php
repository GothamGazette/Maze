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
?>

<table id="dashboard">
	<tr>
		<td id="picture">
			<div id="question"><div id="question_content"></div></div>
			<a href="<?php echo site_url('maze/forward'); ?>" id="navigation_forward" class="navigation" onclick="navigate(this); return false;">&nbsp;</a>
			<a href="<?php echo site_url('maze/back'); ?>" id="navigation_back" class="navigation" onclick="navigate(this); return false;">&nbsp;</a>
			<a href="<?php echo site_url('maze/right'); ?>" id="navigation_right" class="navigation" onclick="navigate(this); return false;">&nbsp;</a>
			<a href="<?php echo site_url('maze/left'); ?>" id="navigation_left" class="navigation" onclick="navigate(this); return false;">&nbsp;</a>
		</td>
	</tr>
	<tr>
		<td id="control_panel">
    		<div id="score"><span><?php echo $this->gamesession->points; ?></span></div>
    		<div id="maze_view">
    			<table id="maze_overhead">
<?php
$room_grid = array();

foreach ($rooms as $room)
{
	$room_grid[$room->column . '_' . $room->row] = $room;
}

for ($i = 0; $i < $this->config->item('maze_height'); $i++)
{
?>
					<tr>
<?php
    for ($j = 0; $j < $this->config->item('maze_width'); $j++)
    {
        $classes = array();
        
        if (true === isset($room_grid[$j . '_' . $i]))
        {
            $current_room = $room_grid[$j . '_' . $i];
            
            $classes[] = strtolower(preg_replace('/\W/', '_', $current_room->category));
            if (1 == $current_room->start_point)
            {
                 $classes[] = 'start_point';   
            }
            
            if (1 == $current_room->end_point)
            {
                 $classes[] = 'end_point';   
            }
            
            if ($current_room->id == $initial_room->id)
            {
                $classes[] = 'current_room';   
            }
        }          
?>	
						<td class="<?php echo implode(' ', $classes); ?>" id="room_<?php echo $j; ?>_<?php echo $i; ?>"><?php echo (false === empty($room_grid[$j . '_' . $i])) ? img($room_grid[$j . '_' . $i]->map_image) : ''; ?></td>
<?php
    }
?>				
					</tr>
<?php
}
?>    			
    			</table>
    		</div>
    		<div id="progress_meter"><?php echo img('images/dashboard/Level' . $level->ordering . '_0.gif', array('id' => 'progress_meter_img')); ?></div>
    		<div id="calendar"><span><?php echo $this->config->item('max_budget_days'); ?></span></div>
		</td>
	</tr>
</table>

<script>
var room = eval(<?php echo json_encode($room_vo); ?>);
processRoom(room);

<?php
$precache = array();
foreach ($responses as $response)
{
    $precache[] = '"' . site_url($response->image) . '"';
    $precache[] = '"' . site_url($response->image_hover) . '"';
}
?>

var responses = [<?php echo implode(',', $precache); ?>];
precacheResponses(responses);

$('#calendar').ifixpng();
$('a.navigation').ifixpng();
$('#question').ifixpng();
$('#tooltip').hide();
$('.navigation').css('opacity', '.65');
</script>
