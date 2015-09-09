<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  
      //echo 'Tämä on etusivu!';
      View::make('suunnitelmat/index.html');
    }

    public static function sandbox(){
      // Testaa koodiasi täällä
      View::make('helloworld.html');
      //echo 'Hello World!';
    }
  }
