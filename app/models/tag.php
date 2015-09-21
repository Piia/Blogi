<?php

class Tag extends BaseModel {

  	public $id, $name;

  	public function __construct($attributes) {
    	parent::__construct($attributes);
      $this->validators = array();
      $this->validators[] = $this->validate_name();
  	}

    public function validate_name() {
      $errors = array();
      $errors[] = parent::not_null_string_validator($this->name);
      $errors[] = parent::not_too_long_string_validator($this->name, 50);
      return $errors;
    }

  	public static function all() {
    	$query = DB::connection()->prepare('SELECT * FROM Tag ORDER BY name');
    	$query->execute();
    	$rows = $query->fetchAll();
    	$tags = array();

    	foreach($rows as $row){
      		$tags[] = new Tag(array(
        		'id' => $row['id'],
        		'name' => $row['name']
      		));
    	}

    	return $tags;
  	}

  	public static function find($id) {
    	$query = DB::connection()->prepare('SELECT * FROM Tag WHERE id = :id LIMIT 1');
    	$query->execute(array('id' => $id));
    	$row = $query->fetch();

	    if($row){
	      $tag = new Tag(array(
	        'id' => $row['id'],
        	'name' => $row['name']
	      ));

	      return $tag;
	    }
    	return null;
  	}

    public function save() {
      $query = DB::connection()->prepare('INSERT INTO Tag (name) VALUES (:name) RETURNING id');
      $query->execute(array('name' => $this->name));
      $row = $query->fetch();
      $this->id = $row['id'];
    }

    public function update() {
      $query = DB::connection()->prepare('UPDATE Tag SET name = :name WHERE id = :id');
      $query->execute(array('name' => $this->name, 'id' => $this->id));
      $row = $query->fetch();
    }

    public function delete() {
      $query = DB::connection()->prepare('DELETE FROM Tag WHERE id = :id');
      $query->execute(array('id' => $this->id));
      $row = $query->fetch();
    }

}