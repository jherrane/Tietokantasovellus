<?php
class DrinkkiRaakaAine extends BaseModel{
	public $id, $drinkki_id, $raakaaine_id, $maara;

	public function __construct($attributes){
		parent::__construct($attributes);
	}
	
	public function save(){
		$query = DB::connection()->prepare('SELECT * FROM DrinkkiRaakaAine WHERE drinkki_id = :drinkki_id AND raakaaine_id=:raakaaine_id');
    	$query->execute(array($this->drinkki_id, $this->raakaaine_id));
    	$rows = $query->fetchAll();
    	if(empty($rows)){
    		$query = DB::connection()->prepare('INSERT INTO DrinkkiRaakaAine(drinkki_id, raakaaine_id, maara) VALUES (:drinkki_id, :raakaaine_id, :maara);');
            $query->execute(array('drinkki_id' => $this->drinkki_id, 'raakaaine_id' => $this->raakaaine_id, 'maara' => $this->maara));
    	} else {
    		return;
    	}
	}

	public function update($id){

	}
}
