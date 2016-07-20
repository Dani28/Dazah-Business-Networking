<nav class="navbar navbar-default navbar-static-top" role="navigation">
	<div class="container<?= who_am_i() ? '-fluid' : '' ?>">
	
		<!-- Mobile Icons -->
		<div class="pull-right">
			<?php if (who_am_i()): ?>
				<button type="button" class="navbar-toggle collapsed" id="toggle-dropdown">
					<span class="fa fa-navicon" aria-hidden="true"></span>
				</button>
				<button type="button" class="navbar-toggle collapsed" id="offcanvas">
					<span class="fa fa-comment" aria-hidden="true"></span>
				</button>			
			<?php endif; ?>
		</div>			
	
		<!-- Logo -->
		<div class="navbar-header">		
			<a class="navbar-brand" href="<?= site_url() ?>">Dazah</a>
		</div>
		
		
		<?php if (who_am_i()): ?>
			<!-- Mobile Dropdown -->
			<div id="mobile-dropdown" class="row">
				<ul id="mobile-user-menu" class="nav navbar-nav col-xs-6"></ul>
				<ul id="mobile-users-menu" class="nav navbar-nav col-xs-6"></ul>		

				<div id="mobile-search" class="nav navbar-nav col-xs-6"></div>				
			</div>		

			<div class="collapse navbar-collapse">
			
				<!-- Search -->
				<form action="<?= site_url('messages/search') ?>" class="navbar-form navbar-left" role="search">
					<div class="form-group">
						<input id="people-search" type="search" name="query" class="form-control" placeholder="People Search">
					</div>
					<button type="submit" class="btn btn-info"><span class="fa fa-search" aria-hidden="true"></span></button>
				</form>			
			
				<ul class="nav navbar-nav pull-right">			
				
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" id="notifications-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" title="Notifications">
							<span class="fa fa-bell fa-fw" aria-hidden="true"></span>
							<span class="caret"></span>
						</a>
						<ul id="notifications-menu" class="dropdown-menu">
							<li class="has-margin"><i class="fa fa-refresh fa-spin fa-fw"></i>Loading &hellip;</li>
						</ul>
					</li>		
				
				
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" title="Meet">
							<span class="fa fa-user-plus fa-fw" aria-hidden="true"></span>
							<span class="hidden-sm">Meet</span>
							<span class="caret"></span>
						</a>
						<ul id="users-menu" class="dropdown-menu">
							<li class="mobile-menu<?= uri_string() == '' ? ' active' : '' ?>"><a href="<?= site_url() ?>"><span class="fa fa-fw fa-bullseye"></span>Discover New Matches</a></li>
							<li class="mobile-menu<?= uri_string() == 'users/nearby' ? ' active' : '' ?>"><a href="<?= site_url('users/nearby') ?>"><span class="fa fa-fw fa-home"></span>Users Nearby Me</a></li>					
						</ul>
					</li>			

				
					<li class="dropdown">
						<a href="#" class="dropdown-toggle user-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
							<img src="<?= isset(who_am_i()->thumbnail) ? who_am_i()->thumbnail : '' ?>" alt="Profile Picture" class="img-circle img-thumbnail" width="32" height="32" title="My Profile">		
							<strong><?= isset(who_am_i()->profile->first_name) ? who_am_i()->profile->first_name : 'Unknown Name' ?></strong>
							<span class="caret"></span>
						</a>
						<ul id="user-menu" class="dropdown-menu">						
							<li class="mobile-menu<?= uri_string() == 'profile/view' ? ' active' : '' ?>"><a href="<?= site_url('profile/view') ?>"><span class="fa fa-fw fa-user"></span>View My Profile</a></li>
							<li role="separator" class="divider"></li>
							<li class="mobile-menu<?= uri_string() == 'messages/report' ? ' active' : '' ?>"><a href="<?= site_url('messages/report') ?>"><span class="fa fa-fw fa-comment"></span>My Conversations</a></li>
							<li class="mobile-menu<?= uri_string() == 'users/skipped' ? ' active' : '' ?>"><a href="<?= site_url('users/skipped') ?>"><span class="fa fa-fw fa-undo"></span>Users I've Skipped</a></li>
							<li class="mobile-menu<?= uri_string() == 'users/blocked' ? ' active' : '' ?>"><a href="<?= site_url('users/blocked') ?>"><span class="fa fa-fw fa-user-times"></span>Users I've Muted</a></li>
						</ul>
					</li>		
				</ul>

							
			</div>
		<?php endif ?>

		
	</div>
</nav>