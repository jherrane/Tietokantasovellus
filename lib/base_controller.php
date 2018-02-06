<?php

  class BaseController{
    public static function get_user_logged_in(){
      // Katsotaan onko user-avain sessiossa
      if(isset($_SESSION['nimi'])){
        $kayttaja_id = $_SESSION['nimi'];
        // Pyydetään User-mallilta käyttäjä session mukaisella id:llä
        $kayttaja = Kayttaja::find($kayttaja_id);

        return $kayttaja;
      }

      // Käyttäjä ei ole kirjautunut sisään
      return null;
    }

    public static function check_logged_in(){
      if(isset($_SESSION['nimi'])){
       if(Kayttaja::find($_SESSION['nimi']));
        return true;
      }

      // Käyttäjä ei ole kirjautunut sisään
      return false;
    }

  }
