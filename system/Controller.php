<?php

class Controller {

  private $httpVersion = "HTTP/1.1";
  private $httpStatus = array(
      100 => 'Continue',
      101 => 'Switching Protocols',
      200 => 'OK',
      201 => 'Created',
      202 => 'Accepted',
      203 => 'Non-Authoritative Information',
      204 => 'No Content',
      205 => 'Reset Content',
      206 => 'Partial Content',
      300 => 'Multiple Choices',
      301 => 'Moved Permanently',
      302 => 'Found',
      303 => 'See Other',
      304 => 'Not Modified',
      305 => 'Use Proxy',
      306 => '(Unused)',
      307 => 'Temporary Redirect',
      400 => 'Bad Request',
      401 => 'Unauthorized',
      402 => 'Payment Required',
      403 => 'Forbidden',
      404 => 'Not Found',
      405 => 'Method Not Allowed',
      406 => 'Not Acceptable',
      407 => 'Proxy Authentication Required',
      408 => 'Request Timeout',
      409 => 'Conflict',
      410 => 'Gone',
      411 => 'Length Required',
      412 => 'Precondition Failed',
      413 => 'Request Entity Too Large',
      414 => 'Request-URI Too Long',
      415 => 'Unsupported Media Type',
      416 => 'Requested Range Not Satisfiable',
      417 => 'Expectation Failed',
      500 => 'Internal Server Error',
      501 => 'Not Implemented',
      502 => 'Bad Gateway',
      503 => 'Service Unavailable',
      504 => 'Gateway Timeout',
      505 => 'HTTP Version Not Supported'
  );

  protected function setHttpHeaders($contentType, $statusCode) {
    $statusMessage = $this->getHttpStatusMessage($statusCode);
    header($this->httpVersion . " " . $statusCode . " " . $statusMessage);
    header("Content-Type: " . $contentType);
  }

  protected function getHttpStatusMessage($statusCode) {
    return ($this->httpStatus[$statusCode]) ? $this->httpStatus[$statusCode] : $this->httpStatus[500];
  }

  protected function recursion($arr = array(), $anon = null) {
    if($anon === null) {
      $anon = function ($key, $item) {
        print "$key => $item \n";
      };
    }
    foreach($arr as $key => $item) {
      if(is_array($item)) {
        $this->recursion($item, $anon);
      } else {
        $anon($key, $item);
      }
    }
  }

  protected function setRequestContentType($statusCode, $data) {
    $requestContentType = $_SERVER['HTTP_ACCEPT'];
    $this->setHttpHeaders($requestContentType, $statusCode);
    if(strpos($requestContentType, 'application/json') !== false) {
      print $data;
    }
    if(strpos($requestContentType, 'text/html') !== false) {
      print '<table border="1">';
      print '<tr><th>KEY</th><th>ITEM</th></tr>';
      $this->recursion(json_decode($data, true), function ($key, $item) {
        print '<tr><td>' . $key . '</td><td>' . $item . '</td></tr>';
      });
      print '</table>';
    }
  }

}
