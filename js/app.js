
$(function() {
	
	// Markdown editor
	$('#message-input').markdown({
		autofocus: true,
		hiddenButtons: [ 'cmdPreview', 'cmdImage' ],
		fullscreen: false,
		iconlibrary: 'fa'
	});
	
	resize_conversation_log();
	resize_user_profile($('#full-profile #user-profile'));
	poll_conversation();
	
	// Refresh status notifications every 5 seconds
	update_notifications();
	var timer = setInterval(update_notifications, 5000);
	
	// Tooltips
	$('[data-toggle="tooltip"]').tooltip({
		'container': 'body',
	});	
	
	$('#offcanvas').click(function () {
		$('.row-offcanvas').toggleClass('active');
		$(window).scrollTop(0);
	});
	
	// Push URL onto history stack
	if ($('#browse-container').length)
	{
		history.replaceState({ myTag: true }, null, window.location.href);
	}
});

// Back button in browser when browsing profiles
$(window).bind('popstate', function(e){
	if ($('#browse-container').length)
	{
		if (!e.originalEvent.state.myTag) return; // not my problem
		reload_container(location.pathname);
	}
});


// Resize sidebar and user profile
$(window).resize(function() {
	resize_conversation_log();
	resize_user_profile($('#full-profile #user-profile'));
});

// Encapsulate all URLs in application base path
function base_url(path)
{
	return site_url.concat('/' + path);
}

// Check for payment
function check_for_payment(user_id)
{
	$.ajax({
		type: 'POST',
		url: base_url('payments/js_check_payment'),
		data: { user_id: user_id },
		success: function(data) {
			if (data.url)
			{
				$(location).attr('href', data.url);
			}
		},
		complete: function(data) {
			next_check = window.setTimeout(function() { check_for_payment(user_id); }, 1000);
		}
	});
}

function resize_conversation_log()
{
	var user_profile = $('#profile-fragment');	
	var conversation_list = $('#conversation-list:not(.all-conversations,.search-conversations)');
	if (conversation_list.length && user_profile.length)
	{
		var container_height = $(window).height() - $('nav').outerHeight();
		var meet_helper = $('#meet-helper');
		
		conversation_list.css('max-height', container_height);
		user_profile.css('height', container_height - meet_helper.outerHeight() - $('#user-tools').outerHeight());
	}
	else if (typeof conversation_log !== 'undefined')
	{
		user_profile = $('#user-profile');
		var container_height = $(window).height() - $('nav').outerHeight() - $('.toggle-profile').outerHeight()  - $('.bottom-tools').outerHeight();
		conversation_log.css('height', container_height);
		conversation_list.css('height', container_height);
		user_profile.css('height', container_height);
		conversation_log.scrollTop(conversation_log[0].scrollHeight);
	}
	else
	{
		var container_height = $(window).height() - $('nav').outerHeight();
		conversation_list.css('max-height', container_height);
	}
}



function resize_user_profile(user_profile)
{
	if (user_profile.length)
	{
		var container_height = $(window).height() - $('nav').outerHeight() - $('#user-tools').outerHeight();		
		var meet_helper = $('#meet-helper');
		user_profile.css('height', container_height - meet_helper.outerHeight());
	}	
}



// POST MESSAGE

function post_message(form)
{
	var submit = form.find('button[type="submit"]');
	var my_message = message.val();
	if (submit.is(':visible'))
	{
		submit.css('visibility', 'hidden');
		$.ajax({
			type: 'POST',
			url: base_url('messages/js_post'),
			data: { conversation_id: conversation_id, message: my_message },
			beforeSend: function() {
				message.val('').focus();
			},
			success: function(data) {
				if (data.html)
				{
					conversation_log.append(data.html);	
					conversation_log.scrollTop(conversation_log[0].scrollHeight);
					form.find('label').addClass('sr-only').empty();
					form.find('.form-group').removeClass('has-error');
					
					$('#conversation-' + conversation_id).prependTo($('#active-conversations'));
					ga('send', 'event', 'Messages', 'Send');
				}
				else if (data.errors)
				{
					form.find('label').removeClass('sr-only').html(data.errors);
					form.find('.form-group').addClass('has-error');
					message.val(my_message);
					ga('send', 'event', 'Messages', 'Send', 'Error');
				}
				submit.css('visibility', '');
				resize_conversation_log();
			}
		});
	}
	return false;	
}

