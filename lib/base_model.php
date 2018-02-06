<?php
  abstract class BaseModel{
    protected $validators, $type;
    abstract function save();
    abstract function update($id);

    public function __construct($attributes = null){
      foreach($attributes as $attribute => $value){
        if(property_exists($this, $attribute)){
          $this->{$attribute} = $value;
        }
      }
    }

    public function saveOrUpdate($id){
      $query = DB::connection()->prepare("SELECT * FROM {$this->type} WHERE id = :id");
      $query->execute(array($id));
      $rows = $query->fetchAll();
      if(empty($rows)){
        return $this->save();
      } else {
        return $this->update($id);
      }
    }

    public static function getOne($table, $id){
      $query = DB::connection()->prepare("SELECT * FROM {$table} WHERE id = :id LIMIT 1;");
      $query->execute(array('id' => $id));
      $row = $query->fetch();

      if($row){
        return $row;
      }

      return null;
    }

    public function validate_string_length($str, $which, $len){
      $errors = array();

      if($str == '' || $str == null){
        $errors[] = "Muuttuja \"{$which}\" ei saa olla tyhjä!";
      }
      if(strlen($str)<$len){
        $errors[] = "Muuttujan \"{$which}\" pituuden tulee olla vähintään {$len} merkkiä!";
      }
      return $errors;
    }

    public function validate_ainekset($raakaAineet,$len){
      $errors = array();
      if(count($raakaAineet)<$len){
        $errors[] = "Anna ainakin {$len} raaka-aine!";
      }

      return $errors;
    }

    public function errors($raakaAineet){
      $errors = array();

      foreach($this->validators as $validator){
        $errors = array_merge($errors, $this->{$validator}($raakaAineet));
      }

      return $errors;
    }

  }
