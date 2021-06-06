<?php
include 'includes/header.php';
?>

<div class="jumbotron jumbotron-fluid text-white">
	<div class="container text-center">
		<h1 class="display-1"><b>ようこそ</b></h1>
		<h2 class="display-1"><p class="lead">B R U H ( *︾▽︾)</p></h2>
		<a href="post.php" class="btn btn-outline-light col-6">Visit Post Gallery</a>
		<p class="num-posts"></p>
	</div>
</div>

<div class="container">
	<?php if (isset($_GET['login'])) : ?>
		<div class="alert alert-success" role="alert">
			You have logged in successfully!
		</div>
	<?php elseif (isset($_GET['logout'])) : ?>
		<div class="alert alert-warning" role="alert">
			You have logged out successfully!
		</div>
	<?php endif; ?>
</div>



<div class="container">

	<div class="row card-container">
		<h2>INSTRUCTION</h2>
		<p>To appreciate my beautiful website post gallery. First, you register, then click on the visit gallery box in the middle of my page jumbotron. However, if you already have an account, log in and enjoy.</p>
	</div>

</div>

<?php
include 'includes/footer.php';
?>