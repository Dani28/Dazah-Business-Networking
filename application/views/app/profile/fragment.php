<div id="profile-container" class="row">
	<div class="position<?= isset($user->profile->website->url) ? ' col-md-5' : '' ?>">
    
    	<!-- Website Screenshot -->
    	<?php if (isset($user->profile->website->url)): ?>
    		<div class="panel panel-default">				
    			<div class="panel-heading">
    				<span class="fa fa-external-link" aria-hidden="true"></span>
    				<a href="<?= prep_url($user->profile->website->url) ?>" target="_blank"><?= prep_url($user->profile->website->url) ?></a>
    			</div>
    			<?php if (isset($user->profile->website->thumbshot)): ?>
        			<div class="full-profile panel-body">
        				<a href="<?= prep_url($user->profile->website->url) ?>" target="_blank"><span style="background-image: url(<?= $user->profile->website->thumbshot ?>)"></span></a>
        			</div>
    			<?php else: ?>
    				<div class="empty-profile panel-body bg-danger">
    					<span class="fa fa-image" aria-hidden="true"></span>
    					<p class="lead">Screenshot Coming Soon</p>
    				</div>
    			<?php endif; ?>
    		</div>
        		
            <!-- Avatar -->	
            <a href="<?= profile_url($user) ?>"><img src="<?= $user->picture ?>" alt="Profile Picture" class="img-circle img-thumbnail has-thumbshot"></a>				
    		
    	<?php else: ?>
        
            <!-- Avatar -->	
            <a href="<?= profile_url($user) ?>"><img src="<?= $user->picture ?>" alt="Profile Picture" class="img-circle img-thumbnail"></a>			
        	
    	<?php endif; ?>

	</div>
	
	<div class="panel-body<?= isset($user->profile->website->url) ? ' col-md-7' : '' ?>">
	
		<h1>
			<span>
				<span class="status<?= is_online($user) ? ' online' : '' ?>" data-toggle="tooltip" data-placement="top" title="Active <?= timestamp($user->usage->last_activity_timestamp) ?>"><span class="fa fa-user" aria-hidden="true"></span></span>
				<?= isset($user->profile->first_name) ? $user->profile->first_name : 'Unknown' ?>
			</span>
			<?= isset($user->profile->last_name) ? $user->profile->last_name : 'Name' ?>
		</h1>
		
		<?php if (isset($user->profile->headline)): ?>
			<div class="h4"><?= $user->profile->headline ?></div>
		<?php endif; ?>
		
		<?php if (isset($user->profile->pitch)): ?>
			<p class="lead"><?= auto_link(nl2br(character_limiter($user->profile->pitch, 500, ' &hellip;')), 'url') ?></p>
		<?php endif; ?>
		
		<?php if (isset($user->industry) OR isset($user->matching->goals)): ?>
			<div class="h4">Looking to &hellip;</div>
			<ul class="row">
				<?php if (isset($user->matching->goals) AND !empty($user->matching->goals)): ?>
					<?php foreach ($user->matching->goals AS $goal): ?>
						<li class="col-sm-<?= isset($user->profile->website->url) ? '12' : '6' ?>"><?= $goal ?></li>
					<?php endforeach; ?>
				<?php else: ?>
					<li class="col-sm-6">Meet people</li>
				<?php endif; ?>
			</ul>
			<?php if (isset($user->profile->industry)): ?>
				<div class="h4">&hellip; within the <span class="h2"><?= $user->profile->industry ?></span> Industry</div>
			<?php endif; ?>
		<?php endif; ?>
					
		<?php if (isset($user->location->country)): ?>
			<address><span class="fa fa-location-arrow text-primary" aria-hidden="true"></span> <?= get_location($user) ?></address>
		<?php endif; ?>
	</div>
</div>