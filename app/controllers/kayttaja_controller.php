<?php
class KayttajaController extends BaseController{
  public static function login(){
      View::make('kayttaja/login.html');
  }

  public static function handle_login(){
    $params = $_POST;

    $kayttaja = Kayttaja::authenticate($params['nimi'], $params['salasana']);
    
    if(!$kayttaja){
      View::make('kayttaja/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'nimi' => $params['nimi']));
    } else {
      $_SESSION['nimi'] = $kayttaja->id;

      Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $kayttaja->nimi . '!'));
    }
  }

  public static function logout(){
    session_unset();
    Redirect::to('/', array('message' => 'Olet kirjautunut ulos.'));
  }

}