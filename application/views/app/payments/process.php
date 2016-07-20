<?= $header ?>
	<title>Process Payment | Dazah</title>
</head>
<body id="web-app">
	
<?= $menu ?>

<div class="container">
	<div class="row">
				
		<div class="col-xs-12">		
			<div class="h1 text-center">
				<div class="spaced">Processing Payment</div>
				<span class="fa fa-spinner fa-spin fa-5x" aria-hidden="true"></span>
				<div class="lead spaced">It may take a few minutes for us to verify payment.</div>
			</div>
		</div>
		
	</div>
	
</div>

<script type="text/javascript">
$.post('<?= site_url('app/payments/js_process') ?>', {id: <?= $user_id ?>}, function(data) {
	if (data.url)
	{
		$(location).attr('href', data.url);
	}
});
</script>
		
<?= $footer ?>