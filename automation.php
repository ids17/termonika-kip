<?php

require_once 'php/template.php';

$content = chunk('','php/automation_template.php');
if (isset($_GET['ajax'])) {
    echo $content;
} else {
    include_once 'layout.php';
}