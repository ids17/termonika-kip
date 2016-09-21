<?php
    require_once 'template.php';
    require_once 'config.php';

    $id = substr($_POST['id'], 9);
    $comment = $_POST['comment'];
    changeCartComment($id, $comment);
?>