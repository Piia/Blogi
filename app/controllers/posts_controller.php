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
            'header' => $params['header'],
            'content' => $params['content'],
            'created' => $params['created'],
            'edited' => $params['edited']
        ));

        $post->save();
        Redirect::to('/post/' . $post->id);
        //, array('message' => 'New post added to your blog!')
    }

    public static function form_view() {
        View::make('Post/post_form.html');
    }

    public static function handle_form() {
        Redirect::to('/post');
    }

}