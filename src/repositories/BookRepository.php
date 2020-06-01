<?php

namespace Repositories;

require '/var/www/src/models/Book.php';

use PDO;
use PDOException;
use \Models\Book;

class BookRepository {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->initBookRepository();
    }

    public function initBookRepository() {
        $this->pdo->exec(
            "CREATE TABLE IF NOT EXISTS books (
                id INT (11) NOT NULL AUTO_INCREMENT,
                title VARCHAR (255) NOT NULL,
                author VARCHAR (255) NOT NULL,
                date_published VARCHAR (255) NOT NULL,
                pages VARCHAR (255) NOT NULL, PRIMARY KEY (id)
             )"
        );
    }

    public function getAllBooks(): ?array {
        $books = [];

        try {
            $statement = $this->pdo->query("SELECT * FROM books");
            $booksFromDB = $statement->fetchAll(PDO::FETCH_OBJ);

            foreach ($booksFromDB as $bookFromDB) {
                $book = new Book(
                    $bookFromDB->title, $bookFromDB->author, $bookFromDB->date_published, $bookFromDB->pages
                );
                array_push($books, $book);
            }
        } catch (PDOException $exception) {
            echo '{"error": {"text": ' . $exception->getMessage() . '}}';
        }

        return $books;
    }

    public function getBookById(int $id): ?Book {
        $book = null;

        try {
            $statement = $this->pdo->query("SELECT * FROM books WHERE id = $id");
            $bookFromDB = $statement->fetch(PDO::FETCH_OBJ);

            if ($bookFromDB) {
                $book = new Book(
                    $bookFromDB->title, $bookFromDB->author, $bookFromDB->date_published, $bookFromDB->pages
                );
            }
        } catch (PDOException $e) {
            echo '{"error": {"text": ' . $e->getMessage() . '}}';
        }

        return $book;
    }

    public function addBook(Book $book): bool {
        $result = false;

        try {
            $statement = $this->pdo->prepare(
                "INSERT INTO books (title, author, date_published, pages)
                 VALUES (:title, :author, :date_published, :pages)"
            );
            $statement->bindParam(':title', $book->getTitle());
            $statement->bindParam(':author', $book->getAuthor());
            $statement->bindParam(':date_published', $book->getDatePublished());
            $statement->bindParam(':pages', $book->getPages());
            $statement->execute();

            $result = true;
        } catch (PDOException $e) {
            echo '{"error": {"text": ' . $e->getMessage() . '}}';
        }

        return $result;
    }

    public function updateBookById(int $id, Book $newBook): bool {
        $result = false;

        try {
            $book =  $this->getBookById($id);

            if ($book) {
                $statement = $this->pdo->prepare(
                    "UPDATE books 
                     SET    title           = :title, 
                            author          = :author,
                            date_published  = :date_published,
                            pages           = :pages
                     WHERE  id = $id"
                );
                $statement->bindParam(':title', $newBook->getTitle());
                $statement->bindParam(':author', $newBook->getAuthor());
                $statement->bindParam(':date_published', $newBook->getDatePublished());
                $statement->bindParam(':pages', $newBook->getPages());

                $statement->execute();

                $result = true;
            }
        } catch (PDOException $e) {
            echo '{"error": {"text": ' . $e->getMessage() . '}}';
        }

        return $result;
    }

    public function deleteBookById($id): bool {
        $result = false;

        try {
            $book =  $this->getBookById($id);

            if ($book) {
                $statement = $this->pdo->prepare("DELETE FROM books WHERE id = $id");
                $statement->execute();

                $result = true;
            }
        } catch (PDOException $e) {
            echo '{"error": {"text": ' . $e->getMessage() . '}}';
        }

        return $result;
    }
}