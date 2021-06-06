<?php
include 'includes/header.php';
$sql = "SELECT * FROM posts WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();

$sql = "SELECT * FROM users WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $post['post_author']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$sql = "SELECT * FROM comments WHERE post_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $post['ID']);
$stmt->execute();
$comments = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

if (isset($_POST['delete'])) {
    $sql = "DELETE FROM posts WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_POST['post_id']);
    $stmt->execute();
    header("Location: post.php?delete=true");
}

?>

<?php if ($_SESSION['loggedin'] == false) : ?>
	<div class="mt-5 col-md-6 offset-md-3 text-center">
		<h2 class="display-5">Please Login to Continue!</h2>
		<p>Create an account or login to post to the website.</p>
		<img style="width: 100%; height: 300px; object-fit: contain;" alt="warning"
		 src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/17/Warning.svg/832px-Warning.svg.png"> 
		<button type="button" class="btn btn-block btn-secondary"><a href="login.php"><i class="fas fa-sign-in-alt"></i> Create Account/Login</a> </button>
	</div>
<?php else : ?>

<head>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <link href="css/star-rating.css" media="all" rel="stylesheet" type="text/css" />
    <link href="js/themes/krajee-fas/theme.css" media="all" rel="stylesheet" type="text/css" />
    <link href="js/themes/krajee-svg/theme.css" media="all" rel="stylesheet" type="text/css" />
    <!--suppress JSUnresolvedLibraryURL -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="js/star-rating.js" type="text/javascript"></script>
    <script src="js/themes/krajee-fas/theme.js" type="text/javascript"></script>
    <script src="js/themes/krajee-svg/theme.js" type="text/javascript"></script>
</head>


<div class="container mt-5">
    <div class="row">
        <div class="col-lg-8">

            <article class="card-container">

                <header class="mb-4">

                    <h1 class="fw-bolder mb-1"><?= $post['post_title'] ?></h1>

                    <div class="text-muted fst-italic mb-2">Posted on <?= $post['date_created'] ?> by <?= $user['user_name'] ?></div>

                </header>

                <figure class="mb-4"><img class="img-fluid rounded" id="img" style="width:100%" src="<?= isset($post['post_img']) ? $post['post_img'] : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRoHhdu40aqjl3dPGWSIZmVPxeWuSjnhFOmIw&usqp=CAU' ?>" alt="..." /></figure>
                <section class="mb-5">
                    <p class="fs-5 mb-4" id="body"><?= $post['post_body'] ?></p>
                </section>
            </article>

            <div class="card-container mt-4 mb-4">
                <form action="func/rating.php" method="post" id="rating_form">
                    <div class='row'>
                        <div class='col-6'>
                            <input type="hidden" name="post_id" value="<?= $post["ID"] ?>">
                            <input id="kartik" class="rating" data-stars="5" name="rating" data-step="0.5" value="<?= isset($post['rating']) ? $post['rating'] : 0 ?>" />
                        </div>
                        <div class='col-3 mt-2'>
                            <button type="submit" class='btn btn-outline-primary btn-block'>Rating</button>
                        </div>
                        <div class='col-3 mt-2'>
                            <button type="reset" class="btn btn-outline-secondary btn-block">Reset</button>
                        </div>
                    </div>
                </form>
            </div>

            <section class="mb-5">
                <div class="card bg-light">
                    <div class="card-body">

                        <form class="mb-4" action="func/comment.php" method="post">
                            <input type="hidden" name="post_id" value="<?= $post["ID"] ?>">
                            <textarea id='comment_content' name='comment_content' class="form-control" rows="3" placeholder="Join the discussion and leave a comment!" required=required></textarea>
                            <button class='btn btn-outline-primary btn-block' id="comment_submit" type="submit" name="comment">Comment</button>
                        </form>

                        <div id='comment-holder'>

                            <?php
                            foreach ($comments as $comment) {
                                $sql = "SELECT * FROM users WHERE ID = ?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("i", $comment['user_id']);
                                $stmt->execute();
                                $commenter = $stmt->get_result()->fetch_assoc();

                                $sql = "SELECT avatar FROM profiles WHERE user_id = ?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("i", $comment['user_id']);
                                $stmt->execute();
                                $profile = $stmt->get_result()->fetch_assoc();
                            ?>
                                <!-- Single comment-->
                                <div class="d-flex">
                                    <div class="flex-shrink-0 mr-2">
                                        <img class="rounded-circle" style="width : 50px; height : 50px; object-fit: fill" src="<?= isset($profile["avatar"]) ? $profile["avatar"] : 'https://dummyimage.com/50x50/ced4da/6c757d.jpg' ?>" alt="..." />
                                    </div>
                                    <div class="ms-3">
                                        <div class="fw-bold"><?= $commenter['user_name'] ?></div>
                                        <p><?= $comment['content'] ?></p>
                                    </div>
                                </div>

                                <hr />
                            <?php } ?>
                        </div>

                    </div>
                </div>
            </section>
        </div>

        <div class="col-lg-4 mt-4">

            <!-- Admin widget-->
            <?php if ($_SESSION['user_role'] == 1) : ?>
                <div class="card mb-4">
                    <div class="card-header">Admin Panel</div>
                    <div class="card-body">
                        <div class="input-group">
                            <form action="post_detail.php" method="post" class='form-inline' style="width: 100%;">
                                <input type="hidden" name="post_id" value="<?= $post["ID"] ?>">
                                <div class='col-6' style="padding:2px">
                                    <a class="btn btn-outline-primary btn-block" href="#" role="button">Update Post</a>
                                </div>

                                <div class='col-6' style="padding:2px">
                                    <button type="submit" name="delete" class="btn btn-outline-danger btn-block" id="button-search" type="button">Delete Post</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Search widget-->
            <div class="card mb-4">
                <div class="card-header">Search</div>
                <div class="card-body">
                    <div class="input-group">
                        <input class="form-control" type="text" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search" />
                        <button class="btn btn-primary" id="button-search" type="button">Go!</button>
                    </div>
                </div>
            </div>
            <!-- Categories widget-->
            <div class="card mb-4">
                <div class="card-header">Categories</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <ul class="list-unstyled mb-0">
                                <li><a href="#!">Web Design</a></li>
                                <li><a href="#!">HTML</a></li>
                                <li><a href="#!">Freebies</a></li>
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <ul class="list-unstyled mb-0">
                                <li><a href="#!">JavaScript</a></li>
                                <li><a href="#!">CSS</a></li>
                                <li><a href="#!">Tutorials</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php
include 'includes/footer.php';
?>