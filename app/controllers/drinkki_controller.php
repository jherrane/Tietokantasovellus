<?php
class DrinkkiController extends BaseController{
	public static function index($kayttaja_id = null){
		$drinkit = Drinkki::all($kayttaja_id);
		$array = array('drinkit' => $drinkit);

		if(self::get_user_logged_in()){
			$omalista = array();
			foreach($drinkit as $drinkki){
				$omalista[$drinkki->id] = $drinkki->on_listalla($_SESSION['nimi']);
			}
			$array['on_listalla'] = $omalista;		
		}
		

		if($kayttaja_id){
			$k = Kayttaja::find($kayttaja_id);		
			$array['kayttajatitle'] = 'Käyttäjän ' . $k->nimi . ' drinkkilista';
		} 
		View::make('drinkit/index.html', $array);
	}

	public static function show($id){
		$drinkki = Drinkki::find($id);
		$raakaAineet = RaakaAine::findByDrinkki($id);

		View::make('drinkit/show.html', array(
			'drinkki' => $drinkki,
			'raakaAineet' => $raakaAineet
		));
	}

	public static function create(){
		self::check_logged_in();
		View::make('drinkit/new.html');
	}

	public static function store($msg, $id = null){
		self::check_logged_in();
		$params = $_POST;
		$drinkki = new Drinkki(array(
			'nimi' => $params['nimi'],
			'tyyppi' => $params['tyyppi'],
			'hintaluokka' => strlen($params['hintaluokka'])/3,
			'kuvaus' => $params['kuvaus'],
			'added' => date("Y-m-d")
		));

		$raakaAineet = $params['raakaAineet'];
		$maarat = $params['maarat'];
		$i = 0;

		// Tarkista virheviestit ja ohjaa virheiden löytyessä muualle
		$errors = $drinkki->errors(array_filter($raakaAineet));
		if(count($errors) > 0) {
			View::make('drinkit/new.html', array('errors' => $errors));
		}
		
		$drinkki_id = $drinkki->saveOrUpdate($id);

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
			if($ra->id != '') {$drinkki_raakaaine->saveOrIgnore();}
			}	
		}

		Redirect::to('/drinkit/' . $drinkki_id, array('message' => $msg));
	}

	public static function edit($id){
		self::check_logged_in();
		$drinkki = Drinkki::find($id);
		$raakaAineet = RaakaAine::findByDrinkki($id);
		View::make('drinkit/edit.html', array('drinkki' => $drinkki,
		'raakaAineet' => $raakaAineet));
	}

	public static function lisaaListalle($id, $kayttaja_id = null){
		self::check_logged_in();
		$drinkki = Drinkki::find($id);
		$drinkki->lisaaKayttajalle($_SESSION['nimi']);
		if($kayttaja_id){
			$osoite = '/kayttaja/' . $_SESSION['nimi'] . '/drinkit';
		} else {
			$osoite = '/drinkit';
		}
		Redirect::to($osoite, array('message' => 'Drinkki lisätty omalle listalle!'));
	}

	public static function poistaListalta($id, $kayttaja_id = null){
		self::check_logged_in();
		$drinkki = Drinkki::find($id);
		$drinkki->poistaKayttajalta($_SESSION['nimi']);
		if($kayttaja_id){
			$osoite = '/kayttaja/' . $_SESSION['nimi'] . '/drinkit';
		} else {
			$osoite = '/drinkit';
		}
		Kint::dump(array('kayttaja_id' => $_SESSION['nimi'], 'drinkki' => $drinkki));
		Redirect::to($osoite, array('message' => 'Drinkki poistettu omalta listalta!'));
	}

	public static function destroy($id){
		self::check_logged_in();
		Drinkki::destroy($id);
		RaakaAine::destroyAbandoned();
		Redirect::to('/drinkit', array('message' => 'Drinkki on poistettu onnistuneesti!'));
	}

}