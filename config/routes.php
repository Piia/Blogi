<?php

$routes->get('/', function() {
	PostController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::index();
});

// Vaatiiko kirjautumista:

function check_logged_in(){
  BaseController::check_logged_in();
}


// POST-ROUTES

$routes->get('/post', function(){
  	PostController::index();
});

$routes->get('/post/new', 'check_logged_in', function(){
  	PostController::form_view();
});

$routes->post('/post/new', 'check_logged_in', function(){
    PostController::store();
});

$routes->get('/post/:id', function($id){
	PostController::show($id);
});

$routes->post('/post/:id/delete', 'check_logged_in', function($id){
	PostController::delete($id);
});

$routes->get('/post/:id/update', 'check_logged_in', function($id){
    PostController::update_form_view($id);
});

$routes->post('/post/:id/update', 'check_logged_in', function($id){
	PostController::update($id);
});


// AUTHOR-ROUTES

$routes->get('/author', function(){
  AuthorController::index();
});

$routes->get('/author/login', function(){
  AuthorController::login_view();
});

$routes->post('/author/login', function(){
  AuthorController::handle_login();
});

$routes->post('/author/logout', function(){
  AuthorController::logout();
});

$routes->post('/author/new', 'check_logged_in', function(){
  AuthorController::store();
});

$routes->get('/author/:id', function($id) {
  AuthorController::show($id);
});

$routes->post('/author/:id/update', 'check_logged_in', function($id) {
  AuthorController::update($id);
});

$routes->post('/author/:id/delete', 'check_logged_in', function($id) {
  AuthorController::delete($id);
});




// TAG-ROUTES

$routes->get('/tag', function(){
  	TagController::index();
});

$routes->post('/tag/new', 'check_logged_in', function(){
    TagController::store();
});

$routes->post('/tag/:id/update', 'check_logged_in', function($id){
    TagController::update($id);
});

$routes->post('/tag/:id/delete', 'check_logged_in', function($id){
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
  CommentController::store();
});

$routes->post('/comment/:id/delete', 'check_logged_in', function($id){
  CommentController::delete($id);
});

$routes->get('/comment/:id', function($id){
  CommentController::show($id);
});


