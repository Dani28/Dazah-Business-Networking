<?= $header ?>
	<title>User Search | Dazah</title>
</head>
<body>

<?= $menu ?>

<div class="container">
		
	<div id="conversation-list" class="search-conversations clearfix">
		<div class="list-group">
		<?= $searched_users ?>
		</div>		
	</div>	
	
	<?= isset($pagination) ? $pagination : '' ?>
	
	
</div>

<?= $footer ?>