<?php

class Post extends BaseModel{

  	public $id, $author_id, $header, $content, $created, $edited;

  	public function __construct($attributes){
    	parent::__construct($attributes);
  	}

  	public static function all(){
    	$query = DB::connection()->prepare('SELECT * FROM Post');
    	$query->execute();
    	$rows = $query->fetchAll();
    	$posts = array();

    	foreach($rows as $row){
      		$posts[] = new Post(array(
        		'id' => $row['id'],
            'author_id' => $row['author_id'],
            //'author' => $(Author::find($posts['author_id']))->name,
            'header' => $row['header'],
            'content' => $row['content'],
            'created' => $row['created'],
            'edited' => $row['edited']
      		));
    	}

    	return $posts;
  	}

  	public static function find($id){
    	$query = DB::connection()->prepare('SELECT * FROM Post WHERE id = :id LIMIT 1');
    	$query->execute(array('id' => $id));
    	$row = $query->fetch();

	    if($row){
	      $post = new Post(array(
            'id' => $row['id'],
            'author_id' => $row['author_id'],
            'header' => $row['header'],
            'content' => $row['content'],
            'created' => $row['created'],
            'edited' => $row['edited']
	      ));

	      return $post;
	    }

    	return null;
  	}

    public function save(){
      $query = DB::connection()->prepare('INSERT INTO Post (header, content, created, edited) VALUES (:header, :content, :created, :edited) RETURNING id');
      $query->execute(array('header' => $this->header, 'content' => $this->content, 'created' => $this->created, 'edited' => $this->edited));
      $row = $query->fetch();
      $this->id = $row['id'];
    }
}