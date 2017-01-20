<?= $header ?>
	<title>User Search | Business Network</title>
</head>
<body>

<?= $menu ?>

<div class="container">
		
	<div id="conversation-list" class="search-conversations clearfix">
		<div class="list-group">
		<?php if (trim($searched_users) == '' AND count($this->input->get()) > 0): ?>
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
	
	<?= $advanced_search ?>
	
</div>

<?= $footer ?>