<?php

$routes->get('/', function() {
	PostController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::index();
});


// POST-ROUTES

$routes->get('/post', function(){
  	PostController::index();
});

$routes->post('/post', function(){
  	PostController::create();
});

$routes->get('/post/new', function(){
  	PostController::form_view();
});

$routes->post('/post/new', function(){
    PostController::handle_form();
});

$routes->get('/post/:id', function($id){
	PostController::show($id);
});

$routes->post('/post/delete/:id', function($id){
	PostController::delete($id);
});

$routes->post('/post/update/:id', function($id){
	PostController::update($id);
});


// AUTHOR-ROUTES

$routes->get('/author', function(){
  AuthorController::index();
});

//$routes->post('/author/new', function() {
//	AuthorController::new($id);
//});

$routes->get('/author/login', function(){
  AuthorController::login_view();
});

$routes->post('/author/login', function(){
  AuthorController::handle_login();
});

$routes->get('/author/:id', function($id) {
  AuthorController::show($id);
});




// TAG-ROUTES

$routes->get('/tag', function(){
  	TagController::index();
});

$routes->post('/tag/new', function(){
    TagController::store();
});

$routes->post('/tag/update/:id', function($id){
    TagController::update($id);
});

$routes->post('/tag/delete/:id', function($id){
    TagController::delete($id);
});

$routes->get('/tag/:id', function($id){
    TagController::show($id);
});



// COMMENT-ROUTES

$routes->get('/comment', function(){
  CommentController::index();
});

$routes->get('/comment/new', function(){
  CommentController::form_view();
});

$routes->post('/comment/new', function(){
  CommentController::handle_form();
});

$routes->get('/comment/:id', function($id){
  CommentController::show($id);
});