// POLL FOR NEW MESSAGES

function poll_conversation()
{
	if (typeof conversation_id !== 'undefined')
	{
		$.ajax({
			type: 'POST',
			url: base_url('messages/js_poll'),
			data: { conversation_id: conversation_id, message_id: message_id },
			success: function(data) {
				if (data.message_id && message_id < data.message_id)
				{
					message_id = data.message_id;
				}
				
				update_seen(data);
			},
			complete: function(data) {
				if (data.html)
				{
					next_poll = window.setTimeout(poll_conversation, 100);
				}
				else
				{
					next_poll = window.setTimeout(poll_conversation, 500);
				}
			}
		});
	}
}


//UPDATE NOTIFICATIONS

function update_seen(data)
{
	if (data.html)
	{
		conversation_log.append(data.html);
		if (conversation_log.not(':focus').length)
		{
			conversation_log.scrollTop(conversation_log[0].scrollHeight);
		}
	}
	if (data.last_seen)
	{
		$('div.last-seen:not(:empty)').empty();
		$.each(data.last_seen, function(id, value) {
			var last_seen = $('#message-' + id).find('div.last-seen');
			value = 'Seen ' + value;
			if (last_seen.text() != value)
			{
				last_seen.text(value);
			}
		});
	}
}



function notifications_menu()
{
	$.post(base_url('profile/js_notifications'), function(data) {
		$('#notifications-menu').html(data.html);
	});	
}

function update_notifications()
{
	if ($('#active-conversations').length)
	{
		var conversation_ids = [];
		var user_ids = [];
				
		$('#active-conversations a.list-group-item').each(function() {
			conversation_ids.push($(this).attr('data-id'));
			user_ids.push($(this).attr('data-user-id'));
		});
	
		$.ajax({
			type: 'POST',
			url: base_url('messages/js_notifications'),
			data: { conversation_ids: conversation_ids, user_ids: user_ids },
			success: function(data) {
				update_data(data);
			}
		});	
	}
}










//AJAX PREVIOUS / NEXT USER WHEN BROWSING

function replace_container(data)
{	
	var browse_container = jQuery('<div/>', {
		id: 'browse-container',
	}).html(data.html).find('#browse-container');
			
	if (browse_container.find('#user-tools').length == 0)
	{
		$('#browse-container').replaceWith(browse_container);
	}
	else
	{
		var user_profile = browse_container.find('#profile-fragment');
		user_profile.find('#profile-container').hide();
		resize_user_profile(user_profile);
		
		// Replace individual components
		$('#browse-container').find('#profile-fragment').replaceWith(browse_container.find('#profile-fragment'));
		$('#browse-container').find('#profile-fragment').find('#profile-container').fadeIn();
		
		$('#browse-container').find('#user-tools').attr('data-id', browse_container.find('#user-tools').attr('data-id'));
		$('#browse-container').find('#user-tools').attr('data-offset', browse_container.find('#user-tools').attr('data-offset'));
		$('#browse-container').find('#user-tools').find('.meet-buttons').html(browse_container.find('#user-tools').find('.meet-buttons').html());
	
		$('#browse-container').find('#conversation-list').find('.list-group').replaceWith(browse_container.find('#conversation-list').find('.list-group'));
				
		update_notifications();
		$('.tooltip').remove();
		$('[data-toggle="tooltip"]').tooltip({
			'container': 'body',
		});	
	}
}

function reload_container(url)
{
	$('#browse-container').load(url + ' #browse-container > .row', function() {
		resize_conversation_log();
		
		update_notifications();
		$('.tooltip').remove();
		$('[data-toggle="tooltip"]').tooltip({
			'container': 'body',
		});	
	});
}

