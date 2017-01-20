<div id="advanced-search" class="spaced">

	<div class="h2">Advanced Search</div>

	<p>
		All words are matched on unless separated by <strong>OR</strong>.
		Encapsulate exact match phrases in "quotes".
	</p>
		
	<form action="<?= site_url('users/search') ?>" class="form-horizontal" role="search">
		<div class="form-group">
			<div class="col-sm-8">
				<input id="first-name" type="search" name="first_name" class="form-control" placeholder="First Name" value="<?= $this->input->get('first_name') ?>">
			</div>
			<div class="col-sm-4">
				<select id="weight-first-name" name="weight_first_name" class="form-control">
					<option value="1">Rank with Low Priority</option>
					<option value="5" selected>Rank with Medium Priority</option>
					<option value="10">Rank with High Priority</option>
				</select>
            </div>
		</div>
		<div class="form-group">
			<div class="col-sm-8">
				<input id="last-name" type="search" name="last_name" class="form-control" placeholder="Last Name" value="<?= $this->input->get('last_name') ?>">
			</div>
			<div class="col-sm-4">
				<select id="weight-last-name" name="weight_last_name" class="form-control">
					<option value="1">Rank with Low Priority</option>
					<option value="5" selected>Rank with Medium Priority</option>
					<option value="10">Rank with High Priority</option>
				</select>
            </div>
		</div>
		<div class="form-group">
			<div class="col-sm-8">
				<input id="headline" type="search" name="headline" class="form-control" placeholder="Headline" value="<?= $this->input->get('headline') ?>">
			</div>
			<div class="col-sm-4">
				<select id="weight-headline" name="weight_headline" class="form-control">
					<option value="1">Rank with Low Priority</option>
					<option value="5" selected>Rank with Medium Priority</option>
					<option value="10">Rank with High Priority</option>
				</select>
            </div>
		</div>
		<div class="form-group">
			<div class="col-sm-8">
				<input id="pitch" type="search" name="pitch" class="form-control" placeholder="Pitch" value="<?= $this->input->get('pitch') ?>">
			</div>
			<div class="col-sm-4">
				<select id="weight-pitch" name="weight_pitch" class="form-control">
					<option value="1">Rank with Low Priority</option>
					<option value="5" selected>Rank with Medium Priority</option>
					<option value="10">Rank with High Priority</option>
				</select>
            </div>
		</div>
		<div class="form-group">
			<div class="col-sm-8">
				<input id="city" type="search" name="city" class="form-control" placeholder="City" value="<?= $this->input->get('city') ?>">
			</div>
			<div class="col-sm-4">
				<select id="weight-city" name="weight_city" class="form-control">
					<option value="1">Rank with Low Priority</option>
					<option value="5" selected>Rank with Medium Priority</option>
					<option value="10">Rank with High Priority</option>
				</select>
            </div>
		</div>
		<div class="form-group">
			<div class="col-sm-8">
				<input id="region" type="search" name="region" class="form-control" placeholder="Region" value="<?= $this->input->get('region') ?>">
			</div>
			<div class="col-sm-4">
				<select id="weight-region" name="weight_region" class="form-control">
					<option value="1">Rank with Low Priority</option>
					<option value="5" selected>Rank with Medium Priority</option>
					<option value="10">Rank with High Priority</option>
				</select>
            </div>
		</div>
		<div class="form-group">
			<div class="col-sm-8">
				<input id="country" type="search" name="country" class="form-control" placeholder="Country" value="<?= $this->input->get('country') ?>">
			</div>
			<div class="col-sm-4">
				<select id="weight-country" name="weight_country" class="form-control">
					<option value="1">Rank with Low Priority</option>
					<option value="5" selected>Rank with Medium Priority</option>
					<option value="10">Rank with High Priority</option>
				</select>
            </div>
		</div>
		<div class="form-group">
			<div class="col-sm-8">
				<input id="tags" type="search" name="metadata_tags" class="form-control" placeholder="Skills and Interests Tags" value="<?= $this->input->get('metadata_tags') ?>">
			</div>
			<div class="col-sm-4">
				<select id="weight-metadata-tags" name="weight_metadata_tags" class="form-control">
					<option value="1">Rank with Low Priority</option>
					<option value="5" selected>Rank with Medium Priority</option>
					<option value="10">Rank with High Priority</option>
				</select>
            </div>
		</div>
		<button type="submit" class="btn btn-primary"><span class="fa fa-search fa-fw" aria-hidden="true"></span>Advanced Search</button>
	</form>			
		
</div>