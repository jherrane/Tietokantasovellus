<?php

  $routes->get('/', function() {
    SandboxController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    SandboxController::sandbox();
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

  $routes->get('/login', function(){
    KayttajaController::login();
  });
  
  $routes->post('/login', function(){
    KayttajaController::handle_login();
  });

  $routes->get('/logout', function(){
    KayttajaController::logout();
  });
