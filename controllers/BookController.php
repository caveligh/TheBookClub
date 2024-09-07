<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Book;
use app\models\UserBook;
use app\models\BookScore;

use Exception;

class BookController extends Controller {

  public function actionAll() {
    $books = Book::find()->all();
    return $this->render('all.tpl', ['books' => $books, 'titulo' => 1]);
  }

  public function actionDetail($id) {
    $book = Book::findOne($id);

    if(empty($book)) {
      Yii::error("Libro no encontrado con id: $id");
      Yii::$app->session->setFlash('error', 'Ese libro no existe');
      return $this->redirect(['site/index']); // Cambiamos goHome() por una redirección explícita
    }
    
    $bs = new BookScore();
    $bs->book_id = $book->id;

    //$scoreUrl = Yii::$app->urlManager->createUrl(['book/score']);
    Yii::error("Renderizando vista de detalle para libro: " . $book->title);
    return $this->render('detail.tpl', [
        'book' => $book, 
        'book_score' => $bs,
        //'scoreUrl' => $scoreUrl
    ]);
  }

  public function actionScore()
  {
      if (Yii::$app->user->isGuest) {
        Yii::$app->session->setFlash('error', 'Debes iniciar sesión para calificar');
        return $this->redirect(['site/login']);
      }
      $model = new BookScore();
      
      if ($model->load(Yii::$app->request->post())) {
          $model->user_id = Yii::$app->user->identity->id;
          
          Yii::info("Datos del modelo antes de la validación: " . print_r($model->attributes, true));
          
          if ($model->validate()) {
              Yii::info("Validación exitosa");
              if ($model->save()) {
                  Yii::info("Guardado exitoso");
                  Yii::$app->session->setFlash('success', 'Gracias por tu calificación');
              } else {
                  Yii::error("Error al guardar: " . print_r($model->errors, true));
                  Yii::$app->session->setFlash('error', 'Error al guardar la calificación: ' . json_encode($model->errors));
              }
          } else {
              Yii::error("Error de validación: " . print_r($model->errors, true));
              Yii::$app->session->setFlash('error', 'Datos de calificación inválidos: ' . json_encode($model->errors));
          }
      } else {
          Yii::error("No se pudo cargar el modelo con los datos POST");
          Yii::$app->session->setFlash('error', 'No se recibieron datos de calificación');
      }
  
      return $this->redirect(['book/detail', 'id' => $model->book_id]);
  }
  public function actionNew() {
    if(Yii::$app->user->isGuest) {
      return $this->goHome();
    }

    $book = new Book;

    if($book->load(Yii::$app->request->post())) {
      if($book->validate()) {
        if($book->save()) {
          Yii::$app->session->setFlash('success', 'libro creado');
          return $this->redirect(['book/all']);
        } else {
          throw new Exception("error al guardar el libro");
        }
      }
      $book->title = '';
      $book->author_id = '';
    }
    return $this->render('form.tpl', ['book' => $book]);
  }
  public function actionIOwnThisBook($book_id)
  {
    if (Yii::$app->user->isGuest) {
        Yii::$app->session->setFlash('warning', 'Debes iniciar sesión para añadir libros a tu colección');
        return $this->goHome();
    }

    $userId = Yii::$app->user->identity->id;

    // Verifica si ya existe el registro
    $existingRecord = UserBook::findOne(['user_id' => $userId, 'book_id' => $book_id]);
    
    if ($existingRecord) {
        Yii::$app->session->setFlash('warning', 'Este libro ya está en tu colección');
    } else {
        $ub = new UserBook();
        $ub->user_id = $userId;
        $ub->book_id = $book_id;

        if ($ub->validate()) {
            try {
                if ($ub->save(false)) { // false porque ya validamos
                    Yii::$app->session->setFlash('success', 'Libro añadido a tu colección');
                }
            } catch (\Exception $e) {
                Yii::error("Error al guardar UserBook: " . $e->getMessage());
                Yii::$app->session->setFlash('error', 'Error al añadir el libro a tu colección');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Error de validación: ' . implode(', ', $ub->getErrorSummary(true)));
        }
    }

    return $this->redirect(['book/detail', 'id' => $book_id]);
  }

}