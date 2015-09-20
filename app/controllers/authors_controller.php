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

	public static function login_view() {
		View::make('Author/login.html');
	}

	public static function handle_login() {
		$params = $_POST;
		$author = Author::authenticate($params['name'], $params['password']);

    	if(!$author){
      		View::make('author/login.html');
      		// array('error' => 'Väärä käyttäjätunnus tai salasana!', 'name' => $params['name'])
    	}else{
      		$_SESSION['author'] = $author->id;

      		Redirect::to('/');
      		// array('message' => 'Moro, ' . $->name . '!')
    	}
	}
}