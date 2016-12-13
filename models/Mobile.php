<?php

Class Mobile {

  private $mobiles = array(
      1 => 'Apple iPhone 6S',
      2 => 'Samsung Galaxy S6',
      3 => 'Apple iPhone 6S Plus',
      4 => 'LG G4',
      5 => 'Samsung Galaxy S6 edge',
      6 => 'OnePlus 2');

  public function getAllMobile() {
    return $this->mobiles;
  }

  public function getMobile($id) {

    $mobile = array($id => ($this->mobiles[$id]) ? $this->mobiles[$id] : $this->mobiles[1]);
    return $mobile;
  }

}
