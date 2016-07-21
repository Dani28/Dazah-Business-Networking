<?= $header ?>
	<title>Quota Reached | Dazah</title>
    <link rel="stylesheet" type="text/css" href="/css/carbon.css">		
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
						<div class="h1">Sorry! Your daily quota has been reached.</div>
						<p class="lead">You cannot start more free conversations today.</p>
					</div>
					
					
				</div>

			</div>		
		</div>
		
	</div>
	
</div>

	
<?= $footer ?>