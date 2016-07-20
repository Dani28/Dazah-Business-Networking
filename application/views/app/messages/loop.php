<?php foreach ($messages AS $message): ?>
	<div id="message-<?= $message->id ?>" class="row">
		
			<div class="col-md-11<?= ($message->author->id == who_am_i()->id) ? ' col-md-offset-1' : '' ?>">
				<div class="panel panel-<?= ($message->author->id == who_am_i()->id) ? 'primary' : 'default' ?>">
					<div class="panel-heading small">
						<div class="pull-right"><?= timestamp($message->timestamp) ?></div>
						<?php if ($message->author->id == who_am_i()->id): ?>
							<div class="text-uppercase"><?= isset(who_am_i()->profile->first_name) ? who_am_i()->profile->first_name : 'Me' ?></div>
						<?php else: ?>
							<div class="text-uppercase">
								<?= isset($users[$message->author->id]->profile->first_name) ? $users[$message->author->id]->profile->first_name : 'Unknown' ?>
							</div>
						<?php endif; ?>
					</div>					
		
					<div class="panel-body">
						<?= htmlspecialchars_decode($message->message->parsed) ?>
					</div>
					
					<div class="small pull-right last-seen">
						<?php if (isset($message->last_seen)): ?>
							Seen <?= timestamp($message->last_seen->timestamp) ?>
						<?php endif; ?>
					</div>
					
				</div>
								
			</div>
			
			<?php if ($message->author->id != who_am_i()->id): ?>
				<div class="hidden-xs hidden-sm col-md-1">
					<a href="<?= profile_url($users[$message->author->id]) ?>"><img src="<?= isset($users[$message->author->id]->thumbnail) ? $users[$message->author->id]->thumbnail : '//:0' ?>" alt="Profile Picture" class="img-circle img-thumbnail" width="32" height="32"></a>
				</div>
			<?php endif; ?>
			
	</div>
<?php endforeach; ?>