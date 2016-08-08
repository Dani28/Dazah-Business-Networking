<?= $header ?>
	<title>Conversations | Dazah</title>
</head>
<body>

<?= $menu ?>

<div class="container">
	
	<?= $pagination ?>

	<div id="conversation-list" class="all-conversations clearfix">
		<div class="list-group">
			<?php foreach ($conversations AS $row): ?>
					<a id="conversation-<?= $row->conversation->id ?>" data-id="<?= $row->conversation->id ?>" data-user-id="<?= extract_user($row->conversation)->id ?>" class="col-lg-3 col-md-4 col-sm-6 list-group-item<?= (isset($row->archived_status) AND $row->archived_status) ? ' archived' : '' ?>" href="<?= conversation_url($row->conversation->id) ?>" data-toggle="tooltip" data-placement="right auto" title="Active <?= isset(extract_user($row->conversation)->usage->last_activity_timestamp) ? timestamp(extract_user($row->conversation)->usage->last_activity_timestamp) : 'Unknown' ?>">
						<?php if (isset($row->archived_status) AND $row->archived_status): ?>
							<span class="unarchive"><span class="fa fa-plus" aria-hidden="true"></span></span>
						<?php else: ?>
							<span class="archive"><span class="fa fa-times" aria-hidden="true"></span></span>
						<?php endif; ?>
						<span class="badge"><?= (isset($row->new_message_count) AND $row->new_message_count > 0) ? $row->new_message_count : '' ?></span>
						<span class="status">
							<span class="fa fa-user" aria-hidden="true"></span>
						</span>
						<img src="<?= isset(extract_user($row->conversation)->thumbnail) ? extract_user($row->conversation)->thumbnail : '//:0' ?>" alt="Profile Picture" class="img-circle img-thumbnail" width="32" height="32">
						<span class="h4">
							<span><?= isset(extract_user($row->conversation)->profile->first_name) ? extract_user($row->conversation)->profile->first_name : 'Unknown Name' ?></span>
							<span><?= isset(extract_user($row->conversation)->profile->last_name) ? extract_user($row->conversation)->profile->last_name : '' ?></span>
						</span>
					</a>
			<?php endforeach; ?>
		</div>
	</div>
	
	<?= $pagination ?>
</div>

<?= $footer ?>