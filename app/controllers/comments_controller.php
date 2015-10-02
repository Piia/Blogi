<?php 

class CommentController extends BaseController{
	public static function index(){
    	$comments = Comment::all();
    	View::make('Comment/index.html', array('comments' => $comments));
   	}

	public static function show($id){
    	$comment = Comment::find($id);
    	View::make('Comment/comment.html', array('comment' => $comment));
    }

    public static function store(){
        $params = $_POST;
        $comment = new Comment(array(
            'name' => $params['name'],
            'header' => $params['header'],
            'content' => $params['content'],
            'created' => date('Y-m-d'),
            'edited' => date('Y-m-d'),
            'post_id' => $params['post_id']
        ));

        $comment->save();
        Redirect::to('/post/' . $comment->post_id);
        //, array('message' => 'New post added to your blog!')
    }

    public static function form_view() {
        View::make('Comment/comment_form.html');
    }

    public static function handle_form() {
        Redirect::to('/comment');
    }

}