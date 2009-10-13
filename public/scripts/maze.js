/**
 * @package Gotham Gazette Budget Game
 * @subpackage Scripts
 * @copyright Copyright (C) 2008 Gotham Gazette. All rights reserved.
 * @license GNU/GPL, see LICENSE.txt This program is free software: you can
 *          redistribute it and/or modify it under the terms of the GNU General
 *          Public License as published by the Free Software Foundation, either
 *          version 3 of the License, or any later version.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 */

function precacheResponses(images) {
	var image_cache = [];

	for (var i = 0; i < images.length; i++) {
		image_cache[i] = new Image();
		image_cache[i].src = images[i];
	}
}

function loadLevel(url) {
	$.getJSON(url, levelLoaded);
}

function levelLoaded(data) {
	if ($.browser.msie && $.browser.version < 7) {
		describeLevel(data);
	} else {
		$().one('ajaxStop', function() {
			describeLevel(data);
		});
	}
}

function showMessage(title, message, actiontext, actionfunction) {
	$('#maze_message').css({
		display : 'block',
		opacity : '.85'
	});

	if (title && 0 < title.length) {
		$('#message_title').html(title).show();
	}

	if (message && 0 < message.length) {
		$('#message_content').html(message).show();
	}

	if (actiontext && 0 < actiontext.length) {
		$('#message_action').show().find('a').html(actiontext).show();
	}

	if (actionfunction) {
		$('#message_action a').one('click', actionfunction);
	}
	
	setTimeout(autoCloseMessage, 27000);
}

function autoCloseMessage() {
	if ('none' != $('$maze_message').css('display')) {
		$('#message_action a').click();
	}
}

function hideMessage() {
	$('#maze_message p').css('display', 'none');
	$('#maze_message').css('display', 'none');
}

function loadMaze(id) {
	hideMessage();

	$('#maze_content').load(antiCacheUrl('maze/enter/' + id));
}

function describeLevel(level) {
	description = level.introduction;

	showMessage(null, level.introduction, '[Enter the Maze]', function() {
		loadMaze(level.id);
		return false;
	});
}

function antiCacheUrl(url) {
	var append = new Date().getTime() + '_' + (Math.random() * 10000);
	return url + '?time=' + append;
}

function navigate(anchor) {
	if ('hidden' != $(anchor).css('visibility')) {
		$('#picture .response').remove();
		$('#question').css('display', 'none');

		$.getJSON(antiCacheUrl(anchor.href), handleNavigation);
	}

	anchor.blur();
}

function handleQuestion(room) {
	var question = room.question;

	if (false == question.completed) {
		for (direction in room.navigation) {
			$('#navigation_' + direction).css('visibility', 'hidden');
		}

		if (null != question.target_image && 0 < question.target_image.length) {
			$.create('img', {
				'src' : question.target_image,
				'class' : 'response',
				'style' : 'position: absolute; top: ' + question.target_pos_y
						+ 'px; left: ' + question.target_pos_x + 'px'
			}).appendTo('#picture');
		}

		$('#question').css({
			'display' : 'block',
			'opacity' : '.85'
		});

		$('#question_content').html(question.title).css({
			'opacity' : '1'
		}).ifixpng();
	}

	if (false == question.completed) {
		for (var i = 0; i < question.responses.length; i++) {
			var response = question.responses[i];
			var onclick = (false == question.completed)
					? question.action_function + '(this.href);'
					: '';

			var style = 'top: ' + response.image_pos_y + 'px; left: '
					+ response.image_pos_x + 'px;';

			if (response.height && response.width) {
				style += ' height: ' + response.height + 'px; width: '
						+ response.width + 'px;';
			}

			var parameters = {
				'class' : 'response',
				'style' : style,
				'title' : response.title,
				'href' : 'maze/answer/' + response.id,
				'onmouseover' : "$(this).find('img').attr('src', '"
						+ response.image_hover + "');",
				'onmouseout' : "$(this).find('img').attr('src', '"
						+ response.image + "');"
			};

			var imagestyle = (response.height && response.width)
					? 'height: ' + response.height + 'px; width: '
							+ response.width + 'px;'
					: '';

			$.create('a', parameters, [$.create('img', {
				'src' : response.image,
				'style' : imagestyle
			})]).click(function() {
				eval(onclick);
				return false;
			}).appendTo('#picture');
		}

		$('#picture a.response').tooltip({
			track : true,
			delay : 0,
			showURL : false
		});

		$('#picture img').ifixpng();
	}
}

