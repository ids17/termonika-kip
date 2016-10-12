<?php

require_once 'php/template.php';

$page_title = 'Контакты';

$content = chunk('','php/contacts_template.php');
if (isset($_GET['ajax'])) {
    echo $content;
} else {
    include_once 'layout.php';
}
