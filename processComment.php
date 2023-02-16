<?php
require __DIR__ . '/db.php';
session_start();

if(isset($_POST['pid'])){
    $_SESSION['cid'] = $_POST['pid'];
}

if(isset($_POST['action']) && $_POST['action'] == 'comment'){
    $comment = $_POST['comment'];
    $pid = $_POST['pid'];
    $user_id = $_POST['user_id'];
    if(addComment($pid, $comment,  $user_id)){
        echo "kommentar postad!";
    }
}

if(isset($_POST['action']) && $_POST['action'] == 'deleteComment'){
    deleteCommentById($_POST['cmt_id']);
    echo('Kommentar borttagen!');
}
?>