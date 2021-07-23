<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();

// Create Twig
$twig = Twig::create('templates', ['cache' => false]);
$app->add(TwigMiddleware::create($app, $twig));

$app->get('/hello', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
});

$app->get('/', function ($request, $response, $args) {
    $view = Twig::fromRequest($request);
    return $view->render($response, 'index.html', [
        'name' => 'test name'
    ]);
});

$app->run();