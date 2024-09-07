<?php

namespace app\commands;

use PhpParser\Node\Stmt\Return_;
use yii\console\Controller;
use yii\console\ExitCode;
use app\models\Book;
use app\models\Author;

/** Comando para la clase de prueba */
class PlatziController extends Controller {
    /** Suma los valores de los dos parámetros */
    public function actionSuma($a, $b) {
        $result = $a + $b;
        printf("%f\n", $result);
        return ExitCode::OK; // 0 (EXIT_SUCCESS)
    }

    public function quick($book) {
        $book->title = sprintf("%sffff", $book->title);
        return $book;
    }    

    public function actionBooks($file) 
    {
        $f = fopen($file, "r");
        if (!$f) {
            echo "Unable to open file.\n";
            return ExitCode::UNSPECIFIED_ERROR;
        }
    
        while (($data = fgetcsv($f)) !== false) {
            if (empty($data) || (count($data) == 1 && empty($data[0]))) {
                echo "Empty row encountered...\n";
                continue;
            }
            if(!empty($data[1]) && !empty($data[2])) {
                $author = Author::find()
                  ->where(['name' => $data[2]])
                  ->one();
                if(empty($author)) {
                    $author = new Author();
                    $author->name = $data[2];
                    if (!$author->save()) {
                        echo "Error al guardar el autor: " . $author->name . "\n";
                        print_r($author->errors);
                        continue;
                    }
                }

                $book = new Book();
                $book->title = $data[1];
                $book->author_id = $author->getId();
                if ($book->save()) {
                    echo "Autor: {$author->name} y Libro guardado: {$book->title}\n";
                } else {
                    echo "Error al guardar el libro: " . $book->title . "\n";
                    print_r($book->errors);
                }
    
                echo $book->toString() . "\n";
            }
        }
    
        fclose($f);
        return ExitCode::OK;
    }

    public function actionAuthor($author_id) {
        // $author = Author::find()
        //     ->with('books')
        //     ->where(['author_id' => $author_id])
        //     ->one();
        $author = Author::findOne($author_id);
        if(empty($author)) {
            printf("no existe el author\n");
            return ExitCode::DATAERR;
        }

        printf("%s:\n", $author->toString());
        foreach($author->books as $book) {
            printf(" - %s\n", $book->toString());
        }
        return ExitCode::OK;
    }

    public function actionBook($book_id) {
        $book = Book::findOne($book_id);
        if (empty($book)) {
            printf("no existe el libro\n");
            return ExitCode::DATAERR;
        }
        printf("%s\n", $book->toString());
        return ExitCode::OK;
    }
}   