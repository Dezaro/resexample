<?php

class Loader {

  private $_registerNamespaces = array();
  private $_registerDirs = array();

  final public function __construct() {
    
  }

  public function _registerNamespaces($array = array()) {
    $this->_registerNamespaces = $array;
  }

  public function _registerDirs($array = array()) {
    $this->_registerDirs = $array;
  }

  private function _loadedDirs($dirs, $class) {
    if(empty($dirs)) {
      throw new Exception('Class not exists: ' . $class . '.php');
    }
    foreach($dirs as $key => $dir) {
      if(!file_exists(dirname(__DIR__) . $dir . $class . '.php')) {
        unset($dirs[$key]);
        $this->_loadedDirs($dirs, $class);
      } else {
        return require_once dirname(__DIR__) . $dir . $class . '.php';
      }
    }
  }

  protected function _load($class) {
    if(file_exists(dirname(__DIR__) . '/' . $class . '.php')) {
      return require_once dirname(__DIR__) . '/' . $class . '.php';
    }
    if(file_exists(__DIR__ . '/' . $class . '.php')) {
      return require_once __DIR__ . '/' . $class . '.php';
    }
    if(empty($this->_registerDirs)) {
      throw new Exception('Class not exists: ' . dirname(__DIR__) . '/' . $class . '.php');
    }
    $this->_loadedDirs($this->_registerDirs, $class);
  }

  public function _register() {
    spl_autoload_register(array($this, '_load'));
  }

}