function processRoom(room) {
	$('#picture').css('backgroundImage', 'url("' + room.image + '")');
	$('#maze_overhead td.current_room').toggleClass('current_room');
	$('#room_' + room.column + '_' + room.row).toggleClass('current_room');

	for (direction in room.navigation) {
		if (true == room.navigation[direction].allowed) {
			$('#navigation_' + direction).css('display', 'block');
			$('#navigation_' + direction).attr('title',
					room.navigation[direction].message);
		} else {
			$('#navigation_' + direction).css('display', 'none');
			$('#navigation_' + direction).attr('title', '');
		}
	}

	$('a.navigation').tooltip({
		track : true,
		delay : 0,
		fixPNG : true,
		showURL : false
	}).unbind('click');

	var question = room.question;

	if (null != question) {
		handleQuestion(room);
	}
}

function handleNavigation(data) {
	if (null != data.redirect && 0 < data.redirect.length) {
		$('#maze_content').load(antiCacheUrl(data.redirect));
	} else if (true == data.success) {
		var room = data.room;
		processRoom(room);
	} else {
		handleError(data.message);
	}

	$('div#debug').html(data.debug);
}

function click_response(url) {
	$.getJSON(antiCacheUrl(url), responseLoaded);
}

function responseLoaded(data) {
	if ($.browser.msie && $.browser.version < 7) {
		handleResponse(data);
	} else {
		$().one('ajaxStop', function() {
			handleResponse(data);
		});
	}
}

function handleResponse(data) {
	if (null != data.redirect && 0 < data.redirect.length) {
		$('#maze_content').load(antiCacheUrl(data.redirect));
	} else if (true == data.success) {
		var title = null; /*
							 * = (1 == data.move_ahead) ? '<span
							 * class="drop-cap">T</span>hat\'s Right!' : '<span
							 * class="drop-cap">S</span>orry';
							 */
		var action = (1 == data.move_ahead) ? "Continue Maze" : "Try Again";
		var actionfunc = (1 == data.move_ahead) ? function() {
			questionAnswered(data.new_room);
			return false;
		} : function() {
			questionRetry();
			return false;
		}

		if (1 == data.move_ahead) {
			$('#progress_meter img').attr('src', data.progress_img);
		}

		showMessage(title, data.response, action, actionfunc);

		$('#score span').html(data.points);
		$('#calendar span').html(data.time_remaining);
	} else {
		handleError(data.message);
	}
}

function handleError(message) {
	showMessage(message.title, message.message, message.actiontext, function() {
		eval(message.action + '()');
	});
}

function questionRetry() {
	hideMessage();
}

function questionAnswered(room) {
	hideMessage();
	$('#question').css('display', 'none');
	$('#picture .navigation').css('visibility', 'visible');
	$('#picture a.response').attr('onmouseover', '').attr('onclick', '').attr(
			'title', '').attr('href', '#');

	if (null != room && undefined != room) {
		$('#picture .response').remove()
		processRoom(room);
	}
}

function submit_form(action) {
	$('#adminform input[name="task"]').attr('value', action);
	$('#adminform').submit();
}

function editRow(item) {
	var row = $(item).parent('tr').get(0);
	$(row).find(':checkbox').attr('checked', true);
	submit_form('edit');
}

function restartGame() {
	window.location.href = 'maze';
}

function showFinish() {
	hideMessage();
	$('#maze_content').load(antiCacheUrl('maze/finish'));
}
