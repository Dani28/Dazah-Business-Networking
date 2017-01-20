<?= $header ?>
	<title>Conversation with <?= (isset($user->profile->first_name) ? $user->profile->first_name : 'Unknown Name') . ' ' . (isset($user->profile->last_name) ? $user->profile->last_name : '') ?> | Dazah</title>
</head>
<body id="web-app">
	
<?= $menu ?>

<?php if (isset($user->usage->available_status) AND $user->usage->available_status): ?>
	<a href="#" class="toggle-profile bg-info">
		<?= isset($user->profile->first_name) ? $user->profile->first_name : 'Unknown Name' ?> <?= isset($user->profile->last_name) ? $user->profile->last_name : '' ?>
		<span class="fa fa-info-circle"></span>
	</a>
<?php else: ?>
	<div class="toggle-profile bg-info">
		<?= isset($user->profile->first_name) ? $user->profile->first_name : 'Unknown Name' ?> <?= isset($user->profile->last_name) ? $user->profile->last_name : '' ?>
	</div>
<?php endif; ?>

<div class="container-fluid">

	<div class="row row-offcanvas row-offcanvas-left">

		<div class="row-profile-offcanvas row-profile-offcanvas-left">
			
			<div id="conversation-list" class="col-sm-4 col-md-3 sidebar-offcanvas">
				<div class="list-group"><?= $sidebar ?></div>
			</div>				
			
			<?php if (isset($user->usage->available_status) AND $user->usage->available_status): ?>
				<div class="sidebar-profile-offcanvas col-xs-12 hidden-xs">
					<div id="user-profile" class="container-fluid">
						<?= $profile_fragment ?>
						
						<div id="user-tools" class="row" data-id="<?= $user->id ?>" data-offset="-1">
							<div class="col-xs-12">
								<a class="btn btn-primary btn-block btn-lg" href="<?= profile_url($user) ?>">View Profile</a>
							</div>
							<div class="col-xs-12">
								<button id="block-profile-user" class="btn btn-danger btn-block btn-lg" type="button">Mute</button>
							</div>
						</div>			
						
					</div>
				
				
				</div>
			<?php endif; ?>			

			
			<div id="conversation-log" class="col-xs-12 col-sm-8 col-md-9"><?= $parsed_messages ?></div>
			
		</div>
		
	</div>
</div>
	
<div class="bottom-tools<?= (!(isset($user->usage->available_status) AND $user->usage->available_status)) ? ' invalid-user' : '' ?>">
	
	<div class="container-fluid">
		
		<form id="send-message" class="row">
			<div class="col-sm-9 col-sm-offset-3 col-xs-8">
				<div class="form-group">
					<label for="message" class="control-label sr-only">Message</label>
					<textarea class="form-control input-lg" id="message-input" rows="3" placeholder="Type a message &hellip;"></textarea>
				</div>
			</div>
			<div class="col-sm-9 col-sm-offset-3 col-xs-4">
				<div class="keyboard-shortcuts pull-right hidden-xs">
					<p><kbd>&crarr;</kbd> to insert a new line</p>
					<p><kbd>Shift+&crarr;</kbd> to send a message</p>
				</div>			
				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-lg">Send</button>
				</div>
			</div>
		</form>
		
	</div>

</div>

<script type="text/javascript">
        
    var message_id = <?= $latest_message_id ?>;
    var message = $('#message-input');
    var conversation_list = $('#conversation-list');
    var conversation_log = $('#conversation-log');
    var user_profile = $('#user-profile');
    var conversation_id = '<?= $conversation->id ?>';
    var next_poll;	
</script>
	
<?= $footer ?>