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

  $routes->get('/show', function(){
  	HelloWorldController::show();
  });

  $routes->get('/drinkki', function(){
    DrinkkiController::index();
  });

  $routes->get('/drinkki/:id', function($id){
    DrinkkiController::show($id);
  });
