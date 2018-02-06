<?php
class KayttajaDrinkki extends BaseModel{
	public $id, $kayttaja_id, $drinkki_id;

	public function __construct($attributes){
		parent::__construct($attributes);
	}
	
	public function saveOrIgnore(){
		$query = DB::connection()->prepare('SELECT * FROM KayttajaDrinkki WHERE drinkki_id = :drinkki_id AND kayttaja_id=:kayttaja_id');
    	$query->execute(array($this->drinkki_id, $this->kayttaja_id));
    	$rows = $query->fetchAll();
    	if(empty($rows)){
    		self::save();
    	} else {
    		return;
    	}
	}


	private function save(){
    $query = DB::connection()->prepare('INSERT INTO KayttajaDrinkki(kayttaja_id, drinkki_id) VALUES (:kayttaja_id, :drinkki_id);');
    $query->execute(array('kayttaja_id' => $this->kayttaja_id, 'drinkki_id' => $this->drinkki_id));
  }
}
