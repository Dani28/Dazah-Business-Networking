<?= $header ?>
	<title>User Profile for <?= (isset($user->profile->first_name) ? $user->profile->first_name : 'Unknown') . ' ' . (isset($user->profile->last_name) ? $user->profile->last_name : 'Name') ?> | Dazah</title>
</head>
<body id="web-app">
	
<?= $menu ?>

<div id="full-profile" class="container-fluid">
	<div class="row row-offcanvas row-offcanvas-left">
	
		<div id="conversation-list" class="col-sm-4 col-md-3 sidebar-offcanvas">
			<div class="list-group"><?= $sidebar ?></div>
		</div>
				
		<div id="user-profile" class="col-sm-8 col-md-9">
		
			<div class="row">
				<div class="col-lg-12">
					<?= $profile_fragment ?>
										
					<?php if (isset($match->conversation->id) OR $match->relationship->muted OR $match->relationship->skipped OR $match->match->algorithmic_match): ?>
    					<?php if (isset($match->conversation->id)): ?>
    						<p>
    							<a class="btn btn-primary btn-block btn-lg" href="<?= conversation_url($match->conversation->id) ?>" role="button">Message</a>
    							<em>You're participating in a conversation with <?= isset($user->profile->first_name) ? $user->profile->first_name : 'Unknown' ?></em>
    						</p>					
    					<?php elseif (isset($match->meet->price_usd) AND $match->meet->price_usd == 0): ?>
    						<?php if (isset($match->relationship->skipped) AND $match->relationship->skipped): ?>
        						<p>
        							<a id="meet-profile-user" data-id="<?= $user->id ?>" class="btn btn-primary btn-block btn-lg" href="#" role="button">Meet</a>
        							<em>You've previously skipped over <?= isset($user->profile->first_name) ? $user->profile->first_name : 'Unknown' ?></em>
        						</p>
    						<?php elseif (isset($match->match->algorithmic_match) AND $match->match->algorithmic_match): ?>
        						<p>
        							<a id="meet-profile-user" data-id="<?= $user->id ?>" class="btn btn-primary btn-block btn-lg" href="#" role="button">Meet</a>
        							<em>You were recently matched with <?= isset($user->profile->first_name) ? $user->profile->first_name : 'Unknown' ?></em>
        						</p>
    						<?php endif; ?>
						<?php elseif (isset($match->meet->price_usd)): ?>
    						<div class="bg-info empty-profile">
    							<p class="h4">You cannot start more free conversations today.</p>
    							<p class="lead">You can still introduce yourself to <?= isset($user->profile->first_name) ? $user->profile->first_name : 'Unknown' ?> by purchasing access.</p>
    							<a class="btn btn-primary btn-lg spaced" href="<?= isset($match->meet->payment->paypal->url) ? htmlspecialchars(payment_link($user)) : '#' ?>" role="button">Meet <?= $user->profile->first_name ?> for $<?= $match->meet->price_usd ?></a>
    						</div>
    					<?php endif; ?>
					<?php elseif (isset($match->meet->price_usd)): ?>
										
    						<div class="bg-info empty-profile">
    							<p class="h3">You are not matched with <?= isset($user->profile->first_name) ? $user->profile->first_name : 'Unknown' ?></p>
    							<p class="lead">You can still introduce yourself to <?= isset($user->profile->first_name) ? $user->profile->first_name : 'Unknown' ?> by purchasing access.</p>
    							<a class="btn btn-primary btn-lg spaced" href="<?= isset($match->meet->payment->paypal->url) ? htmlspecialchars(payment_link($user)) : '#' ?>" role="button">Meet <?= isset($user->profile->first_name) ? $user->profile->first_name : 'Unknown' ?> for $<?= $match->meet->price_usd ?></a>
								<div class="small">
        							<a href="<?= site_url() ?>" class="small">Discover New Matches</a>
        						</div>
    						</div>    					
					<?php endif; ?>
				</div>
			</div>
		</div>
		
	</div>
	
</div>

	
<?= $footer ?>