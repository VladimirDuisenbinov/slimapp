<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// Get All Books
$app->get('/api/books', function (Request $request, Response $response){
    $sql = "SELECT * FROM books";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->query($sql);
        $books = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($books);
    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}}';
    }
});

// Get Single Book
$app->get('/api/books/{id}', function (Request $request, Response $response){
    $id = $request->getAttribute('id');
    $sql = "SELECT * FROM books WHERE id = $id";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->query($sql);
        $book = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($book);
    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}}';
    }
});

// Add Book
$app->post('/api/books', function (Request $request, Response $response){
    $title = $request->getParam('title');
    $author = $request->getParam('author');
    $date_published = $request->getParam('date_published');
    $pages = $request->getParam('pages');

    $sql = "INSERT INTO books (title, author, date_published, pages)
            VALUES(:title, :author, :date_published, :pages)";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':date_published', $date_published);
        $stmt->bindParam(':pages', $pages);
        $stmt->execute();

        echo '{"notice": {"text": "Book Added"}}';
    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}}';
    }
});

// Update Book
$app->put('/api/books/{id}', function (Request $request, Response $response){
    $id = $request->getAttribute('id');
    $title = $request->getParam('title');
    $author = $request->getParam('author');
    $date_published = $request->getParam('date_published');
    $pages = $request->getParam('pages');

    $sql = "UPDATE books 
            SET title           = :title, 
                author          = :author,
                date_published  = :date_published,
                pages           = :pages
            WHERE id = $id";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':date_published', $date_published);
        $stmt->bindParam(':pages', $pages);

        $stmt->execute();

        echo '{"notice": {"text": "Book Updated"}}';
    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}}';
    }
});

// Delete Book
$app->delete('/api/books/{id}', function (Request $request, Response $response){
    $id = $request->getAttribute('id');
    $sql = "DELETE FROM books WHERE id = $id";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Book Deleted"}}';
    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}}';
    }
});