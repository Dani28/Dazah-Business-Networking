<?php foreach ($users AS $user): ?>
	<?php if ($user->relationship->existing_conversation): ?>
		<a id="conversation-<?= $user->id ?>" data-id="<?= $user->id ?>" data-eid="<?= encrypt_id($user->id) ?>" class="col-lg-3 col-md-4 col-sm-6 list-group-item" href="<?= conversation_url($user->conversation->id) ?>" data-toggle="tooltip" data-placement="right auto" title="Active <?= timestamp($user->usage->last_activity_timestamp) ?>">
	<?php elseif ($user->meet->price_usd > 0): ?>
		<a id="conversation-<?= $user->id ?>" data-id="<?= $user->id ?>" data-eid="<?= encrypt_id($user->id) ?>" class="col-lg-3 col-md-4 col-sm-6 list-group-item" href="<?= $user->meet->payment->paypal->url ?>" data-toggle="tooltip" data-placement="right auto" title="Active <?= timestamp($user->usage->last_activity_timestamp) ?>">
	<?php elseif ($user->meet->price_usd == 0): ?>
		<a id="conversation-<?= $user->id ?>" data-id="<?= $user->id ?>" data-eid="<?= encrypt_id($user->id) ?>" class="col-lg-3 col-md-4 col-sm-6 list-group-item meet-profile-user" data-id="<?= $user->id ?>" href="#" data-toggle="tooltip" data-placement="right auto" title="Active <?= timestamp($user->usage->last_activity_timestamp) ?>">
	<?php else: ?>
		<a id="conversation-<?= $user->id ?>" data-id="<?= $user->id ?>" data-eid="<?= encrypt_id($user->id) ?>" class="col-lg-3 col-md-4 col-sm-6 list-group-item" href="<?= profile_url($user) ?>" data-toggle="tooltip" data-placement="right auto" title="Active <?= timestamp($user->usage->last_activity_timestamp) ?>">			
	<?php endif; ?>
			<img src="<?= $user->thumbnail ?>" alt="Profile Picture" class="img-circle img-thumbnail" width="32" height="32">
			
			<span class="status<?= is_online($user) ? ' online' : '' ?>">
				<span class="fa fa-user" aria-hidden="true"></span>
			</span>			
						
			<?php if ($user->relationship->existing_conversation): ?>
				<span class="fa fa-comment" aria-hidden="true"></span>
			<?php elseif ($user->meet->price_usd == 0): ?>
				<span class="btn btn-primary btn-xs">Free to Meet</span>
			<?php elseif ($user->meet->price_usd > 0): ?>
				<span class="btn btn-primary btn-xs">$<?= $user->meet->price_usd ?> to Meet</span>			
			<?php endif; ?>
			<span class="h4">
				<span><?= isset($user->profile->first_name) ? $user->profile->first_name : 'Unknown' ?></span>
				<span><?= isset($user->profile->last_name) ? $user->profile->last_name : 'Name' ?></span>
			</span>
			
			<br><span class="small"><?= isset($user->profile->headline) ? $user->profile->headline : '' ?></span>
			<br><span class="small"><?= isset($user->profile->pitch) ? $user->profile->pitch : '' ?></span>
			<br><span><?= get_location($user) ?></span>

			<span class="view-profile btn btn-info btn-xs"><span class="fa fa-info-circle" aria-hidden="true"></span> Profile</span>
		</a>
<?php endforeach; ?>