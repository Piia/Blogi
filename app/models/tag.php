<?php

class Tag extends BaseModel{

  	public $id, $name;

  	public function __construct($attributes){
    	parent::__construct($attributes);
  	}

  	public static function all(){
    // Alustetaan kysely tietokantayhteydellämme
    	$query = DB::connection()->prepare('SELECT * FROM Tag');
    // Suoritetaan kysely
    	$query->execute();
    // Haetaan kyselyn tuottamat rivit
    	$rows = $query->fetchAll();
    	$tags = array();

    // Käydään kyselyn tuottamat rivit läpi
    	foreach($rows as $row){
      // Tämä on PHP:n hassu syntaksi alkion lisäämiseksi taulukkoon :)
      		$tags[] = new Tag(array(
        		'id' => $row['id'],
        		'name' => $row['name']
      		));
    	}

    	return $tags;
  	}

  	public static function find($id){
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
}