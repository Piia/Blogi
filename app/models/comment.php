<?php

class Comment extends BaseModel{

  	public $id, $post_id, $name, $header, $content, $created, $edited;

  	public function __construct($attributes){
    	parent::__construct($attributes);
  	}

  	public static function all(){
    // Alustetaan kysely tietokantayhteydellämme
    	$query = DB::connection()->prepare('SELECT * FROM Comment');
    // Suoritetaan kysely
    	$query->execute();
    // Haetaan kyselyn tuottamat rivit
    	$rows = $query->fetchAll();
    	$comments = array();

    // Käydään kyselyn tuottamat rivit läpi
    	foreach($rows as $row){
      // Tämä on PHP:n hassu syntaksi alkion lisäämiseksi taulukkoon :)
      		$comments[] = new Comment(array(
        		'id' => $row['id'],
            'post_id' => $row['post_id'],
            'name' => $row['name'],
            'header' => $row['header'],
            'content' => $row['content'],
            'created' => $row['created'],
            'edited' => $row['edited']
      		));
    	}

    	return $comments;
  	}

  	public static function find($id){
    	$query = DB::connection()->prepare('SELECT * FROM Comment WHERE id = :id LIMIT 1');
    	$query->execute(array('id' => $id));
    	$row = $query->fetch();

	    if($row){
	      $comment = new Comment(array(
	        'id' => $row['id'],
          'post_id' => $row['post_id'],
          'name' => $row['name'],
          'header' => $row['header'],
          'content' => $row['content'],
          'created' => $row['created'],
          'edited' => $row['edited']
	      ));

	      return $comment;
	    }

    	return null;
  	}
}