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

$routes->get('/post/new', function(){
  	PostController::form_view();
});

$routes->post('/post/new', function(){
    PostController::store();
});

$routes->get('/post/:id', function($id){
	PostController::show($id);
});

$routes->post('/post/:id/delete', function($id){
	PostController::delete($id);
});

$routes->get('/post/:id/update', function($id){
    PostController::update_form_view($id);
});

$routes->post('/post/:id/update', function($id){
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

$routes->post('/author/new', function(){
  AuthorController::store();
});

$routes->get('/author/:id', function($id) {
  AuthorController::show($id);
});

$routes->post('/author/:id/update', function($id) {
  AuthorController::update($id);
});

$routes->post('/author/:id/delete', function($id) {
  AuthorController::delete($id);
});






// TAG-ROUTES

$routes->get('/tag', function(){
  	TagController::index();
});

$routes->post('/tag/new', function(){
    TagController::store();
});

$routes->post('/tag/:id/update', function($id){
    TagController::update($id);
});

$routes->post('/tag/:id/delete', function($id){
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


