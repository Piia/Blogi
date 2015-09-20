<?php 

class PostController extends BaseController{
	public static function index(){
    	$posts = Post::all();
    	View::make('Post/index.html', array('posts' => $posts));
   	}

	public static function show($id){
    	$post = Post::find($id);
    	View::make('Post/post.html', array('post' => $post));
    }

    public static function store(){
        $params = $_POST;
        $post = new Post(array(
            'author_id' => 1,
            'header' => $params['header'],
            'content' => $params['content'],
            'created' => date('Y-m-d'),
            'edited' => date('Y-m-d')
        ));

        $post->save();
        Redirect::to('/post/' . $post->id);
        //, array('message' => 'New post added to your blog!')
    }

    public static function update($id) {
        $params = $_POST;

        $attributes = array(
            'id' => $id,
            'header' => $params['header'],
            'content' => $params['content'],
            'edited' => date('Y-m-d')
        );

        $post = new Post($attributes);
        $post->update();
        Redirect::to('/post/' . $post->id);
        //, array('message' => 'Kirjoitusta muokattu!')
    }

 
    public static function delete($id){ 
        $post = new Post(array('id' => $id));
        $post->delete();
        Redirect::to('/post');
        //, array('message' => 'Kirjoitus poistettu!')
    }

    public static function form_view() {
        View::make('Post/post_form.html');
    }

    public static function update_form_view($id) {
        $post = Post::find($id);
        View::make('Post/update_form.html', array('post' => $post));
    }

    public static function handle_form() {
        Redirect::to('/post');
    }

}