<?php 

class CommentController extends BaseController {

	public static function index() {
    	$comments = Comment::all();
    	View::make('Comment/index.html', array('comments' => $comments));
   	}

    public static function store() {
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
    }
    
    public static function delete($id){ 
        $comment = new Comment(array('id' => $id));
        $comment->delete();
        Redirect::to('/post');
    }


}