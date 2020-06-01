<?php
require '../vendor/autoload.php';
require '../src/config/db.php';

$app = new Slim\App();

$db = new db();
$db = $db->connect();

$sql = "CREATE TABLE IF NOT EXISTS books (
            id INT (11) NOT NULL AUTO_INCREMENT,
            title VARCHAR (255) NOT NULL,
            author VARCHAR (255) NOT NULL,
            date_published VARCHAR (255) NOT NULL,
            pages VARCHAR (255) NOT NULL, PRIMARY KEY (id)
        )";
$db->exec($sql);

// Book Routes
require '../src/routes/books.php';

$app->run();