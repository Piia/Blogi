<?php

  class BaseModel{
    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null){
      // Käydään assosiaatiolistan avaimet läpi
      foreach($attributes as $attribute => $value){
        // Jos avaimen niminen attribuutti on olemassa...
        if(property_exists($this, $attribute)){
          // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
          $this->{$attribute} = $value;
        }
      }
    }

    public function not_null_string_validator($str) {
      if(strlen($str) == 0) {
        return "Kenttä ei saa olla tyhjä.";
      }
    }

    public function not_too_long_string_validator($str, $max_length) {
      if(strlen($str) > $max_length) {
        return "Maksimipituus: " . $max_length . " merkkiä.";
      }
    }

    public function errors(){
      $errors = array();
      foreach($this->validators as $validator_name) {
        $errors = array_merge($errors, $this->{$validator_name}());
      }
      return $errors;
    }

  }
