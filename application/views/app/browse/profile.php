<?= $header ?>
	<title>Browse User Profiles | Dazah</title>
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
		
			<!-- Popup for new users -->
			<div class="popover left hidden-xs">
				<div class="arrow"></div>
				<h3 class="popover-title">Get Started</h3>
				<div class="popover-content">
					<p>Browse through user profiles to discover your matches and click the Meet button to start a conversation.</p>
				</div>
			</div>
			
			<!-- Meet alert -->
			<div id="meet-helper" class="row hidden-xs">
				<div class="col-md-12">
					<div class="alert alert-warning alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<span>Want to <span class="btn btn-primary">meet</span> this person?</span>
						<span class="h5"><strong>
							Introduce yourself in 1-click<span class="hidden-sm"> or skip to discover someone new</span>.
						</strong></span>
					</div>
				</div>
			</div>
		
			<div class="row">
				<div id="profile-fragment" class="col-lg-9">
					<?= $profile_fragment ?>
				</div>

				<div id="user-tools" data-id="<?= $user->id ?>" data-offset="<?= $offset ?>" class="col-lg-3">
					<div class="meet-buttons">
						<?php if (isset($user->meet->price_usd) AND $user->meet->price_usd == 0): ?>
							<button id="meet" class="btn btn-primary btn-lg btn-block" type="button">Meet</button>
						<?php elseif (isset($user->meet->payment->paypal->url) AND $user->meet->price_usd > 0): ?>
							<button id="meet" class="btn btn-primary btn-lg btn-block" type="button" data-payment="<?= htmlspecialchars(payment_link($user)) ?>">Meet for $<?= $user->meet->price_usd ?></button>
						<?php endif; ?>
						<button id="skip" class="btn btn-warning btn-lg btn-block" type="button">Skip</button>
						<button id="block" class="btn btn-danger btn-lg btn-block" type="button">Mute</button>
					</div>
					
					<div class="keyboard-shortcuts hidden-xs hidden-sm hidden-md">
						<div><span class="fa fa-keyboard-o" aria-hidden="true"></span> Keyboard Shortcuts</div>
						<ul class="small">
							<li><kbd class="no-bg">&crarr;</kbd> Return/Enter to <strong>meet</strong></li>
							<li><kbd class="no-bg">&rarr;</kbd> Right arrow to <strong>skip</strong></li>
							<li><kbd>DEL</kbd> Delete to <strong>mute</strong></li>
						</ul>
					</div>
					
					<div id="browse-carbon" class="clearfix"></div>
					
				</div>
			</div>		
		</div>
		
	</div>
	
</div>

<?= $footer ?>