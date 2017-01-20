<?= $header ?>
	<title>Oops | Business Network</title>
</head>
<body id="web-app">
	
<?= $menu ?>

<div id="browse-container" class="container-fluid">
	<div class="row row-offcanvas row-offcanvas-left">
	
		<div id="conversation-list" class="col-sm-4 col-md-3 sidebar-offcanvas">
			<div class="list-group"><?= $sidebar ?></div>
		</div>
				
		<div id="user-profile" class="col-sm-8 col-md-9">
		
			
		
			<div class="row">
				<div id="profile-fragment" class="col-xs-12">
					
					
					<div class="empty-profile bg-danger">
						<div class="h1">Sorry! We have no profiles to show.</div>
						<p class="lead">Please check back soon because we are adding new users to our database every day!</p>
					</div>
					
					
				</div>

			</div>		
		</div>
		
	</div>
	
</div>

	
<?= $footer ?>