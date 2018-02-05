<?php
class Drinkki extends BaseModel{
	public $id, $nimi, $tyyppi, $hintaluokka, $kuvaus, $added;

	public function __construct($attributes){
		parent::__construct($attributes);
	}

	public function saveOrUpdate(){
    	$query = DB::connection()->prepare('SELECT * FROM Drinkki WHERE nimi = :nimi');
    	$query->execute(array($this->nimi));
    	$rows = $query->fetchAll();
    	if(empty($rows)){
    		return self::save();
    	} else {
    		self::update($rows[0]);
    	}
	}

	private function save(){
		$query = DB::connection()->prepare('INSERT INTO Drinkki(nimi,tyyppi,hintaluokka,kuvaus,added) VALUES (:nimi, :tyyppi, :hintaluokka, :kuvaus, :added) RETURNING id;');
		$query->execute(array('nimi' => $this->nimi, 'tyyppi' => $this->tyyppi, 'hintaluokka' => $this->hintaluokka, 'kuvaus' => $this->kuvaus, 'added' => $this->added));
		$row = $query->fetch();
		$this->id = $row['id'];

		return $this->id;
	}

	private function update($drinkki){
		$query = DB::connection()->prepare('UPDATE Drinkki SET nimi=:nimi, tyyppi=:tyyppi, hintaluokka=:hintaluokka, kuvaus=:kuvaus, added=:added WHERE id=:id;');
		$query->execute(array('nimi' => $this->nimi, 'tyyppi' => $this->tyyppi, 'hintaluokka' => $this->hintaluokka, 'kuvaus' => $this->kuvaus, 'added' => $this->added, 'id' => $drinkki->id));
	}

	public static function destroy($id){
		$query = DB::connection()->prepare('DELETE FROM Drinkki WHERE id = :id;');
		$query->execute(array('id' => $id));
	}

	public static function all(){
		$query = DB::connection()->prepare('SELECT * FROM Drinkki');
		$query->execute();
		$rows = $query->fetchAll();
		$drinkit = array();
		
		foreach($rows as $row){
			$hl = self::hinta($row['hintaluokka']);
			$drinkit[] = new Drinkki(array(
				'id' => $row['id'],
				'nimi' => $row['nimi'],
				'tyyppi' => $row['tyyppi'],
				'hintaluokka' => $hl,
				'kuvaus' => $row['kuvaus'],
				'added' => $row['added']
			));
		}

		return $drinkit;
	}

	public static function find($id){
		$query = DB::connection()->prepare('SELECT * FROM Drinkki WHERE id = :id LIMIT 1;');
		$query->execute(array('id' => $id));
		$row = $query->fetch();

		if($row){
			$hl = self::hinta($row['hintaluokka']);
			$drinkki = new Drinkki(array(
				'id' => $row['id'],
				'nimi' => $row['nimi'],
				'tyyppi' => $row['tyyppi'],
				'hintaluokka' => $hl,
				'kuvaus' => $row['kuvaus'],
				'added' => $row['added']
			));
		
			return $drinkki;
		}

		return null;
	}

	public static function hinta($hl){
		$hintaluokat = array(
			1 => "€",
			2 => "€€",
			3 => "€€€",
		);

		return $hintaluokat[$hl];
	}
}
