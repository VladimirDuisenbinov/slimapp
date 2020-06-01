<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Models\Book;

$app->group('/books', function () {

    // Get All Books
    $this->get('', function (Request $request, Response $response) {
        $bookRepository = $this->getBookRepository;
        $books = $bookRepository->getAllBooks();

        if (count($books) > 0) {
            foreach ($books as $book) {
                echo "Book Title: " . $book->getTitle() . "<br>" .
                     "Book Author: " . $book->getAuthor() . "<br>" .
                     "Book Published Date: " . $book->getDatePublished() . "<br>" .
                     "Number of Pages: " . $book->getPages() . "<br><br>";
            }
        } else {
            echo "There are no books.";
        }
    });

    // Get Single Book By ID
    $this->get('/{id}', function (Request $request, Response $response) {
        $id = $request->getAttribute('id');

        $bookRepository = $this->getBookRepository;
        $book = $bookRepository->getBookById((int) $id);

        if ($book) {
            echo "Book Title: " . $book->getTitle() . "<br>" .
                 "Book Author: " . $book->getAuthor() . "<br>" .
                 "Book Published Date: " . $book->getDatePublished() . "<br>" .
                 "Number of Pages: " . $book->getPages() . "<br><br>";
        } else {
            echo "There is no book with id " . $id . ".";
        }
    });

    // Add Book
    $this->post('', function (Request $request, Response $response) {
        $title = $request->getParam('title');
        $author = $request->getParam('author');
        $date_published = $request->getParam('date_published');
        $pages = $request->getParam('pages');

        $bookRepository = $this->getBookRepository;
        $book = new Book($title, $author, $date_published, $pages);
        $isBookAdded = $bookRepository->addBook($book);

        if ($isBookAdded) {
            echo "Book was successfully added.";
        } else {
            echo "Book was not added.";
        }
    });

    // Update Book By ID
    $this->put('/{id}', function (Request $request, Response $response) {
        $id = $request->getAttribute('id');
        $title = $request->getParam('title');
        $author = $request->getParam('author');
        $date_published = $request->getParam('date_published');
        $pages = $request->getParam('pages');

        $bookRepository = $this->getBookRepository;
        $newBook = new Book($title, $author, $date_published, $pages);
        $isBookUpdated = $bookRepository->updateBookById((int) $id, $newBook);

        if ($isBookUpdated) {
            echo "Book with id " . $id . " was successfully updated.";
        } else {
            echo "Book with the specified id of " . $id . " was not updated.";
        }
    });

    // Delete Book By ID
    $this->delete('/{id}', function (Request $request, Response $response){
        $id = $request->getAttribute('id');

        $bookRepository = $this->getBookRepository;
        $isBookDeleted = $bookRepository->deleteBookById($id);

        if ($isBookDeleted) {
            echo "Book with id " . $id . " was successfully deleted.";
        } else {
            echo "Book with the specified id of " . $id . " was not deleted.";
        }
    });
});