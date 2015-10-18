<?php 

class AuthorController extends BaseController {

	public static function index() {
    	$authors = Author::all();
    	View::make('Author/index.html', array('authors' => $authors));
   	}

   	public static function show($id) {
    	$author = Author::find($id);
    	View::make('Author/author.html', array('author' => $author));
	}

  public static function store() {
    $params = $_POST;
    $author = new Author(array(
      'name' => $params['name'],
      'password' => $params['password'],
      'image_url' => $params['image_url'],
      'description' => $params['description']
    ));

    $author->save();
    Redirect::to('/author/' . $author->id);
  }

  public static function update($id) {
    $params = $_POST;

    $attributes = array(
      'id' => $id,
      'name' => $params['name'],
      'password' => $params['password'],
      'image_url' => $params['image_url'],
      'description' => $params['description']
    );

    $author = new Author($attributes);
    $author->update();
    Redirect::to('/author/' . $author->id);
  }
 
  public static function delete($id) { 
    $author = new Author(array('id' => $id));
    $author->delete();
    Redirect::to('/author');
  }

	public static function login_view() {
		View::make('Author/login.html');
	}

  public static function logout() {
    $_SESSION['author'] = null;
    Redirect::to('/author/login');
  }

	public static function handle_login() {
		$params = $_POST;
		$author = Author::authenticate($params['name'], $params['password']);

    	if(!$author) {
      		View::make('author/login.html');
    	}  else {
      		$_SESSION['author'] = $author->id;

      		Redirect::to('/');
    	}
	}
}