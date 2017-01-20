<?= $header ?>
	<title>Process Payment | Business Network</title>
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
$(function() {
	setTimeout(function() { check_for_payment(<?= $user_id ?>); }, 5000);
});
</script>
		
<?= $footer ?>