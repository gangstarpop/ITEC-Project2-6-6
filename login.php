<?php
include 'includes/header.php';
include 'func/account.php';
?>

<style>
	/* The flip card container - set the width and height to whatever you want. We have added the border property to demonstrate that the flip itself goes out of the box on hover (remove perspective if you don't want the 3D effect */
	.flip-card {
		background-color: transparent;
		width: 35vw;
		height: 70vh;
		perspective: 1000px;
		/* Remove this if you don't want the 3D effect */
	}

	/* This container is needed to position the front and back side */
	.flip-card-inner {
		position: relative;
		width: 100%;
		height: 100%;
		transition: transform 0.8s;
		transform-style: preserve-3d;
	}

	/* Do an horizontal flip when you move the mouse over the flip box container */
	.flip-card:hover .flip-card-inner {
		transform: rotateY(180deg);
	}

	/* Position the front and back side */
	.flip-card-front,
	.flip-card-back {
		padding: 20px;
		position: absolute;
		width: 100%;
		height: 100%;
		-webkit-backface-visibility: hidden;
		border: 1px solid #aaa;
		border-radius: 10px;
		/* Safari */
		backface-visibility: hidden;
	}

	/* Style the front side (fallback if image is missing) */
	.flip-card-front {
		background-color: white;
	}

	/* Style the back side */
	.flip-card-back {
		background-color: white;
		transform: rotateY(180deg);
	}
</style>

<div class="container mt-3">


	<?php if (isset($errorMsg)) : ?>
		<div class="alert alert-danger" role="alert">
			<?php echo $errorMsg; ?>
		</div>
	<?php endif; ?>


	<div class="row">

		<div class="col-md-6">

			<div class="flip-card">
				<div class="flip-card-inner">
					<div class="flip-card-front">
						<h1 class='mb-4 text-center'>Register Section</h1>
						<img src="uploads/template-sticker-600x600.png" alt="Avatar" style=" border-radius: 50%; width: 80%; height: 80%; object-fit: cover;
						display: block; margin-left: auto; margin-right: auto;">
					</div>
					<div class="flip-card-back">
						<h3>Create a new account</h3>
						<hr>


						<form class="" action="login.php" method="post">

							<label for="username">Username</label>

							<input type="text" name="username" class="form-control" placeholder="Input your username..." value="<?= isset($username) ? htmlspecialchars($username) : '' ?>">

							<p class="error">
								<?php if (isset($errors['create_username'])) {
									echo $errors['create_username'];
								} ?>
							</p>

							<label for="email">Email</label>
							<input type="email" name="email" class="form-control" placeholder="Input your email..." value="
						<?php if (isset($email)) {
							echo htmlspecialchars($email);
						} ?>">

							<p class="error">
								<?php if (isset($errors['create_email'])) {
									echo $errors['create_email'];
								} ?>
							</p>

							<label for="password1">Password</label>
							<input type="password" name="password1" class="form-control" placeholder="Input your password..." value="">

							<p class="error"></p>

							<label for="password2">Confirm Password</label>
							<input type="password" name="password2" class="form-control" placeholder="Input your confirm password..." value="">
							<p class="error">
								<?php if (isset($errors['create_password'])) {
									echo $errors['create_password'];
								} ?>
							</p>
							<button type="submit" name="create" class="btn btn-outline-primary btn-block">Create Account</button>

						</form>
					</div>
				</div>
			</div>




		</div>

		<div class="col-md-6">
			<div class="flip-card">
				<div class="flip-card-inner">
					<div class="flip-card-front">
						<h1 class='mb-4 text-center'>Login Section</h1>
						<img class='text-center' src="uploads/noooo.jpg" alt="Avatar" style="border-radius: 50%; width: 80%; height: 80%; object-fit: cover;
						display: block; margin-left: auto; margin-right: auto;">
					</div>
					<div class="flip-card-back">
						<h3>Login</h3>
						<hr>
						<form class="" action="login.php" method="post">
							<label for="username">Username</label>
							<input type="text" name="username" class="form-control" placeholder="Input your username..." value="<?= isset($username) ? htmlspecialchars($username) : '' ?>">
							<p class="error">
								<?php if (isset($errors['login_username'])) {
									echo $errors['login_username'];
								} ?>
							</p>

							<label for="password">Password</label>
							<input type="password" name="password" class="form-control" placeholder="Input your username..." value="">

							<p class="error">
								<?php if (isset($errors['login_password'])) {
									echo $errors['login_password'];
								} ?>
							</p>
							<button type="submit" name="login" class="btn btn-outline-primary btn-block">Login</button>
						</form>
					</div>
				</div>
			</div>



		</div>

	</div>
</div>

<?php
include 'includes/footer.php';
?>