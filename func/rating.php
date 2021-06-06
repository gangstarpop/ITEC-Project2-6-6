<?php
include "../bootstrap.php";


if(isset($_POST['rating'])){
    $sql = "UPDATE posts SET rating = ".$_POST['rating']." WHERE ID = ".$_POST['post_id'];
    $results = $conn->query($sql);

    echo $sql;
}

header("Location: ../post_detail.php?id=".$_POST['post_id'] . "#body");
