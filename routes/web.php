<?php

/** @var \Laravel\Lumen\Routing\Router $router */


use App\Events\QuestionCreatedEvent;
use App\Events\QuestionLikedEvent;
use App\Models\Question;

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

$router->get('/tesAja', function () use ($router) {
    $dataBaru = Question::first();
    event(new QuestionCreatedEvent($dataBaru));
    //QuestionEvent::dispatch($dataBaru);
    return $dataBaru;
});

$router->get('/tesLike', function () use ($router) {
    $dataPertanyaan = Question::find(1);
    $dataPertanyaan->like = $dataPertanyaan->like + 1;
    $dataPertanyaan->save();

    event(new QuestionLikedEvent($dataPertanyaan));
    //QuestionEvent::dispatch($dataBaru);
    return $dataPertanyaan;
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
        $router->post("/events/enter", "EventController@getSpecificEvent");

    // -- Logged In --

        $router->group(['middleware' => ['login'] ], function() use ($router) {

            // -- Events --
            $router->get("/admin/events", "EventController@getAllEvents");
            $router->get("/admin/event/{id}", "EventController@getKhususEvent");
            $router->post("/admin/event/create", "EventController@createEvent");
            $router->patch("/admin/event/update/{id}", "EventController@editEvent");
            $router->delete("/admin/event/{id}", "EventController@deleteEvent");
        

            // -- Get Questions --
            $router->get("/admin/questions", "QuestionController@getSemuaQuestions");

       });


});


