<?php

class Author extends BaseModel {

  	public $id, $name, $password, $image_url, $description;

  	public function __construct($attributes){
    	parent::__construct($attributes);
  	}

  	public static function all() {
    	$query = DB::connection()->prepare('SELECT * FROM Author ORDER BY name');
    	$query->execute();
    	$rows = $query->fetchAll();
    	$authors = array();

    	foreach($rows as $row){
      		$authors[] = new Author(array(
        		'id' => $row['id'],
        		'name' => $row['name'],
        		'password' => $row['password'],
        		'image_url' => $row['image_url'],
        		'description' => $row['description']
      		));
    	}

    	return $authors;
  	}

  	public static function find($id) {
    	$query = DB::connection()->prepare('SELECT * FROM Author WHERE id = :id LIMIT 1');
    	$query->execute(array('id' => $id));
    	$row = $query->fetch();

	    if($row){
	      $author = new Author(array(
	        'id' => $row['id'],
        	'name' => $row['name'],
        	'password' => $row['password'],
        	'image_url' => $row['image_url'],
        	'description' => $row['description']
	      ));

	      return $author;
	    }

    	return null;
  	}

    public function save() {
      $query = DB::connection()->prepare('INSERT INTO Author (name, password, image_url, description) VALUES (:name, :password, :image_url, :description) RETURNING id');
      $query->execute(array('name' => $this->name, 'password' => $this->password, 'image_url' => $this->image_url, 'description' => $this->description));
      $row = $query->fetch();
      $this->id = $row['id'];
    }

    public function update() {
      $query = DB::connection()->prepare('UPDATE Author SET name = :name, password = :password, image_url = :image_url, description = :description WHERE id = :id');
      $query->execute(array('name' => $this->name, 'password' => $this->password, 'image_url' => $this->image_url, 'description' => $this->description, 'id' => $this->id));
      $row = $query->fetch();
    }

    public function delete() {
      $query = DB::connection()->prepare('DELETE FROM Author WHERE id = :id');
      $query->execute(array('id' => $this->id));
      $row = $query->fetch();
    }

    public static function authenticate($name, $password) {
      $query = DB::connection()->prepare('SELECT * FROM Author WHERE name = :name AND password = :password LIMIT 1');
      $query->execute(array('name' => $name, 'password' => $password));
      $row = $query->fetch();
      
      if($row){
        $author = new Author(array(
          'id' => $row['id'],
          'name' => $row['name'],
          'password' => $row['password'],
          'image_url' => $row['image_url'],
          'description' => $row['description']
        ));

        return $author;
      }

      return null;
    }
}