<?= $header ?>
	<title>Skipped Users | Dazah</title>
</head>
<body>

<?= $menu ?>

<div class="container">

	<?php if (!empty($skipped_users)): ?>
		<h1>Skipped Users</h1>
		
		<p class="lead">You can choose to meet with a person you've previously skipped over from within their profile.</p>
		
		<?= isset($pagination) ? $pagination : '' ?>
		
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th><a href="<?= site_url('users/skipped/first_name') ?>">Name</a></th>
					<th><a href="<?= site_url('users/skipped/last_activity') ?>">Last Activity</a></th>
					<th class="hidden-xs hidden-sm">Headline</th>
					<th class="hidden-xs hidden-sm hidden-md">Location</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($skipped_users AS $user): ?>
					<tr>
						<td class="text-nowrap"><a href="<?= profile_url($user) ?>"><?= (isset($user->profile->first_name) ? $user->profile->first_name : 'Unknown Name') . ' ' . (isset($user->profile->last_name) ? $user->profile->last_name : '') ?></a></td>
						<td class="text-nowrap"><?= isset($user->usage->last_activity_timestamp) ? timestamp($user->usage->last_activity_timestamp) : '' ?></td>
						<td class="hidden-xs hidden-sm"><?= isset($user->profile->headline) ? $user->profile->headline : '' ?></td>
						<td class="hidden-xs hidden-sm hidden-md"><?= get_location($user) ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<?= isset($pagination) ? $pagination : '' ?>
		
	<?php else: ?>
	
	
			<div class="empty-profile">
				<div class="h1">Nothing To Show</div>
				<span class="fa fa-frown-o fa-3x" aria-hidden="true"></span>
				<div class="lead">You haven't been matched with any users.</div>
			</div>
		
	<?php endif; ?>		
	
</div>


<?= $footer ?>