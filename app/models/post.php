<?php

class Post extends BaseModel{

  	public $id, $author_id, $header, $content, $created, $edited, $tags, $author;

  	public function __construct($attributes){
    	parent::__construct($attributes);
      $this->validators = array('validate_header', 'validate_content');
  	}

    public function validate_header() {
      $errors = array();
      $firstValidator = parent::not_null_string_validator($this->header);
      $secondValidator = parent::not_too_long_string_validator($this->header, 50);
      if($firstValidator) {
        $errors[] = $firstValidator;
      }
      if($secondValidator) {
        $errors[] = $secondValidator;
      }
      return $errors;
    }

    public function validate_content() {
      $errors = array();
      $firstValidator = parent::not_null_string_validator($this->content);
      $secondValidator = parent::not_too_long_string_validator($this->content, 1000);
      if($firstValidator) {
        $errors[] = $firstValidator;
      }
      if($secondValidator) {
        $errors[] = $secondValidator;
      }
      return $errors;
    }

  	public static function all($options){

      if(isset($options['page'])){
        $page = $options['page'];
      } else {
        $page = 1;
      }

      $query = DB::connection()->prepare('SELECT * FROM Post ORDER BY created DESC LIMIT :limit OFFSET :offset');
      $query->execute(array('limit' => 10, 'offset' => 10 * ($page - 1)));
    	$rows = $query->fetchAll();
    	$posts = array();

    	foreach($rows as $row){
          $post = new Post(array(
            'id' => $row['id'],
            'author_id' => $row['author_id'],
            'header' => $row['header'],
            'content' => $row['content'],
            'created' => $row['created'],
            'edited' => $row['edited']
          ));

          // Haetaan tagit.
          $query2 = DB::connection()->prepare('SELECT * FROM Tag, Post_Tag WHERE Post_Tag.post_id = :id AND Post_Tag.tag_id = Tag.id');
          $query2->execute(array('id' => $row['id']));
          $rows2 = $query2->fetchAll();
          $tags = array();
          foreach ($rows2 as $row2) {
            $tag = new Tag(array(
              'id' => $row2['id'],
              'name' => $row2['name']
              ));
            $tags[] = $tag;
          }
          $post->tags = $tags;

          // Haetaan author.
          if($post->author_id) {
            $author = Author::find($post->author_id);
            $post->author = $author;
          }
          $posts[] = $post;
    	}

    	return $posts;
  	}

    public static function find_all_by_tag($tag) {
      $query = DB::connection()->prepare('SELECT * FROM Post, Post_Tag WHERE Post_Tag.tag_id = :tag_id ORDER BY created DESC');
      $query->execute(array('tag_id' => $tag -> id));
      $rows = $query->fetchAll();
      $posts = array();

      foreach($rows as $row){
          $post = new Post(array(
            'id' => $row['id'],
            'author_id' => $row['author_id'],
            'header' => $row['header'],
            'content' => $row['content'],
            'created' => $row['created'],
            'edited' => $row['edited']
          ));

          // Haetaan author.
          if($post->author_id) {
            $author = Author::find($post->author_id);
            $post->author = $author;
          }
          $posts[] = $post;
      }

      return $posts;
    }

  	public static function find($id) {
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

        // Haetaan tagit.
        $query2 = DB::connection()->prepare('SELECT * FROM Tag, Post_Tag WHERE Post_Tag.post_id = :id and Post_Tag.tag_id = Tag.id');
        $query2->execute(array('id' => $id));
        $rows2 = $query2->fetchAll();

        $tags = array();
        foreach ($rows2 as $row2) {
          $tag = new Tag(array(
            'id' => $row2['id'],
            'name' => $row2['name']
            ));
          $tags[] = $tag;
        }
        $post->tags = $tags;

        // Haetaan author.
        if($post->author_id) {
          $author = Author::find($post->author_id);
          $post->author = $author;
        }

	      return $post;
	    }

    	return null;
  	}

    public function save() {
      $query = DB::connection()->prepare('INSERT INTO Post (author_id, header, content, created, edited) VALUES (:author_id, :header, :content, :created, :edited) RETURNING id');
      $query->execute(array('author_id' => $this->author_id, 'header' => $this->header, 'content' => $this->content, 'created' => $this->created, 'edited' => $this->edited));
      $row = $query->fetch();
      $this->id = $row['id'];

      // lisätään tagit tietokantaan
      $query_string = 'INSERT INTO Post_Tag (post_id, tag_id) VALUES ';
      foreach ($this->tags as $tag_id) {
        $query_string .= '(' . $this->id . ', ' . $tag_id . '),';
      }
      $query_string = chop($query_string, ',');
      $query2 = DB::connection()->prepare($query_string);
      $query2->execute();
      $row2 = $query2->fetch();
    }

    public function update() {
      $query = DB::connection()->prepare('UPDATE Post SET header = :header, content = :content, edited = :edited WHERE id = :id');
      $query->execute(array('header' => $this->header, 'content' => $this->content, 'edited' => $this->edited, 'id' => $this->id));
      $row = $query->fetch();

      // tagit
      // ensin poistetaan vanhat tagit
      $query3 = DB::connection()->prepare('DELETE FROM Post_Tag WHERE post_id = :id');
      $query3->execute(array('id' => $this->id));
      $row3 = $query3->fetch();

      // sitten lisätään uudet tagit
      $query_string = 'INSERT INTO Post_Tag (post_id, tag_id) VALUES ';
      foreach ($this->tags as $tag_id) {
        $query_string .= '(' . $this->id . ', ' . $tag_id . '),';
      }
      $query_string = chop($query_string, ',');
      $query2 = DB::connection()->prepare($query_string);
      $query2->execute();
      $row2 = $query2->fetch();
    }

    public function delete() {
      $query = DB::connection()->prepare('DELETE FROM Post WHERE id = :id');
      $query->execute(array('id' => $this->id));
      $row = $query->fetch();

      // poistetaan tagit
      $query2 = DB::connection()->prepare('DELETE FROM Post_Tag WHERE post_id = :id');
      $query2->execute(array('id' => $this->id));
      $row2 = $query2->fetch();

      // poistetaan kommentit
      $query3 = DB::connection()->prepare('DELETE FROM Comment WHERE post_id = :id');
      $query3->execute(array('id' => $this->id));
      $row3 = $query3->fetch();
    }

    public function count() {
      $query = DB::connection()->prepare('SELECT COUNT(*) FROM Post');
      $query->execute();
      $row = $query->fetch();
      return $row['count'];
    }





}