<?php
  class SandboxController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  View::make('home.html');
    }

    public static function sandbox(){
      $test = Drinkki::find(1);
      $drinkit = Drinkki::all();

      $test = new Drinkki(array(
        'nimi' => 'a',
        'tyyppi' => 'Muu',
        'hintaluokka' => '€€€',
        'kuvaus' => 'Moi, ei.',
        'added' => '1-1-1970'
      ));

      $errors = $test->errors();
      Kint::dump($errors);
    }
  }
