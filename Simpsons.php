<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Simpsons
 *
 * @author Dezaro
 */
class Simpsons {

  private $data = '{
  "total": "5",
  "data": [
    {
      "id": "1",
      "name": "Lisa",
      "email": "lisa@simpsons.com",
      "telephone": "5551111224",
      "birthDate": "05/10/1998"
    },
    {
      "id": "2",
       "name": "Lisa",
      "email": "lol@simpsons.com",
      "telephone": "5551111224",
      "birthDate": "07/17/1995"
    },
    {
      "id": "3",
       "name": "Bart",
      "email": "bart@simpsons.com",
      "telephone": "5552221234",
      "birthDate": "05/04/1993"
    },
    {
      "id": "4",
        "name": "Homer",
      "email": "homer@simpsons.com",
      "telephone": "5552221244",
      "birthDate": "04/19/1964"
    },
    {
      "id": "5",
      "name": "Marge",
      "email": "marge@simpsons.com",
      "telephone": "5552221254",
      "birthDate": "10/20/1970"
    }
  ]
}';

  public function getAll() {
    return $this->data;
  }

}