function browse_action(user_tools, action)
{
	var offset = user_tools.attr('data-offset');
	var user_id = user_tools.attr('data-id');
	$.post(base_url('browse/js_' + action), { id: user_id, offset: offset }, function(data) {
		
		if (action == 'meet')
		{
			var payment_link = $('#meet').attr('data-payment');
			
			if (typeof payment_link !== 'undefined')
			{
				$(location).attr('href', payment_link);
				return false;
			}
			else
			{
				$('#user-profile').find('#profile-container').hide(function() {
					replace_container(data);			
				});			
			}
		}
		else
		{
			$('#user-profile').find('#profile-container').fadeOut(function() {
				replace_container(data);		
			});			
		}
		
		
		if (history.replaceState)
		{
			// history.pushState
			history.replaceState({ myTag: true }, null, data.url);
		}
		else
		{
			window.location.hash = '!' + data.url;
		}
	});
		
	ga('send', 'event', 'Profiles', 'Browse', action, offset);
	return false;
}










$(window).on('click', function(event) {
	$('.popover').hide();
});

$(window).on('keydown', function(event) {
	var user_tools = $('#user-tools');

	if ($('#browse-container').length)
	{
		if (event.which == 13)
		{
			if (!$.trim($('#people-search').val()).length) {
				event.preventDefault();
				browse_action(user_tools, 'meet');
			}
		}
		else if (event.which == 39)
		{
			event.preventDefault();
			browse_action(user_tools, 'skip');
		}
		else if (event.which == 46)
		{
			event.preventDefault();
			browse_action(user_tools, 'block');
		}	
	}
});



$(document).on('click', '#meet, #block, #skip', function() {
	browse_action($(this).closest('#user-tools'), $(this).attr('id'));
});

$(document).on('click', '#meet-helper .btn', function() {
	browse_action($('#user-tools'), 'meet');
});
























// ARCHIVE CONVERSATION

$(document).on('click', '#conversation-list .archive', function() {
	var conversation = $(this).closest('.list-group-item');
	var request = base_url('messages/js_archive');
		
	$.post(request, { id: conversation.attr('data-id') }, function() {
		var conversation_list = conversation.closest('#conversation-list');
		if (conversation_list.hasClass('all-conversations'))
		{
			conversation.addClass('archived');
			conversation.find('span.archive')
				.addClass('unarchive')
				.removeClass('archive')
				.find('span.fa-times')
				.removeClass('fa-times')
				.addClass('fa-plus');
			ga('send', 'event', 'Conversations', 'Archive');
		}
		else if (conversation.hasClass('active'))
		{
			var next_conversation = conversation.next();
			var prev_conversation = conversation.prev();
			if (next_conversation.length)
			{
				$(location).attr('href', next_conversation.attr('href'));
			}
			else if (prev_conversation.length && !prev_conversation.hasClass('disabled'))
			{
				$(location).attr('href', prev_conversation.attr('href'));
			}
			else
			{
				$(location).attr('href', base_url('messages/'));
			}
			ga('send', 'event', 'Conversations', 'Archive', 'Active');
		}
		else
		{
			$('.tooltip').remove();
			conversation.slideUp('fast', function() { $(this).remove(); });
			ga('send', 'event', 'Conversations', 'Archive');
		}
	});
	return false;
});








// BLOCK USER FROM PROFILE

$(document).on('click', '#block-profile-user', function() {
	var user_tools = $(this).closest('#user-tools');
	var offset = user_tools.attr('data-offset');
	var user_id = user_tools.attr('data-id');
	$.post(base_url('browse/js_block'), { id: user_id, offset: offset }, function(data) {
		$(location).attr('href', data.url);
	});
	return false;
});

// POST A MESSAGE

$(document).on('submit', '#send-message', function(event) {
	event.preventDefault();
	post_message($(this));
});

// NAVIGATE BETWEEN CONVERSATIONS

$(window).on('keydown', function(event) {
	var textarea = $('#message-input');
	if (textarea.length)
	{
		if (textarea.val().length)
		{
			if (event.which == 13 &&
				(
					(
						event.shiftKey === true ||
						event.ctrlKey === true ||
						event.altKey === true
					)
					|| window.innerWidth < 992
				)
			)
			{
				if (!$.trim($('#people-search').val()).length) {
					event.preventDefault();
					post_message($('#send-message'));
				}
			}
		}
		else if (!$('#people-search:focus').length)
		{
			if (event.which == 40)
			{
				event.preventDefault();
				var next_conversation = $('#active-conversations').find('.active').next();
				if (next_conversation.length)
				{
					$(location).attr('href', next_conversation.attr('href'));
				}
			}
			else if (event.which == 38)
			{
				event.preventDefault();
				var prev_conversation = $('#active-conversations').find('.active').prev();
				if (prev_conversation.length)
				{
					$(location).attr('href', prev_conversation.attr('href'));		
				}
			}
		}
	}
});




