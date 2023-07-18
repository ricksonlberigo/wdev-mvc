<?php

use App\Controller\Pages\Home;

require_once __DIR__ . "/vendor/autoload.php";

$home = Home::getHome();
echo $home;
