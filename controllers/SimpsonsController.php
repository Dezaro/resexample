<?php

class SimpsonsController extends Controller {

  public function indexAction($id, $name) {
    $obj = (object) $_GET;
    var_dump($obj);
    $statusCode = 200;
    $rawData = json_encode(array(
        'id' => $id,
        'name' => $name
    ));
    $this->setRequestContentType($statusCode, $rawData);
  }

  public function postAction() {
    $obj = (object) $_POST;
//    var_dump($obj);
    $statusCode = 200;
    $rawData = json_encode(array(
        'succes' => true,
        'data' => $obj->name
    ));
    $this->setRequestContentType($statusCode, $rawData);
  }

  public function allSimpsonsAction() {
    $simpsons = new Simpsons();
    $rawData = $simpsons->getAll();
    if(empty($rawData)) {
      $statusCode = 404;
      $rawData = array('error' => 'No Simpsons found!');
    } else {
      $statusCode = 200;
    }
    $this->setRequestContentType($statusCode, $rawData);
  }

}