// CLOSE OUT OF CONVERSATIONS ON MOBILE IF CONVERSATION LOG IS CLICKED

$(document).on('click', '#conversation-log, #user-profile, .sidebar-profile-offcanvas', function() {
	$('.row-offcanvas').removeClass('active');
});

$(document).on('click', 'a.toggle-profile', function () {
	$('.row-profile-offcanvas').toggleClass('active');
});





function update_data(data)
{
	$.each(data, function(key, item) {
		var conversation = $('#conversation-' + item.conversation.id);
		var badge = conversation.find('span.badge');
		if (badge.text() != item.conversation.new_message_count)
		{
			badge.text(item.conversation.new_message_count);
		}

		var status = conversation.find('span.status');
		conversation.attr('data-original-title', 'Last Seen ' + item.user.last_activity_timestamp);
		if (item.user.online_status === true)
		{
			status.addClass('online');
		}
		else
		{
			status.removeClass('online');
		}
	});
	
	/*
	 * TODO: Figure out when to change the order and inject new elements
	if (data.conversation_order)
	{
		var elements = [];
		$.each(data.conversation_order, function(id, value) {
			elements.push($('#conversation-' + value));
		});
		$('#conversation-list').find('#active-conversations').append(elements);
	}
	*/
}












//MEET USER FROM PROFILE

$(document).on('click', '#meet-profile-user, .meet-profile-user', function() {
	$.post(base_url('browse/js_meet_profile'), { id: $(this).attr('data-id') }, function(data) {
		$(location).attr('href', data.url);
	});
	return false;
});




//UNBLOCK USER

$(document).on('click', '#blocked-users .btn', function() {
	var user = $(this).closest('tr');
	$.post(base_url('users/js_unblock'), { id: user.attr('data-id') }, function() {
		user.hide();
	});
	return false;
});








//VISIT PROFILE

$(document).on('click', '.view-profile', function(event) {
	event.stopPropagation();
	$(location).attr('href', base_url('profile/view/' + $(this).closest('.list-group-item').attr('data-eid')));
	return false;
});





//SEARCH AUTOCOMPLETE (jQuery UI)

$(function() {
	var people_search = $('#people-search');
	people_search.catcomplete({
		source: base_url('messages/js_search'),
		minLength: 2
	});	
	if (window.innerWidth >= 992)
	{
		people_search.attr('placeholder', 'Search for People, Places or Interests');
	}	
});

$.widget( "custom.catcomplete", $.ui.autocomplete, {
_create: function() {
 this._super();
 this.widget().menu( "option", "items", "> :not(.ui-autocomplete-category)" );
},
_renderMenu: function( ul, items ) {
 var that = this,
   currentCategory = "";
 $.each( items, function( index, item ) {
   var li;
   if ( item.category != currentCategory ) {
     ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
     currentCategory = item.category;
   }
   li = that._renderItemData( ul, item );
   if ( item.category ) {
     li.attr( "aria-label", item.category + " : " + item.label );
   }
 });
}
});






//MOBILE NAVIGATION

$(document).on('click', '#toggle-dropdown', function() {
	if ($('#mobile-user-menu:empty').length)
	{
		$('#user-menu li.mobile-menu').clone().appendTo('#mobile-user-menu');
	}
	if ($('#mobile-users-menu:empty').length)
	{
		$('#users-menu li.mobile-menu').clone().appendTo('#mobile-users-menu');
	}	
	if ($('#mobile-search:empty').length)
	{
		$('nav form').clone().removeClass('navbar-form').appendTo('#mobile-search');
	}	
	$('#mobile-dropdown').slideToggle();
	return false;
});







//NOTIFICATIONS MENU

$(document).on('click', '#notifications-dropdown', function() {
	if (!$(this).closest('li.dropdown').hasClass('open'))
	{
		notifications_menu();
	}
});
