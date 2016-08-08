
<?php foreach ($notifications AS $row): ?>
	<li>
		<a href="<?= conversation_url($row->conversation->id) ?>">
			<span class="h4">    		
			<img src="<?= extract_user($row->conversation)->thumbnail ?>" alt="Profile Picture" class="img-circle img-thumbnail" width="32" height="32">
				<?= isset(extract_user($row->conversation)->profile->first_name) ? extract_user($row->conversation)->profile->first_name : 'Unknown Name' ?>
				<?= isset(extract_user($row->conversation)->profile->last_name) ? extract_user($row->conversation)->profile->last_name : '' ?>
				
				<?php if ($row->conversation->first_message->timestamp == $row->conversation->latest_message->timestamp): ?>
					<?php if ($row->conversation->first_message->user->id == who_am_i()->id): ?>
    					has connected with you.
					<?php else: ?>
						would like to meet you.
					<?php endif; ?>
				<?php else: ?>
					is awaiting your reply.
				<?php endif; ?>

			</span>
			<span class="small"><?= isset(extract_user($row->conversation)->profile->headline) ? extract_user($row->conversation)->profile->headline : '' ?></span>
			<span><?= get_location(extract_user($row->conversation)) ?></span>
		</a>
	</li>
<?php endforeach; ?>