<?php

  $routes->get('/', function() {
    SandboxController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    SandboxController::sandbox();
  });

  $routes->get('/drinkit', function(){
    DrinkkiController::index();
  });

  $routes->get('/kayttaja/:id/drinkit', function($kayttaja_id){
    DrinkkiController::index($kayttaja_id);
  });

  $routes->post('/drinkit', function(){
    DrinkkiController::store('Drinkki luotu onnistuneesti!');
  });

  $routes->get('/drinkit/new', function(){
    DrinkkiController::create();
  });

  $routes->get('/drinkit/:id', function($id){
    DrinkkiController::show($id);
  });

  $routes->get('/drinkit/:id/edit', function($id){
    DrinkkiController::edit($id);
  });

  $routes->post('/drinkit/:id/edit', function($id){
    DrinkkiController::store('Drinkkiä muokattu onnistuneesti!', $id);
  });

  $routes->post('/drinkit/:id/destroy',function($id){
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
