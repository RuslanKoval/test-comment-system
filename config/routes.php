<?php 

$routes = array(
	'/' => 'comment#index',
	'/push' => 'comment#push',
	'/update' => 'comment#update',
    '/delete' => 'comment#delete',
	'/reply' => 'comment#reply',
	'/login' => 'user#login',
	'/logout' => 'user#logout',
	'/register' => 'user#register',
);
