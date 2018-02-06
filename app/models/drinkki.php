<?php
class Drinkki extends BaseModel{
	public $id, $nimi, $tyyppi, $hintaluokka, $kuvaus, $added;

	public function __construct($attributes){
		parent::__construct($attributes);
		$this->validators = array('validate_nimi', 'validate_kuvaus', 'validate_raakaAineet');
	}

	public function saveOrUpdate($id){
    	$query = DB::connection()->prepare('SELECT * FROM Drinkki WHERE id = :id');
    	$query->execute(array($id));
    	$rows = $query->fetchAll();
    	if(empty($rows)){
    		return self::save();
    	} else {
    		return self::update($id);
    	}
	}

	private function save(){
		$query = DB::connection()->prepare('INSERT INTO Drinkki(nimi,tyyppi,hintaluokka,kuvaus,added) VALUES (:nimi, :tyyppi, :hintaluokka, :kuvaus, :added) RETURNING id;');
		$query->execute(array('nimi' => $this->nimi, 'tyyppi' => $this->tyyppi, 'hintaluokka' => $this->hintaluokka, 'kuvaus' => $this->kuvaus, 'added' => $this->added));
		$row = $query->fetch();
		$this->id = $row['id'];

		return $this->id;
	}

	private function update($id){
		$query = DB::connection()->prepare('UPDATE Drinkki SET nimi=:nimi, tyyppi=:tyyppi, hintaluokka=:hintaluokka, kuvaus=:kuvaus, added=:added WHERE id=:id;');
		$query->execute(array('nimi' => $this->nimi, 'tyyppi' => $this->tyyppi, 'hintaluokka' => $this->hintaluokka, 'kuvaus' => $this->kuvaus, 'added' => $this->added, 'id' => $id));
		return $id;
	}

	public static function destroy($id){
		$query = DB::connection()->prepare('DELETE FROM KayttajaDrinkki WHERE drinkki_id = :id;');
		$query->execute(array('id' => $id));

		$query = DB::connection()->prepare('DELETE FROM DrinkkiRaakaAine WHERE drinkki_id = :id;');
		$query->execute(array('id' => $id));

		$query = DB::connection()->prepare('DELETE FROM Drinkki WHERE id = :id;');
		$query->execute(array('id' => $id));

	}

	public static function all($kayttaja_id){
		if($kayttaja_id){
			$query = DB::connection()->prepare('SELECT * FROM Drinkki, KayttajaDrinkki WHERE KayttajaDrinkki.kayttaja_id = :kayttaja_id AND Drinkki.id = KayttajaDrinkki.drinkki_id;');
			$query->execute(array('kayttaja_id' => $kayttaja_id));
		} else {
			$query = DB::connection()->prepare('SELECT * FROM Drinkki');
			$query->execute();
		}
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
		$row = self::getOne('Drinkki', $id);

		if($row){
			return new Drinkki(array(
				'id' => $row['id'],
				'nimi' => $row['nimi'],
				'tyyppi' => $row['tyyppi'],
				'hintaluokka' => self::hinta($row['hintaluokka']),
				'kuvaus' => $row['kuvaus'],
				'added' => $row['added']
			));
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

	public function validate_nimi(){
		return $this->validate_string_length($this->nimi, 'nimi', 3);
	}

	public function validate_kuvaus(){
		return $this->validate_string_length($this->kuvaus, 'kuvaus', 10);
	}

	public function validate_raakaAineet($raakaAineet){
		return $this->validate_ainekset($raakaAineet, 1);
	}

}
