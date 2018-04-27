<?php
/**
 * Front controller for To-Do List Code Challenge for Broadnet
 *
 * @author Chris Pitchford
 * @date 2018-04-26
 * @version 1.0
 *
 * This single file is the endpoint for the To-Do application. Loading it in a
 * browser loads the templates, javascript and CSS files for a single-page app.
 *
 *
 */

session_start();

require_once 'vendor/autoload.php';
require_once 'config/local.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \Models\ItemModel as Item;

// Configure and create Slim app
$config = ['settings' => [
  'addContentLengthHeader' => false,
]];
// Debug
$config['settings']['displayErrorDetails'] = true;
// from config/local.php
$config['settings']['db']['host']   = $host;
$config['settings']['db']['user']   = $user;
$config['settings']['db']['pass']   = $pass;
$config['settings']['db']['dbname'] = $db;

$app = new \Slim\App($config);

// Fetch DI Container
$container = $app->getContainer();

// Register PDO
$container['db'] = function ($c) {
  $db = $c['settings']['db'];
  $pdo = new \PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'], $db['user'], $db['pass']);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  return $pdo;
};

// Register logging
$container['logger'] = function($c) {
  $logger = new \Monolog\Logger('my_logger');
  $file_handler = new \Monolog\Handler\StreamHandler('logs/app.log');
  $logger->pushHandler($file_handler);
  return $logger;
};

// Register Twig View helper
$container['view'] = function ($c) {
  $view = new \Slim\Views\Twig('templates', [
    'cache' => 'cache',
    'debug' => TRUE
  ]);

  // Instantiate and add Slim specific extension
  $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
  $view->addExtension(new \Slim\Views\TwigExtension($c['router'], $basePath));

  return $view;
};

// Register "middleware" for all routes: form protection
//$app->add($container->get('csrf'));

// Define static route
$app->get('/', function (Request $request, Response $response, $args) {
  $SAYMYNAME = "C.J.";
  return $this->view->render($response, 'index.html.twig', [
    "name" => $SAYMYNAME,
  ]);
})->setName('index');

// Define named route
$app->get('/help', function ($request, $response, $args) {
  return $this->view->render($response, 'help.html.twig');
})->setName('help');

$app->map(['GET', 'POST'], '/items[/{id}]', function (Request $request, Response $response, $args) use ($app) {

  // Model and View, all rolled into one mapper
  $itemMapper = new Item($this->db, $this->logger);

  switch (TRUE) {
    case $request->isGet():
      if (isset($args['id']) && $args['id'] != '') {
        // send details if needed
        $item_id = (int) $args['id'];
        $response->getBody()->write(json_encode($itemMapper->fetchOne($item_id)));
      }
      else {
        $response->getBody()->write(json_encode($itemMapper->fetchAll()));
      }
      break;
    case $request->isPost():
//      $this->logger->addInfo('POST');
      $parsedBody = $request->getParsedBody();
//      $this->logger->addInfo(print_r($parsedBody, true));
      $response->getBody()->write(json_encode($itemMapper->service($parsedBody)));
      break;
    default:
      break;
  }

})->setName('items-detail');

$app->run();