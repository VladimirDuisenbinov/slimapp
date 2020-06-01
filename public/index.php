<?php
require '../vendor/autoload.php';
require '../src/config/DBConnection.php';
require '/var/www/src/repositories/BookRepository.php';

use \Repositories\BookRepository;

$app = new Slim\App();

$container = $app->getContainer();
$container['getDatabasePDO'] = function ($container) {
    $dbConnection = new DBConnection();
    $pdo = $dbConnection->connect();

    return $pdo;
};

$container['getBookRepository'] = function () use ($container) {
    $bookRepository = new BookRepository($container['getDatabasePDO']);

    return $bookRepository;
};

// Book Routes
require '../src/routes/books.php';

$app->run();