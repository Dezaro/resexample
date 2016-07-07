<?php

require_once "./Simpsons.php";

require_once "./SimpleRest.php";

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SimpsonsRestHandler
 *
 * @author Dezaro
 */
class SimpsonsRestHandler extends SimpleRest {

  private function setRequestContentType($statusCode, $data) {
    $requestContentType = $_SERVER['HTTP_ACCEPT'];
    $this->setHttpHeaders($requestContentType, $statusCode);
    if(strpos($requestContentType, 'application/json') !== false) {
      echo $data;
    }
  }

  public function getAllSimpsons() {
    $simpsons = new Simpsons();
    $rawData = $simpsons->getAll();
    if(empty($rawData)) {
      $statusCode = 404;
      $rawData = array('error' => 'No mobiles found!');
    } else {
      $statusCode = 200;
    }
    $this->setRequestContentType($statusCode, $rawData);
  }

}
