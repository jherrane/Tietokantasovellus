<?php
class DrinkkiController extends BaseController{
	public static function index(){
		$drinkit = Drinkki::all();

		View::make('drinkki/index.html', array('drinkit' => $drinkit));
	}

	public static function show($id){
		$drinkki = Drinkki::find($id);
		$raakaAineet = RaakaAine::findByDrinkki($id);

		View::make('drinkki/show.html', array(
			'drinkki' => $drinkki,
			'raakaAineet' => $raakaAineet
		));
	}

	public static function create(){
		$raakaAineet = RaakaAine::all();
		View::make('drinkki/new.html');
	}

	public static function store(){
		$params = $_POST;
		// $hl = Drinkki::hinta($params['hintaluokka']);
		// $drinkki = new Drinkki(array(
		// 	'nimi' => $params['nimi'],
		// 	'tyyppi' => $params['tyyppi'],
		// 	'hintaluokka' => $hl,
		// 	'kuvaus' => $params['kuvaus'],
		// 	'added' => $params['added']
		// ));
		// Kint::dump($params);
		// $drinkki->save();
		//Redirect::to('/drinkki/' . $drinkki->id, array('message' => 'Drinkki lisätty kirjastoosi!'));
	}
}