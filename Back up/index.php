<?php 
	session_start();
	include 'include/head.php';
?>

<script type="text/javascript" src="script/functions.js">

	if (window.location == "http://localhost/11100/Farmer/Project/index.php?action=blog&msg=File%20uploaded%20Successfully%20..!") {
		alert('Post Added');
	}

</script>

<div id="content">
	<div class="content-wrapper">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<h2 align="center" id="msg"><?php echo $_GET['msg']??''; ?></h2><hr>
				</div>

			</div>
			<div class="row">
				<div class="col-12">
					<div class="w3-panel w3-blue w3-center">
					  <h1 class="w3-text-orange" style="text-shadow:1px 1px 0 #444">
					  	<img style="width: 150px;" src="logo.jpg" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
					  <b>Welcome To The Farmer Connection Site</b></h1>
					</div>
					<div class="w3-card w3-margin w3-padding">
						
					<?php include'slider/main.php'; ?>
		</div>
	</div>
	<div class="w3-card w3-margin w3-padding">
		
	<?php include'pages/kb.php'; ?>
	</div>
	<div class="w3-card w3-margin w3-padding">
		
	<?php include'pages/df.php'; ?>
	</div>
</div>
<?php
	include 'include/footer.php';
?>