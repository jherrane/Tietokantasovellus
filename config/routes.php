<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/login', function(){
  	HelloWorldController::login();
  });

  $routes->get('/list', function(){
  	HelloWorldController::list();
  });

  $routes->get('/edit', function(){
  	HelloWorldController::edit();
  });

  $routes->get('/drinkki', function(){
    DrinkkiController::index();
  });

  $routes->post('/drinkki', function(){
    DrinkkiController::store('Drinkki luotu onnistuneesti!');
  });

  $routes->get('/drinkki/new', function(){
    DrinkkiController::create();
  });

  $routes->get('/drinkki/:id', function($id){
    DrinkkiController::show($id);
  });

  $routes->get('/drinkki/:id/edit', function($id){
    DrinkkiController::edit($id);
  });

  $routes->post('/drinkki/:id/edit', function($id){
    DrinkkiController::store('Drinkkiä muokattu onnistuneesti!', $id);
  });

  $routes->post('/drinkki/:id/destroy',function($id){
    DrinkkiController::destroy($id);
  });
