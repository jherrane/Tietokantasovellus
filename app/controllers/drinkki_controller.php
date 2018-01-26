<?php
class DrinkkiController extends BaseController{
	public static function index(){
		$drinkit = Drinkki::all();

		View::make('drinkki/index.html', array('drinkit' => $drinkit));
	}

	public static function show($id){
		$drinkki = Drinkki::find($id);
		$raakaAineet = RaakaAine::find($id);

		View::make('drinkki/show.html', array(
			'drinkki' => $drinkki,
			'raakaAineet' => $raakaAineet;
		));
	}
}