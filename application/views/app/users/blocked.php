<?= $header ?>
	<title>Muted Users | Dazah</title>
</head>
<body>

<?= $menu ?>

<div class="container">

	<?php if (!empty($blocked_users)): ?>
		<h1>Muted Users</h1>
		
		<p class="lead">Muted users do not know that they have been muted. You will simply not see their messages.</p>
		
		<?= isset($pagination) ? $pagination : '' ?>
		
		<table id="blocked-users" class="table table-striped table-hover">
			<thead>
				<tr>
					<th></th>
					<th><a href="<?= site_url('users/blocked') ?>">Name</a></th>
					<th class="hidden-xs"><a href="<?= site_url('users/blocked/headline') ?>">Headline</a></th>
					<th class="hidden-xs hidden-sm hidden-md"><a href="<?= site_url('users/blocked/location') ?>">Location</a></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($blocked_users AS $user): ?>
					<tr data-id="<?= $user->id ?>">
						<td><a href="#" class="btn btn-default btn-xs" role="button" title="Unmute User"><span class="fa fa-user-times" aria-hidden="true"></span></a></td>
						<td class="text-nowrap"><a href="<?= profile_url($user) ?>"><?= (isset($user->profile->first_name) ? $user->profile->first_name : 'Unknown') . ' ' . (isset($user->profile->last_name) ? $user->profile->last_name : 'Name') ?></a></td>
						<td class="hidden-xs hidden-sm"><?= isset($user->profile->headline) ? $user->profile->headline : '' ?></td>
						<td class="text-nowrap hidden-xs hidden-sm hidden-md"><?= get_location($user) ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<?= isset($pagination) ? $pagination : '' ?>
		
	<?php else: ?>
	
	
			<div class="empty-profile">
				<div class="h1">Nothing To Show</div>
				<span class="fa fa-thumbs-o-up fa-3x" aria-hidden="true"></span>
				<div class="lead">You are not muting any users.</div>
			</div>
		
	<?php endif; ?>		
	
</div>


<?= $footer ?>