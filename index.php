<?php

use CoffeeCode\Router\Router;

require __DIR__.'/vendor/autoload.php';

$router = new Router(__URL__);

/**
 * routes
 * The controller must be in the namespace Test\Controller
 */
$router->namespace("App\Controller")->group(null);

$router->get("/contact", "HomeController:contact", "contact");

/**
 * Post router
 */
$router->namespace("App\Controller\Post")->group(null);
$router->get("/", "ProductController:index", "product");
$router->post("/search", "ProductController:search", "product.search");
$router->get("/product/category/{id}", "ProductController:category", "product.category");
$router->get("/product/location/{id}", "ProductController:location", "product.location");

/**
 * Admin
 */
$router->namespace("App\Controller\Admin")->group('admin');
$router->get("/", "AdminController:index", "admin");
//products router
$router->get("/product", "ProductController:index", "product.index");
$router->post("/product/store", "ProductController:store", "product.store");
$router->post("/product/search", "ProductController:search", "product.searchTable");
$router->get("/product/{id}", "ProductController:show", "product.show");
$router->get("/product/{id}/edit", "ProductController:edit", "product.edit");
$router->put("/product/{id}", "ProductController:update", "product.update");
$router->delete("/product/{id}", "ProductController:destroy", "product.destroy");

//Users router
$router->get('/user','UserController:index','user.index');
$router->post('/user/store','UserController:store','user.store');
$router->get('/user/{id}','UserController:show','user.show');
$router->get('/user/{id}/edit','UserController:edit','user.edit');
$router->put('/user/{id}','UserController:update','user.update');
$router->delete('/user/{id}','UserController:destroy','user.destroy');
//my profile router
$router->get('/user/perfil','PerfilController:index','perfil');
$router->get('/perfil','UserController:profile','user.profile');
$router->put('/perfil/update','UserController:updatePerfil','user.profile.update');
$router->put('/perfil/password','UserController:password','user.profile.password');
$router->put('/perfil/upload','UserController:upload','user.profile.upload');


//Category router

$router->get('/category','CategoryController:index','category.index');
$router->post('/category/store','CategoryController:store','category.store');
$router->get('/category/{id}/edit','CategoryController:edit','category.edit');
$router->put('/category/{id}','CategoryController:update','category.update');
$router->delete('/category/{id}','CategoryController:destroy','category.destroy');

//Color router

$router->get('/color','ColorController:index','color.index');
$router->post('/color/store','ColorController:store','color.store');
$router->get('/color/{id}/edit','ColorController:edit','color.edit');
$router->put('/color/{id}','ColorController:update','color.update');
$router->delete('/color/{id}','ColorController:destroy','color.destroy');

//Location router

$router->get('/location','LocationContoller:index','location.index');
$router->post('/location/store','LocationContoller:store','location.store');
$router->get('/location/{id}/edit','LocationContoller:edit','location.edit');
$router->put('/location/{id}','LocationContoller:update','location.update');
$router->delete('/location/{id}','LocationContoller:destroy','location.destroy');



/**
 * auth router
 */
$router->namespace("App\Controller\Auth")->group(null);
$router->get("/login","AuthController:index", "login");
$router->get("/logout","AuthController:logout", "logout");
$router->post("/register","AuthController:create", "register");
$router->post("/validation","AuthController:validation", "validation");
$router->post("/password","AuthController:sendPassword","password");
$router->get("/password/reset/{token}","AuthController:reset","reset");
$router->put("/password/store","AuthController:storeNewPassword","password.store");
/**
 * Group Error
 * This monitors all Router errors. Are they: 400 Bad Request, 404 Not Found, 405 Method Not Allowed and 501 Not Implemented
 */
$router->group("error")->namespace("App\Controller");
$router->get("/{errcode}", "NotFound:index", "error");


/**
 * This method executes the routes
 */
$router->dispatch();

/*
 * Redirect all errors
 */
if ($router->error()) {
    $router->redirect("error",['errcode'=>$router->error()]);
}

