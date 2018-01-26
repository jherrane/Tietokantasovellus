<?php
  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  View::make('home.html');
    }

    public static function sandbox(){
      $test = Drinkki::find(1);
      $drinkit = Drinkki::all();

      Kint::dump($drinkit);
      Kint::dump($test);
    }

    public static function login(){
      View::make('login.html');
    }

    public static function list(){
      View::make('list.html');
    }

    public static function edit(){
      View::make('edit.html');
    }

    public static function show(){
      View::make('show.html');
    }
  }
