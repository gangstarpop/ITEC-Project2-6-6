
<?php
include 'includes/header.php';
$msg = "";


if (isset($_POST['upload_image'])) {

	$sql = "SELECT * FROM users WHERE user_name = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("s", $_SESSION['user_name']);
	$stmt->execute();
	$results = $stmt->get_result();
	$user_row = $results->fetch_assoc();

	$filename = $user_row['user_name'] . "_" . $_FILES["uploadfile"]["name"];
	$tempname = $_FILES["uploadfile"]["tmp_name"];
	$folder = "uploads/" . $filename;
	$user_id = $user_row['ID'];


	$sql = "UPDATE profiles SET avatar = '" . $folder . "' WHERE user_id = " . $user_id;
	$stmt = $conn->query($sql);

	echo $sql;

	if (move_uploaded_file($tempname, $folder)) {
		$msg = "Image uploaded successfully";
		$_SESSION['avatar'] = $folder;
		header("Location: profile.php?upload_image=success");
	} else {
		$msg = "Failed to upload image";
	}
}

$sql = "SELECT * FROM profiles WHERE user_id = " . $_SESSION['user_id'];
$stmt = $conn->prepare($sql);
$stmt->execute();
$profile = $stmt->get_result()->fetch_assoc();
?>


<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>


<?php if (isset($_GET['update'])) : ?>
	<div class="alert alert-success" role="alert">
		You have updated profile successfully!
	</div>
<?php elseif (isset($_GET['upload_image'])) : ?>
	<div class="alert alert-warning" role="alert">
		You have upload avatar image successfully!
	</div>
<?php endif; ?>

<div class="container bootstrap snippet">

	<div class="row">


		<div class="col-sm-3">

			<div class="text-center">
				<img style="width: 100%; height: 100%;" src=<?= isset($profile['avatar']) ?
								$profile['avatar'] : "http://ssl.gstatic.com/accounts/ui/avatar_2x.png" ?> 
								class="avatar img-circle img-thumbnail" alt="avatar">

				<h6>Upload a different photo...</h6>
				<form action='profile.php' method='post' enctype='multipart/form-data'>
					<input type="file" name="uploadfile" class="text-center center-block file-upload" required="required">
					<button class="btn btn-primary btn-block mt-2" type='submit' name='upload_image'>Upload Avatar</button>
				</form>

			</div>
			</hr><br />

			<ul class="list-group">
				<li class="list-group-item text-muted">Activity <i class="fa fa-dashboard fa-1x"></i></li>
				<li class="list-group-item text-right"><span class="pull-left"><strong>Comment</strong></span> 125</li>
				<li class="list-group-item text-right"><span class="pull-left"><strong>Likes</strong></span> 13</li>
				<li class="list-group-item text-right"><span class="pull-left"><strong>Posts</strong></span> 37</li>
			</ul>

		</div>



		<div class="col-sm-9 mt-4">
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#home">Home</a></li>
			</ul>

			<div class="tab-content">
				<div class="tab-pane active" id="home">

					<form class="form" action="##" method="post" id="registrationForm">
						<div class="form-group">
							<div class="col-lg-6 col-md-6 col-xs-12">
								<label for="username">
									<h4>Username</h4>
								</label>
								<input disabled="disabled" type="text" class="form-control" name="username" id="username" value="<?= $_SESSION['user_name'] ?>">
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-6 col-md-6 col-xs-12">
								<label for="email">
									<h4>Email</h4>
								</label>
								<input disabled="disabled" type="email" class="form-control" name="email" id="email" value="<?= $_SESSION['user_email'] ?>">
							</div>
						</div>

						<div class="form-group">
							<div class="col-xs-6">
								<label for="phone">
									<h4>Phone Number</h4>
								</label>
								<input type="number" class="form-control" name="phone" id="phone" value="<?= $profile['phone'] ?>">
							</div>
						</div>

						<div class="form-group">
							<div class="col-xs-6">
								<label for="birth">
									<h4>Birthday</h4>
								</label>
								<input type="date" class="form-control" name="birth" id="birth" value="<?= $profile['birth'] ?>">
							</div>
						</div>

						<div class="form-group">

							<div class="col-xs-6">
								<label for="second_email">
									<h4>Email</h4>
								</label>
								<input type="text" disabled='disabled' class="form-control" name="second_email" id="second_email" value="<?= $_SESSION['user_role'] == 1 ? "Admin" : "User"  ?>">
							</div>
						</div>

						<div class="form-group">

							<div class="col-xs-6">
								<label for="location">
									<h4>Location</h4>
								</label>
								<input type="text" class="form-control" id="location" value="<?= $profile['location'] ?>">
							</div>
						</div>

						<div class="form-group">

							<div class="col-12">
								<label for="bio">
									<h4>Introduction</h4>
								</label>
								<script>
									tinymce.init({
										selector: '#mytextarea',
										height: 200,
										menubar: false,
										plugins: [
											'advlist autolink lists link image charmap print preview anchor',
											'searchreplace visualblocks code fullscreen',
											'insertdatetime media table paste code help wordcount'
										],
										toolbar: 'undo redo | formatselect | ' +
											'bold italic backcolor | alignleft aligncenter ' +
											'alignright alignjustify | bullist numlist outdent indent | ' +
											'removeformat | help',
										content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
									});
								</script>
								<textarea id="mytextarea" class="form-control" name="bio" id="bio" rows="4" cols="80">

								</textarea>
							</div>
						</div>

						<div class="form-group">
							<div class="col-xs-12">
								<br>
								<button class="btn btn-lg btn-success" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Save</button>
								<button class="btn btn-lg" type="reset"><i class="glyphicon glyphicon-repeat"></i> Reset</button>
							</div>
						</div>
					</form>
					<hr>

				</div>
			</div>

		</div>


	</div>

</div>


<script>
	$(document).ready(function() {

		var readURL = function(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();

				reader.onload = function(e) {
					$('.avatar').attr('src', e.target.result);
				}

				reader.readAsDataURL(input.files[0]);
			}
		}

		$(".file-upload").on('change', function() {
			readURL(this);
		});
	});
</script>


<?php
include 'includes/footer.php';
?>
