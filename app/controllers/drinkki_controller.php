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

	public static function store($msg){
		$params = $_POST;
		$drinkki = new Drinkki(array(
			'nimi' => $params['nimi'],
			'tyyppi' => $params['tyyppi'],
			'hintaluokka' => strlen($params['hintaluokka']/3),
			'kuvaus' => $params['kuvaus'],
			'added' => date("Y-m-d")
		));

		$drinkki_id = $drinkki->saveOrUpdate();

		// Pudota listojen viimeiset elementit, sillä html-javascript-hässäkkä sisältää yhden ylimääräisen tyhjän elementin... Pitäisi olla parempi javascript-hässäkkä!
		$raakaAineet = $params['raakaAineet'];
		$maarat = $params['maarat'];
		$i = 0;

		foreach($raakaAineet as $raakaAine){
			$m = $maarat[$i++];
			if($raakaAine != ''){
				$ra = new RaakaAine(array(
				'nimi' => $raakaAine
			));
			$ra->saveOrIgnore();
			$drinkki_raakaaine = new DrinkkiRaakaAine(array(
				'drinkki_id' => $drinkki_id,
				'raakaaine_id' => $ra->id,
				'maara' => $m
			));
			$drinkki_raakaaine->saveOrIgnore();
			}	
		}
		
		Redirect::to('/drinkki/' . $drinkki->id, array('message' => $msg));
	}

	public static function edit($id){
		$drinkki = Drinkki::find($id);
		View::make('drinkki/edit.html', array('attributes' => $drinkki));
	}

	public static function destroy($id){
		$drinkki = Drinkki::destroy($id);
		$raakaAineet = RaakaAine::destroyAbandoned($drinkki);
		foreach ($raakaAineet as $raakaAine) {
			DrinkkiRaakaAine::destroyAbandoned($drinkki,$raakaAine);
		}

		Redirect::to('/game', array('message' => 'Peli on poistettu onnistuneesti!'));
	}

}