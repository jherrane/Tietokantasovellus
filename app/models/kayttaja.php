<?php
class Kayttaja extends BaseModel{
	public $id, $nimi, $salasana;

	public function __construct($attributes){
		parent::__construct($attributes);
		$this->validators = array('validate_nimi', 'validate_kuvaus');
		$this->type = "Kayttaja";
	}

	public function save(){
		$query = DB::connection()->prepare('INSERT INTO Kayttaja(nimi,salasana) VALUES (:nimi, :salasana) RETURNING id;');
		$query->execute(array('nimi' => $this->nimi, 'salasana' => $this->salasana));
		$row = $query->fetch();
		$this->id = $row['id'];

		return $this->id;
	}

	public function update($id){
		$query = DB::connection()->prepare('UPDATE Kayttaja SET nimi=:nimi, salasana=:salasana WHERE id=:id;');
		$query->execute(array('nimi' => $this->nimi, 'salasana' => $this->salasana, 'id' => $id));
		return $id;
	}

	public static function destroy($id){
		$query = DB::connection()->prepare('DELETE FROM KayttajaDrinkki WHERE kayttaja_id = :id;');
		$query->execute(array('id' => $id));

		$query = DB::connection()->prepare('DELETE FROM Kayttaja WHERE id = :id;');
		$query->execute(array('id' => $id));

	}

	public static function authenticate($nimi, $salasana){
		$query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE nimi = :nimi AND salasana = :salasana LIMIT 1');
		$query->execute(array('nimi' => $nimi, 'salasana' => $salasana));
		$row = $query->fetch();

		if($row){
		  return new Kayttaja(array(
		  	'id' => $row['id'],
		  	'nimi' => $row['nimi'],
		  	'salasana' => $row['salasana']
		  ));
		} 
		return null;
	}

	public static function find($id){
		$row = self::getOne('Kayttaja', $id);

		if($row){
			return new Kayttaja(array(
				'id' => $row['id'],
				'nimi' => $row['nimi'],
				'salasana' => $row['salasana']
			));
		}

		return null;
	}

}