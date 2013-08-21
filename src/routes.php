<?php
/**
 * Routes for Xhgui
 */
$app->error(function (Exception $e) use ($app) {
    $app->render('error/view.twig', array(
        'message' => $e->getMessage(),
        'stack_trace' => $e->getTraceAsString(),
    ));
});

// Profile Runs routes
$app->get('/', function () use ($di) {
    $di['runController']->index();
})->name('home');

$app->get('/:server', function ($server) use ($di) {
    $di['runController']->server($server);
})->name('server');

$app->get('/:server/run/view', function ($server) use ($di) {
    $di['runController']->view($server);
})->name('run.view');

$app->get('/:server/url/view', function ($server) use ($di) {
    $di['runController']->url($server);
})->name('url.view');

$app->get('/:server/run/compare', function ($server) use ($di) {
    $di['runController']->compare($server);
})->name('run.compare');

$app->get('/:server/run/symbol', function ($server) use ($di) {
    $di['runController']->symbol($server);
})->name('run.symbol');

$app->get('/:server/run/callgraph', function ($server) use ($di) {
    $di['runController']->callgraph($server);
})->name('run.callgraph');


// Watch function routes.
$app->get('/:server/watch', function ($server) use ($di) {
    $di['watchController']->get($server);
})->name('watch.list');

$app->post('/:server/watch', function ($server) use ($di) {
    $di['watchController']->post($server);
})->name('watch.save');


// Custom report routes.
$app->get('/:server/custom', function ($server) use ($di) {
    $di['customController']->get($server);
})->name('custom.view');

$app->post('/:server/custom/query', function ($server) use ($di) {
    $di['customController']->query($server);
})->name('custom.query');

$app->get('/:server/custom/help', function ($server) use ($di) {
    $di['customController']->help($server);
})->name('custom.help');
