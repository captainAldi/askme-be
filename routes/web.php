<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// API
$router->group(['prefix' => 'api/v1/' ], function() use ($router) {

    // -- ALL --

        // -- Authentication --
        $router->post("/login", "AuthController@login");


        // -- Question for All --
        $router->get("/questions/{event}", "QuestionController@getAllQuestions");
        $router->post("/questions/like/{id}", "QuestionController@likeQuestions");
        $router->post("/questions/create", "QuestionController@createQuestions");

        // -- Event for All --
        //$router->post("/events", "EventController@getAllEvents");
        $router->post("/events/enter", "EventController@getSpecificEvent");

    // -- Logged In --

        // -- Get Events --

        // -- Get Questions --


});


