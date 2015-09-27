<?php 

class TagController extends BaseController {
	public static function index() {
    $tags = Tag::all();
    View::make('Tag/index.html', array('tags' => $tags));
  }

  public static function show($id) {
    $tag = Tag::find($id);
    View::make('Tag/tag.html', array('tag' => $tag));
	}

	public static function store() {
    $params = $_POST;
    $tag = new Tag(array(
      'name' => $params['name']
    ));


    $errors = $tag->errors();

    if(count($errors) == 0){
      $tag->save();
      Redirect::to('/tag/' . $tag->id);
      //, array('message' => 'Uusi tunniste lisätty!'));
    } else {
      View::make('Tag/index.html', array('errors' => $errors, 'old_name' => $tag->name));
    }
  }

  public static function update($id) {
    $params = $_POST;

    $attributes = array(
    	'id' => $id,
    	'name' => $params['name']
    );

    $tag = new Tag($attributes);
    $errors = $tag->errors();

    if(count($errors) == 0){
      $tag->update();
      Redirect::to('/tag/' . $tag->id);
      //, array('message' => 'Tunniste muokattu!')
    } else {
      View::make('/Tag/tag.html', array('errors' => $errors, 'attributes' => $attributes));
    }
  }

 
  public static function delete($id){ 
    $tag = new Tag(array('id' => $id));
    $tag->delete();
    Redirect::to('/tag');
    //, array('message' => 'Tunniste poistettu!')
  }

    //public static function handle_form() {
    //    Redirect::to('/tag');
    //}
}