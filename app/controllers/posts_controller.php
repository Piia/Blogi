<?php 

class PostController extends BaseController{
	public static function index(){
        $params = $_GET;
        $options = array();
        $curr_page = 1;
        if(isset($params['page'])){
            $options['page'] = $params['page'];
            $curr_page = $options['page'];
        }

    	$posts = Post::all($options);

        $games_count = Post::count();
        $page_size = 10;
        $pages = ceil($games_count/$page_size);

        if($curr_page == 1) {
            $prev_page = $curr_page;
            $next_page = 2;
        } else if($curr_page == $pages) {
            $prev_page = $curr_page -1;
            $next_page = $curr_page;
        } else {
            $prev_page = $curr_page - 1;
            $next_page = $curr_page + 1;
        }

        $tags = Tag::all();

    	View::make('Post/index.html', array('posts' => $posts, 'pages' => $pages, 'curr_page' => $curr_page, 'prev_page' => $prev_page, 'next_page' => $next_page, 'tags' => $tags));
   	}

	public static function show($id){
    	$post = Post::find($id);
        $comments = Comment::all($id);
    	View::make('Post/post.html', array('post' => $post, 'comments' => $comments));
    }

    public static function store(){
        $params = $_POST;
        $attributes = array(
            'author_id' => $params['author_id'],
            'header' => $params['header'],
            'content' => $params['content'],
            'created' => date('Y-m-d'),
            'edited' => date('Y-m-d'),
            'tags' => $params['tags']
        );
        $post = new Post($attributes);
        $errors = $post->errors();

        if(count($errors) == 0){
            $post->save();
            Redirect::to('/post/' . $post->id);
            //, array('message' => 'New post added to your blog!')
        } else {
            View::make('/Post/post_form.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function update($id) {
        $params = $_POST;

        $attributes = array(
            'id' => $id,
            'header' => $params['header'],
            'content' => $params['content'],
            'edited' => date('Y-m-d'),
            'tags' => $params['tags']
        );

        $post = new Post($attributes);
        $errors = $post->errors();

        if(count($errors) == 0){
            $post->update();
            Redirect::to('/post/' . $post->id);
            //, array('message' => 'Kirjoitusta muokattu!')
        } else {
            View::make('/Post/update_form.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

 
    public static function delete($id){ 
        $post = new Post(array('id' => $id));
        $post->delete();
        Redirect::to('/post');
        //, array('message' => 'Kirjoitus poistettu!')
    }

    public static function form_view() {
        $tags = Tag::all();
        View::make('Post/post_form.html', array('tags' => $tags));
    }

    public static function update_form_view($id) {
        $post = Post::find($id);
        $tags = Tag::all();
        View::make('Post/update_form.html', array('post' => $post, 'tags' => $tags));
    }

    public static function handle_form() {
        Redirect::to('/post');
    }

}