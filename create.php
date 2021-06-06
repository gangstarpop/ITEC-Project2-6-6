<?php
include 'includes/header.php';
if (isset($_POST['submit'])) {
	$title = $_POST['title'];
	$body = $_POST['body'];
	if ($body != '' && $title != '') {

		$filename = $title . "_" . $_FILES["post_image"]["name"];
		$tempname = $_FILES["post_image"]["tmp_name"];
		$folder = "uploads/posts/" . $filename;


		$sql = "INSERT INTO posts (post_title, post_body, post_author, post_img) VALUES (?,?,?,?)";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("ssis", $title, $body, $_SESSION['user_id'], $folder);
		$stmt->execute();

		echo $sql;

		if (!move_uploaded_file($tempname, $folder)) {
			echo "Failed to upload image";
		}

		if ($stmt->affected_rows == 1) {
			$location = "Location: create.php?id=" . $stmt->insert_id . "&created=true";
			header($location);
		}
	} else {
		$errorMsg = "Please fill out all fields!";
	}
}

?>

<?php if (isset($_GET['created'])) : ?>
	<div class="alert alert-success" role="alert">
		You have created post successfully!
	</div>
<?php endif; ?>

<div class="container">

	<div class="row">
		<?php if ($_SESSION['loggedin'] == false) : ?>
			<div class="mt-5 col-md-6 offset-md-3 text-center">
				<h2 class="display-5">Please Login to continue!</h2>
				<p>Create an account or login to post to the website.</p>
				<img style="width: 100%; height: 300px; object-fit: contain;" alt="warning" src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/17/Warning.svg/832px-Warning.svg.png">
				<button type="button" class="btn btn-block btn-outline-primary"><a href="login.php"><i class="fas fa-sign-in-alt"></i> Create Account/Login</a> </button>
			</div>
		<?php else : ?>
			<div class="mt-3 col-md-10 offset-md-1 card-container">
				<?php if (isset($errorMsg)) : ?>
					<div class="alert alert-danger" role="alert">
						<?php echo $errorMsg; ?>
					</div>
				<?php endif; ?>
				<h2>Create a post~</h2>
				<form class="" action="create.php" method="post" enctype="multipart/form-data">
					<label for="title">Post Title</label>
					<input type="text" name="title" placeholder="Post title..." value="" class="form-control">

					<label for="post_img">Post Image</label>

					<div class="form-group">
						<input type="file" name="post_image" required="required" class="form-control mb-2" id="post_image" onchange="readURL(this);">
						<img id="blah" style="display: none" src="http://placehold.it/180" alt="your image" />

						<script>
							function readURL(input) {
								if (input.files && input.files[0]) {
									var reader = new FileReader();

									reader.onload = function(e) {
										$('#blah').attr('style', "max-height : 300px; max-width: 100%; display: block;");
										$('#blah').attr('src', e.target.result);
									};

									reader.readAsDataURL(input.files[0]);
								}
							}
						</script>
					</div>

					<label for="body">Post Content</label>
					<script>
						tinymce.init({
							selector: '#mytextarea',
							height: 300,
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
					<textarea id="mytextarea" name="body" class="form-control" rows="8" cols="80"></textarea>

					<button type="submit" name="submit" class="btn btn-outline-dark btn-block mt-2"> <i class="fas fa-edit"></i> Create Post</button>
				</form>
			</div>

		<?php endif; ?>
	</div>
</div>


<?php
include 'includes/footer.php';
?>