<?php
class RaakaAine extends BaseModel{
	public $id, $nimi;

	public function __construct($attributes){
		parent::__construct($attributes);
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


}
