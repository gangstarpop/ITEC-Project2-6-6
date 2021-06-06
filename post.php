<?php
include 'includes/header.php';
$sql = "SELECT * FROM posts";
$stmt = $conn->prepare($sql);
$stmt->execute();
$results = $stmt->get_result();
// echo "<pre>";
// var_dump($results->fetch_all());
// echo "</pre>"

?>

<?php if (isset($_GET['delete'])) : ?>
	<div class="alert alert-info" role="alert">
		You have deleted post successfully!
	</div>
<?php endif; ?>

<?php if ($_SESSION['loggedin'] == false) : ?>
	<div class="mt-5 col-md-6 offset-md-3 text-center">
		<h2 class="display-5">Please Login to Continue!</h2>
		<p>Create an account or login to post to the website.</p>
		<img style="width: 100%; height: 300px; object-fit: contain;" alt="warning"
		 src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/17/Warning.svg/832px-Warning.svg.png"> 
		<button type="button" class="btn btn-block btn-secondary"><a href="login.php"><i class="fas fa-sign-in-alt"></i> Create Account/Login</a> </button>
	</div>
<?php else : ?>

	<div class="jumbotron jumbotron-fluid text-white">
		<div class="container">
			<h1 class="display-3">Post Section</h1>
			<p class="lead">Enjoy the library of post and news</p>
			<a class="btn btn-outline-primary" href="create.php">
				<i class="fas fa-pen"> Create Post</i>
			</a>
			<p class="num-posts"></p>
		</div>
	</div>

	<div class="container">
		<div class='row'>
			<?php foreach ($results as $post) { ?>
				<div class="col-lg-4 col-md-6 col-sm-12">
					<div class="card">

						<div class="card-header">
							<h5><?= $post['post_title'] ?></h5>
						</div>
						<img class="card-img-top" style="max-width: 100%; height: 30vh; object-fit: cover" src="<?= isset($post['post_img']) ? $post['post_img'] :
																													'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRoHhdu40aqjl3dPGWSIZmVPxeWuSjnhFOmIw&usqp=CAU' ?>" alt="">
						<div class="card-body">
							<p class="card-text">Date created : <?= $post['date_created'] ?></p>
						</div>
						<div class="card-footer" style='padding : 0; margin: 0'>
							<a href="./post_detail.php?id=<?= $post['ID'] ?>" class="btn btn-outline-primary btn-block">See more</a>
						</div>
					</div>
				</div>
			<?php } ?>

		</div>
	</div>
<?php endif; ?>
<?php
include 'includes/footer.php';
?>