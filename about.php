<?php

require_once 'php/template.php';

$page_title = 'О нас';

$content = chunk('','php/about_template.php');
if (isset($_GET['ajax'])) {
    echo $content;
} else {
    include_once 'layout.php';
}