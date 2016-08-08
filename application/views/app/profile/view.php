<?= $header ?>
	<title>User Profile for <?= (isset($user->profile->first_name) ? $user->profile->first_name : 'Unknown Name') . ' ' . (isset($user->profile->last_name) ? $user->profile->last_name : '') ?> | Dazah</title>
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
					
					<?php if (isset($user->conversation->id) OR (isset($user->relationship->muted) AND $user->relationship->muted) OR (isset($user->relationship->skipped) AND $user->relationship->skipped) OR (isset($user->match->algorithmic_match) AND $user->match->algorithmic_match)): ?>
    					<?php if (isset($user->conversation->id)): ?>
    						<p>
    							<a class="btn btn-primary btn-block btn-lg" href="<?= conversation_url($user->conversation->id) ?>" role="button">Message</a>
    							<em>You're participating in a conversation with <?= isset($user->profile->first_name) ? $user->profile->first_name : 'Unknown Name' ?></em>
    						</p>			
    					<?php elseif (isset($user->meet->price_usd) AND $user->meet->price_usd == 0): ?>
    						<?php if (isset($user->relationship->skipped) AND $user->relationship->skipped): ?>
        						<p>
        							<a id="meet-profile-user" data-id="<?= $user->id ?>" class="btn btn-primary btn-block btn-lg" href="#" role="button">Meet</a>
        							<em>You've previously skipped over <?= isset($user->profile->first_name) ? $user->profile->first_name : 'Unknown Name' ?></em>
        						</p>
    						<?php elseif (isset($user->match->algorithmic_match) AND $user->match->algorithmic_match): ?>
        						<p>
        							<a id="meet-profile-user" data-id="<?= $user->id ?>" class="btn btn-primary btn-block btn-lg" href="#" role="button">Meet</a>
        							<em>You were recently matched with <?= isset($user->profile->first_name) ? $user->profile->first_name : 'Unknown Name' ?></em>
        						</p>
    						<?php endif; ?>
						<?php elseif (isset($user->meet->price_usd)): ?>
    						<div class="bg-info empty-profile">	
    							<p class="h4">You cannot start more free conversations today.</p>
    							<p class="lead">You can still introduce yourself to <?= isset($user->profile->first_name) ? $user->profile->first_name : 'Unknown Name' ?> by purchasing access.</p>
    							<a class="btn btn-primary btn-lg spaced" href="<?= isset($user->meet->payment->paypal->url) ? htmlspecialchars(payment_link($user)) : '#' ?>" role="button">Meet <?= $user->profile->first_name ?> for $<?= $user->meet->price_usd ?></a>
    						</div>
    					<?php endif; ?>
					<?php elseif (isset($user->meet->price_usd)): ?>
										
    						<div class="bg-info empty-profile">
    							<p class="h3">You are not matched with <?= isset($user->profile->first_name) ? $user->profile->first_name : 'Unknown Name' ?></p>
    							<p class="lead">You can still introduce yourself to <?= isset($user->profile->first_name) ? $user->profile->first_name : 'Unknown Name' ?> by purchasing access.</p>
    							<a class="btn btn-primary btn-lg spaced" href="<?= isset($user->meet->payment->paypal->url) ? htmlspecialchars(payment_link($user)) : '#' ?>" role="button">Meet <?= isset($user->profile->first_name) ? $user->profile->first_name : 'Unknown Name' ?> for $<?= $user->meet->price_usd ?></a>
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