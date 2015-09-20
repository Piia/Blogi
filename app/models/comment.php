<?php

class Comment extends BaseModel{

  	public $id, $post_id, $name, $header, $content, $created, $edited;

  	public function __construct($attributes){
    	parent::__construct($attributes);
  	}

  	public static function all(){
    	$query = DB::connection()->prepare('SELECT * FROM Comment');
    	$query->execute();
    	$rows = $query->fetchAll();
    	$comments = array();

    	foreach($rows as $row){
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

    public function save(){
      $query = DB::connection()->prepare('INSERT INTO Comment (name, header, content, created, edited) VALUES (:name, :header, :content, :created, :content) RETURNING id');
      $query->execute(array('name' => $this->name, 'header' => $this->header, 'content' => $this->content, 'created' => $this->created, 'edited'=> $this->edited));
      $row = $query->fetch();
      $this->id = $row['id'];
    }

}