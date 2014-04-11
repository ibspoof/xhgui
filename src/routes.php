<?php


ini_set('display_errors', 1);
error_reporting(E_ALL);

/**
 * Routes for Xhgui
 */
$app->error(function (Exception $e) use ($di, $app) {
    $view = $di['view'];
    $view->parserOptions['cache'] = false;
    $view->parserExtensions = array(
        new Xhgui_Twig_Extension($app)
    );

    // Remove the controller so we don't render it.
    unset($app->controller);

    $app->view($view);
    $app->render('error/view.twig', array(
        'message' => $e->getMessage(),
        'stack_trace' => $e->getTraceAsString(),
    ));
});

// Profile Runs routes
$app->get('/', function () use ($di, $app) {
    $app->controller = $di['runController'];
    $app->controller->index();
})->name('home');

$app->get('/:server', function ($server) use ($di, $app) {
	$app->controller = $di['runController'];
	$app->controller->setServer($server);
	$app->controller->server();
})->name('server');

$app->get('/:server/run/view', function ($server) use ($di, $app) {
    $app->controller = $di['runController'];
    $app->controller->setServer($server);
    $app->controller->view();
})->name('run.view');

$app->get('/:server/url/view', function ($server) use ($di, $app) {
    $app->controller = $di['runController'];
	$app->controller->setServer($server);
    $app->controller->url();
})->name('url.view');

$app->get('/:server/run/compare', function ($server) use ($di, $app) {
    $app->controller = $di['runController'];
	$app->controller->setServer($server);
    $app->controller->compare();
})->name('run.compare');

$app->get('/:server/run/symbol', function ($server) use ($di, $app) {
    $app->controller = $di['runController'];
	$app->controller->setServer($server);
    $app->controller->symbol();
})->name('run.symbol');

$app->get('/:server/run/callgraph', function ($server) use ($di, $app) {
    $app->controller = $di['runController'];
	$app->controller->setServer($server);
    $app->controller->callgraph();
})->name('run.callgraph');

$app->get('/:server/run/callgraph/data', function ($server) use ($di, $app) {
	$app->controller = $di['runController'];
	$app->controller->setServer($server);
	$app->controller->callgraphData();
})->name('run.callgraph.data');

// Watch function routes.
$app->get('/:server/watch', function ($server) use ($di, $app) {
	$app->controller = $di['watchController'];
	$app->controller->setServer($server);
    $app->controller->get();
})->name('watch.list');

$app->post('/:server/watch', function ($server) use ($di, $app) {
	$app->controller = $di['watchController'];
	$app->controller->setServer($server);
	$app->controller->post();
})->name('watch.save');


// Custom report routes.
$app->get('/:server/custom', function ($server) use ($di, $app) {
    $app->controller = $di['customController'];
	$app->controller->setServer($server);
    $app->controller->get();
})->name('custom.view');

$app->get('/:server/custom/help', function ($server) use ($di, $app) {
    $app->controller = $di['customController'];
	$app->controller->setServer($server);
    $app->controller->help();
})->name('custom.help');

$app->post('/:server/custom/query', function ($server) use ($di, $app) {
	$app->controller = $di['customController'];
	$app->controller->setServer($server);
	$app->controller->query();
})->name('custom.query');


// Waterfall routes
$app->get('/:server/waterfall', function ($server) use ($di, $app) {
	$app->controller = $di['waterfallController'];
	$app->controller->setServer($server);
    $app->controller->index();
})->name('waterfall.list');

$app->get('/:server/waterfall/data', function ($server) use ($di, $app) {
	$app->controller = $di['waterfallController'];
	$app->controller->setServer($server);
	$app->controller->query();
})->name('waterfall.data');

