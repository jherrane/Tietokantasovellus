<?php
class RaakaAineController extends BaseController{
	public static function store(){
		$params = $_POST;
		$ra = new RaakaAine(array(
			'id' => $params['id'],
			'nimi' => $params['nimi']
		));
		Kint::dump($params);
		$ra->save();
		//Redirect::to('/drinkki' . $drinkki->id, array('message' => 'Drinkki lisätty kirjastoosi!'));
	}
}