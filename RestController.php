<?php

require_once "./SimpsonsRestHandler.php";


require_once("MobileRestHandler.php");

$mobileRestHandler = new MobileRestHandler();
$simpsonsRestHandler = new SimpsonsRestHandler();
$view = "";

if(isset($_GET["view"])) {
  $view = $_GET["view"];
}

/*
  controls the RESTful services
  URL mapping
 */
switch($view) {
  case "all":
    // to handle REST Url /mobile/list/
    $mobileRestHandler->getAllMobiles();
    break;
  case "simpsonsAll":
    // to handle REST Url /simpsons/all/
    $simpsonsRestHandler->getAllSimpsons();
    break;
  case "single":
    // to handle REST Url /mobile/show/<id>/
    $mobileRestHandler->getMobile($_GET["id"]);
    break;
  case "" :
    //404 - not found;
    break;
}
