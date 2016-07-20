<?= $header ?>
	<title>My Connections | Dazah</title>
</head>
<body>

<?= $menu ?>

<div class="container">

	<?php if (!empty($met_users)): ?>
		<h1>My Connections</h1>
				
		<?= isset($pagination) ? $pagination : '' ?>
		
		<table id="met-users" class="table table-striped table-hover">
			<thead>
				<tr>
					<th><a href="<?= site_url('users/report') ?>">Name</a></th>
					<th class="hidden-xs"><a href="<?= site_url('users/report/headline') ?>">Headline</a></th>
					<th class="hidden-xs hidden-sm hidden-md"><a href="<?= site_url('users/report/location') ?>">Location</a></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($met_users AS $user): ?>
					<tr data-id="<?= $user->id ?>">
						<td class="text-nowrap"><a href="<?= profile_url($user) ?>"><?= $user->profile->first_name . ' ' . $user->profile->last_name ?></a></td>
						<td class="hidden-xs hidden-sm"><?= $user->profile->headline ?></td>
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
				<div class="lead">You have not met any users.</div>
			</div>
		
	<?php endif; ?>		
	
</div>


<?= $footer ?>