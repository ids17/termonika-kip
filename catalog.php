<?php

require_once 'catalog_vars.php';

$catalog_vars[0] = $design_sidebar;
@$catalog_vars[1] = $breadcrumbs;
@$catalog_vars[2] = $divs;

$content = chunk($catalog_vars,'php/catalog_template.php');
if (isset($_GET['ajax'])) {
    echo $content;
} else {
    include_once 'layout.php';
}