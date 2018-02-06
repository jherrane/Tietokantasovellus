<?php
class RaakaAine extends BaseModel{
	public $id, $nimi, $maara;

	public function __construct($attributes){
		parent::__construct($attributes);
	}
	
	public function save(){
		$query = DB::connection()->prepare('SELECT * FROM RaakaAine WHERE nimi = :nimi');
    	$query->execute(array($this->nimi));
    	$rows = $query->fetchAll();
    	if(empty($rows)){
    		$query = DB::connection()->prepare('INSERT INTO RaakaAine(nimi) VALUES (:nimi) RETURNING id;');
		    $query->execute(array('nimi' => $this->nimi));
		    $row = $query->fetch();
		    $this->id = $row['id'];

		    return $this->id;
    	} else {
    		return;
    	}
	}

	public function update($id){

	}

	public static function all(){
		$query = DB::connection()->prepare('SELECT * FROM RaakaAine');
		$query->execute();
		$rows = $query->fetchAll();
		$raakaAineet = array();

		foreach($rows as $row){
			$raakaAineet[] = new RaakaAine(array(
				'id' => $row['id'],
				'nimi' => $row['nimi']
			));
		}

		return $raakaAineet;
	}

	public static function findByDrinkki($id){
		$query = DB::connection()->prepare('SELECT RaakaAine.id as id, RaakaAine.nimi as nimi, DrinkkiRaakaAine.maara as maara FROM Drinkki, DrinkkiRaakaAine, RaakaAine WHERE Drinkki.id = :id AND DrinkkiRaakaAine.drinkki_id = Drinkki.id AND RaakaAine.id = DrinkkiRaakaAine.raakaaine_id;');
		$query->execute(array('id' => $id));
		$rows = $query->fetchAll();
		$raakaAineet = array();

		foreach($rows as $row){
			$raakaAineet[] = new RaakaAine(array(
				'id' => $row['id'],
				'nimi' => $row['nimi'],
				'maara' => $row['maara']
			));
		}
		return $raakaAineet;
	}

	public static function destroyAbandoned(){
		$query = DB::connection()->prepare('DELETE FROM RaakaAine WHERE id not IN (SELECT raakaaine_id FROM DrinkkiRaakaAine WHERE raakaaine_id is not null)');
		$query->execute();
	}

}
