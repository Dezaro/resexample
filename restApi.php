<?php

require_once "system/Loader.php";

try {
  $loader = new Loader();
  $loader->_registerDirs(array(
      'folder' => '/system/folder/',
      'controller' => '/controllers/',
      'model' => '/models/'
  ));
  $loader->_register();

//  $total = new Total();
//  $total->_inFolder();

  $router = new Router();
  $router->_addGet('/simpsons/all/{id:^[0-9]+$}/{name}', array(
      'controller' => 'Simpsons',
      'action' => 'index'
  ));
  $router->_addGet('/simpsons/all', array(
      'controller' => 'Simpsons',
      'action' => 'allSimpsons'
  ));
  $router->_addPost('/simpsons/add', array(
      'controller' => 'Simpsons',
      'action' => 'post'
  ));
  $router->_addGet('/mobile/list', array(
      'controller' => 'Mobile',
      'action' => 'allMobiles'
  ));
  $router->_addGet('/mobile/{id:^[0-9]+$}', array(
      'controller' => 'Mobile',
      'action' => 'getMobile'
  ));
  $router->execute();
} catch(Exception $e) {
  print $e->getMessage();
}