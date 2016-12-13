<?php

class Router {

  private $_routes = array(
      'GET' => array(),
      'POST' => array()
  );

  final public function __construct() {
    
  }

  private function _identicalValues($arrayA = array(), $arrayB = array()) {
    sort($arrayA);
    sort($arrayB);
    return $arrayA === $arrayB;
  }

  private function _getParams($array = array()) {
    $params = array();
    $params['params'] = array();
    $params['path'] = array();
    foreach($array as $element) {
      $len = strlen($element) - 1;
      if($element[0] === '{' && $element[$len] === '}') {
        $n = strpos($element, ':') - 1;
        if($n !== -1) {
          $name = substr($element, 1, $n);
          $type = substr($element, $n + 2, $len - 4);
          $params['params'][$name] = $type;
        } else {
          $name = substr($element, 1, $len - 1);
          $type = '[a-zA-Z0-9 _*#]+$';
          $params['params'][$name] = $type;
        }
      } else {
        $params['path'][] = $element;
      }
    }
    return $params;
  }

  private function _invoke($class, $action, $urlParams) {
    $class = $class . 'Controller';
    $action = $action . 'Action';
    $call = new $class;
    $arguments = new ReflectionMethod($class, $action);
    $parameters = $arguments->getParameters();
    $invokeArgs = array();
    foreach($parameters as $param) {
      if(!array_key_exists($param->name, $urlParams)) {
        $invokeArgs[$param->name] = null;
        continue;
      }
      $invokeArgs[] = $urlParams[$param->name];
    }
    $arguments->invokeArgs($call, $invokeArgs);
  }

  public function _addGet($url, $callback = array()) {
    $_urlRequest = explode('/', $url);
    $_urlRequest = array_filter($_urlRequest);
    $urlParams = $this->_getParams($_urlRequest);
    $this->_routes['GET'][] = array(
        'url' => $url,
        'urlExplode' => $_urlRequest,
        'callback' => $callback,
        'urlOutParams' => $urlParams['path'],
        'urlParams' => $urlParams['params'],
        'paramsCount' => count($urlParams['params'])
    );
  }

  public function _addPost($url, $callback = array()) {
    $_urlRequest = explode('/', $url);
    $_urlRequest = array_filter($_urlRequest);
    $urlParams = $this->_getParams($_urlRequest);
    $this->_routes['POST'][] = array(
        'url' => $url,
        'urlExplode' => $_urlRequest,
        'callback' => $callback,
        'urlOutParams' => $urlParams['path'],
        'urlParams' => $urlParams['params'],
        'paramsCount' => count($urlParams['params'])
    );
  }

  public function execute() {
    $_urlMethod = $_SERVER['REQUEST_METHOD'];
    $_urlRequest = $_GET['_url'];
    $_urlExplode = explode('/', $_urlRequest);
    $_urlExplode = array_filter($_urlExplode);
    $_urlParams = $this->_getParams($_urlExplode);
    $_exists = true;

    if(!array_key_exists($_urlMethod, $this->_routes)) {
      throw new Exception('Services route not found!');
    }

    foreach($this->_routes[$_urlMethod] as $route) {
      if(count($_urlExplode) === count($route['urlExplode'])) {
        $n = count($route['urlOutParams']);
        $tempA = array();
        $tempB = array();
        for($i = 0; $i <= $n - 1; ++$i) {
          $tempA[] = $_urlParams['path'][$i];
        }
        for($i = $n; $i <= (count($_urlExplode) - 1); ++$i) {
          $tempB[] = $_urlParams['path'][$i];
        }
        if($this->_identicalValues($route['urlOutParams'], $tempA)) {
          if($route['paramsCount'] === count($tempB)) {
            $j = 0;
            foreach($route['urlParams'] as $key => $name) {
              if(!preg_match('/' . $name . '/', $tempB[$j])) {
                throw new Exception('Services params is not in correct format!');
              } else {
                $tempB[$key] = $tempB[$j];
                unset($tempB[$j]);
              }
              ++$j;
            }
            return $this->_invoke($route['callback']['controller'], $route['callback']['action'], $tempB);
          }
        }
      } else {
        $_exists = false;
      }
    }

    if(!$_exists) {
      throw new Exception('The required service Not Found!');
    }
  }

}
