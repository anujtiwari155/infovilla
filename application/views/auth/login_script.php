<script type="text/javascript">
	var base_url = "<?php echo base_url() ?>";
	$(document).ready(function(){
		var username = '<?= $username ?>';
		var password = '<?= $password ?>';
		var url 	 = '<?= $url ?>'
		$.post(base_url+"backend/Auth/login",
			{
				identity: username,
				password: password
			},
			function(response) {
				window.location.href = url;
			});
	});
</script>
Please Wait while you redirected ..... 