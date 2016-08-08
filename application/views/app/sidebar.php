<div class="list-group-item list-group-item-info">
	<?php if (current_url() != site_url()): ?>
		<a href="<?= site_url('browse/profile') ?>" class="add" title="Meet Users"><span class="fa fa-fw fa-plus" aria-hidden="true"></span>Meet</a>
	<?php endif; ?>
	<span>My Active Conversations</span>
</div>

<?php if (!empty($conversations)): ?>
	<div id="active-conversations">
    	<?php foreach ($conversations AS $row): ?>
    	    	
    		<a id="conversation-<?= $row->conversation->id ?>" data-id="<?= $row->conversation->id ?>" data-user-id="<?= extract_user($row->conversation)->id ?>" class="list-group-item<?= (isset($conversation) AND $conversation->id == $row->conversation->id) ? ' active' : '' ?>" href="<?= conversation_url($row->conversation->id) ?>" data-toggle="tooltip" data-placement="right" title="Last Seen <?= isset(extract_user($row->conversation)->usage->last_activity_timestamp) ? timestamp(extract_user($row->conversation)->usage->last_activity_timestamp) : 'Unknown' ?>">
    			<span class="archive"><span class="fa fa-times" aria-hidden="true"></span></span>
    			<span class="badge"><?= (isset($row->new_message_count) AND $row->new_message_count > 0) ? $row->new_message_count : '' ?></span>
    			<span class="status<?= (isset(extract_user($row->conversation)->usage->online_status) AND extract_user($row->conversation)->usage->online_status) ? ' online' : '' ?>">
    				<span class="fa fa-user" aria-hidden="true"></span>
    			</span>
    			<img src="<?= isset(extract_user($row->conversation)->thumbnail) ? extract_user($row->conversation)->thumbnail : '//:0' ?>" alt="Profile Picture" class="img-circle img-thumbnail" width="32" height="32">
    			<span class="h4">
    				<span><?= isset(extract_user($row->conversation)->profile->first_name) ? extract_user($row->conversation)->profile->first_name : 'Unknown Name' ?></span>
    				<span><?= isset(extract_user($row->conversation)->profile->last_name) ? extract_user($row->conversation)->profile->last_name : '#' . number_format($row->conversation->id) ?></span>
    			</span>
    		</a>
    		
    	<?php endforeach; ?>
	</div>
	<div class="text-center">
		<a href="<?= site_url('messages/report') ?>" class="more" title="All My Conversations"><span class="fa fa-angle-double-down" aria-hidden="true"></span></a>
	</div>
<?php else: ?>
	<div id="active-conversations" class="bottom-spaced"></div>
<?php endif; ?>