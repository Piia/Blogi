<?php

  class BaseController{

    public static function get_user_logged_in(){
      if(isset($_SESSION['author'])) {
        $author_id = $_SESSION['author'];
        $author = Author::find($author_id);
        return $author;
      }
      return null;
    }

    public static function check_logged_in(){
      // Toteuta kirjautumisen tarkistus tähän.
      // Jos käyttäjä ei ole kirjautunut sisään, ohjaa hänet toiselle sivulle (esim. kirjautumissivulle).
    }

  }
