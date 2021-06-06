<?php
include "../bootstrap.php";

if (isset($_POST['comment'])) {
    $sql = "INSERT INTO comments (user_id, post_id, content) 
    VALUES (". $_SESSION['user_id'].",". $_POST['post_id'].",'". $_POST['comment_content']."')";
    $results = $conn->query($sql);

    echo $sql;
}

header("Location: ../post_detail.php?id=" . $_POST['post_id'] . "#body");
