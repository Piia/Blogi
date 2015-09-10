<?php

class Author extends BaseModel{

  	public $id, $name, $password, $image_url $description;

  	public function __construct($attributes){
    	parent::__construct($attributes);
  	}

  	public static function all(){
    // Alustetaan kysely tietokantayhteydellämme
    	$query = DB::connection()->prepare('SELECT * FROM Author');
    // Suoritetaan kysely
    	$query->execute();
    // Haetaan kyselyn tuottamat rivit
    	$rows = $query->fetchAll();
    	$authors = array();

    // Käydään kyselyn tuottamat rivit läpi
    	foreach($rows as $row){
      // Tämä on PHP:n hassu syntaksi alkion lisäämiseksi taulukkoon :)
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

  	public static function find($id){
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
}