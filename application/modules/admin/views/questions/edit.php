<?php
/**
 * @package		Gotham Gazette Budget Game
 * @subpackage	Admin
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

<script>
function clear_response_editor() {
	$('#response_editor :text').val('');
	$('#response_editor :hidden').val('');
	$('#response_editor textarea').val('');
	
	$('#response_editor :radio').attr('checked', false);
}

function show_response_editor() {
	clear_response_editor();
	
	$('#response_editor').modal({
		persist: true
	});
}

function delete_response(button) {
	var row = $(button).parents('tr').get(0);
	$(row).remove();
}

function edit_response(button) {
	clear_response_editor();
	
	var row = $(button).parents('tr').get(0);
	
	$(row).find(':input').each(function() {
		var name = this.name.split('[');
		name = (2 < name.length) ? name[2].substring(0, (name[2].length - 1)) : name;

		if (1 < name.length) {
			var val = $(this).val();
			$("#response_editor :input[@type!='radio'][@name*='" + name + "']").val(val);
		}
		
		$("#response_editor :radio[@name*='" + name + "'][@value='" + val + "']").attr('checked', true);
	});
	
	$('#response_editor').modal({
		persist: true
	});
}

function copy_form_elements() {
	var id = $('#response_editor_id').val();
	var row = null;
	
	if ('' == id) {
		row = $('#response_list tr:last');
	} else {
		row = $("#response_list tr:has(input[@name$='id]'][value=" + id + "])");
	}
	
	$('#response_editor :input').each(function() {
		if (1 < this.name.length) {
			$(row).find(":input[@name$='" + this.name + "]'][@type!='radio']").val($(this).val());
		}
	});
	
	$('#response_editor :checked').each(function() {
		var val = $(this).val();
		$(row).find(":input[@name$='" + this.name + "]'][@value='" + val + "']").attr('checked', true);
		$(row).find(":input[@name$='" + this.name + "]'][@type!='radio']").val(val);
	});
}

function save_response() {
	var id = $('#response_editor_id').val();
	
	if ('' == id) {
		var index = $('#response_list tr').length;
		
		var newrow = $.create('tr', null, [
			$.create('td', null, [
				$.create('input', {
					'type': 'hidden',
					'name': 'response[' + index + '][id]'
				}),$.create('input', {
					'type': 'hidden',
					'name': 'response[' + index + '][response]'
				}),$.create('input', {
					'type': 'hidden',
					'name': 'response[' + index + '][more_information]'
				}),$.create('input', {
					'type': 'hidden',
					'name': 'response[' + index + '][image]'
				}),$.create('input', {
					'type': 'hidden',
					'name': 'response[' + index + '][image_hover]'
				}),$.create('input', {
					'type': 'hidden',
					'name': 'response[' + index + '][image_pos_x]'
				}),$.create('input', {
					'type': 'hidden',
					'name': 'response[' + index + '][image_pos_y]'
				}),$.create('input', {
					'type': 'hidden',
					'name': 'response[' + index + '][end_game_immediately]'
				}),$.create('input', {
					'type': 'text',
					'name': 'response[' + index + '][title]',
					'style': 'width: 98%;'
				})
			]),
			$.create('td', null, [
				$.create('input', {
					'type': 'radio',
					'name': 'response[' + index + '][move_ahead]',
					'value': '1'
				}),$.create('span', null, 'Yes'),
				$.create('input', {
					'type': 'radio',
					'name': 'response[' + index + '][move_ahead]',
					'value': '0'
				}),$.create('span', null, 'No')
			]),
			$.create('td', null, [
				$.create('input', {
					'type': 'text',
					'name': 'response[' + index + '][points_awarded]',
					'size': 5
				})
			]),
			$.create('td', null, [
				$.create('input', {
					'type': 'text',
					'name': 'response[' + index + '][schedule_change]',
					'size': 5
				})
			]),
			$.create('td', null, [
				$.create('input', {
					'type': 'text',
					'name': 'response[' + index + '][ordering]',
					'size': 5
				})
			]),
			$.create('td', null, [
    			$.create('button', {
    				'type': 'button',
    				'onclick': 'edit_response(this)'
    			}, 'Edit'),
    			$.create('button', {
    				'type': 'button',
    				'onclick': 'delete_response(this)'
    			}, 'Delete')
    		])
		]);
		
		$('#response_list').append(newrow);
	}
	
	$.modal.close();
	copy_form_elements();
}
</script>

<form id="adminform" class="cmxform" action="<?php echo site_url($this->uri->uri_string()); ?>" method="post">
	<fieldset>
        <ol class="fields">
        	<li>
            	<label for="title">Title <em>*</em></label>
                <input type="text" name="title" value="<?php echo $question->title; ?>" />
            </li>
            <!--li>
            	<label for="description">More Information <em>*</em></label>
                <textarea rows="8" cols="50"><?php echo $question->description; ?></textarea>
            </li-->
            <li>
            	<label for="target_image">Response Action <em>*</em></label>
                <?php echo $actions; ?>
            </li>
            <li>
            	<label for="target_image">Target Image</label>
                <input type="text" name="target_image" value="<?php echo $question->target_image; ?>" size="64" />
            </li>
            <li>
            	<label for="target_pos_x">Target Image Position X</label>
                <input type="text" name="target_pos_x" value="<?php echo $question->target_pos_x; ?>" size="5" />
            </li>
            <li>
            	<label for="target_pos_y">Target Image Position Y</label>
                <input type="text" name="target_pos_y" value="<?php echo $question->target_pos_y; ?>" size="5" />
            </li>
            <li><label>Responses</label>
            <table class="adminlist">
            	<thead>
            		<tr>
            			<th>Title</th>
            			<th>Move Ahead</th>
            			<th>Points</th>
            			<th>Schedule</th>
            			<th>Order</th>
            			<th>Actions</th>
            		</tr>
            	</thead>
            	<tbody id="response_list">
<?php
$i = 0;

foreach ($responses as $response)
{
?>
					<tr>
						<td>
							<input type="hidden" name="response[<?php echo $i; ?>][id]" value="<?php echo $response->id; ?>" />
							<input type="hidden" name="response[<?php echo $i; ?>][response]" value="<?php echo $response->response; ?>" />
							<input type="hidden" name="response[<?php echo $i; ?>][more_information]" value="<?php echo $response->more_information; ?>" />
							<input type="hidden" name="response[<?php echo $i; ?>][image]" value="<?php echo $response->image; ?>" />
							<input type="hidden" name="response[<?php echo $i; ?>][image_hover]" value="<?php echo $response->image_hover; ?>" />
							<input type="hidden" name="response[<?php echo $i; ?>][image_pos_x]" value="<?php echo $response->image_pos_x; ?>" />
							<input type="hidden" name="response[<?php echo $i; ?>][image_pos_y]" value="<?php echo $response->image_pos_y; ?>" />
							<input type="hidden" name="response[<?php echo $i; ?>][end_game_immediately]" value="<?php echo $response->end_game_immediately; ?>" />
							
							<input type="text" name="response[<?php echo $i; ?>][title]" value="<?php echo $response->title; ?>" style="width: 98%;" />
						</td>
						<td>
							<input type="radio" name="response[<?php echo $i; ?>][move_ahead]" value="1" <?php echo (1 == $response->move_ahead) ? 'checked="checked"' : ''; ?> /> Yes
                			<input type="radio" name="response[<?php echo $i; ?>][move_ahead]" value="0" <?php echo (0 == $response->move_ahead) ? 'checked="checked"' : ''; ?> /> No
						</td>
						<td><input type="text" name="response[<?php echo $i; ?>][points_awarded]" value="<?php echo $response->points_awarded; ?>" size="5" /></td>
						<td><input type="text" name="response[<?php echo $i; ?>][schedule_change]" value="<?php echo $response->schedule_change; ?>" size="5" /></td>
						<td><input type="text" name="response[<?php echo $i; ?>][ordering]" value="<?php echo $response->ordering; ?>" size="5" /></td>
						<td>
							<button type="button" onclick="edit_response(this);">Edit</button>
							<button type="button" onclick="delete_response(this);">Delete</button>
						</td>
					</tr>
<?php
    $i++;
}
?>
            	</tbody>
            	<tfoot>
            		<tr>
            			<td colspan="6"><button type="button" onclick="show_response_editor();">Add Response</button>
            		</tr>
            	</tfoot>
            </table>
    	</ol>
    </fieldset>

	<input type="hidden" name="id" value="<?php echo $question->id; ?>" />
	<input type="hidden" name="task" value="" />
</form>

<div style="display: none;" id="response_editor">
	<form class="cmxform">
		<input type="hidden" name="id" id="response_editor_id" value="" />
    	<fieldset>
    		<ol class="fields">
    			<li>
    				<label for="title">Title <em>*</em></label>
    				<input type="text" name="title" id="title" />
    			</li>
    			<li>
    				<label for="response">Response <em>*</em></label>
    				<textarea rows="5" cols="50" name="response" id="response"></textarea>
    			</li>
    			<li>
    				<label for="image">Image <em>*</em></label>
    				<input type="text" name="image" id="image" />
    			</li>
    			<li>
    				<label for="image_hover">Image Hover <em>*</em></label>
    				<input type="text" name="image_hover" id="image_hover" />
    			</li>
    			<li>
    				<label for="image_pos_x">Image Position X <em>*</em></label>
    				<input type="text" name="image_pos_x" id="image_pos_x" />
    			</li>
    			<li>
    				<label for="image_pos_y">Image Position Y <em>*</em></label>
    				<input type="text" name="image_pos_y" id="image_pos_y" />
    			</li>
    			<li>
    				<label for="move_ahead">Move Ahead <em>*</em></label>
    				<input type="radio" name="move_ahead" value="1" /> Yes
                	<input type="radio" name="move_ahead" value="0" /> No
    			</li>
    			<li>
    				<label for="points_awarded">Points Awarded <em>*</em></label>
    				<input type="text" name="points_awarded" id="points_awarded" />
    			</li>
    			<li>
    				<label for="schedule_change">Schedule Change <em>*</em></label>
    				<input type="text" name="schedule_change" id="schedule_change" />
    			</li>
    			<li>
    				<label for="end_game_immediately">End Game Immediately <em>*</em></label>
    				<input type="radio" name="end_game_immediately" value="1" /> Yes
                	<input type="radio" name="end_game_immediately" value="0" /> No
    			</li>
                <li>
                	<button type="button" onclick="save_response()">Save Response</button>
                </li>
    		</ol>
    	</fieldset>
	</form>
</div>