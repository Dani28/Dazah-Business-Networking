<?= $header ?>
	<title>User Search | Dazah</title>
</head>
<body>

<?= $menu ?>

<div class="container">
		
	<div id="conversation-list" class="search-conversations clearfix">
		<div class="list-group">
		<?php if (trim($searched_users) == ''): ?>
			<div class="alert alert-danger">
				<p>
					Sorry, no profiles currently match your search criteria.
					Please check back soon because we are adding new users to our database every day!
				</p>
			</div>
		<?php else: ?>
			<?= $searched_users ?>
		<?php endif; ?>
		</div>		
	</div>	
	
	<?= isset($pagination) ? $pagination : '' ?>
	
	
</div>

<?= $footer ?>