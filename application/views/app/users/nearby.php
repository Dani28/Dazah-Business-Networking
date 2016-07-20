<?= $header ?>
	<title>Nearby Users | Dazah</title>
</head>
<body>

<?= $menu ?>

<div class="container">
		
	<div id="conversation-list" class="search-conversations clearfix">
		<div class="list-group">
		<?= $nearby_users ?>
		</div>		
	</div>	
	
	<?= isset($pagination) ? $pagination : '' ?>
	
	
</div>

<?= $footer ?>