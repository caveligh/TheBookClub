<?php

namespace app\models;

use yii\db\ActiveRecord;

class BookScore extends ActiveRecord {

  public static function tableName() {
    return 'book_scores';
  }

  public function getId() {
    return $this->book_score_id;
  }

  public function rules() {
    return [
      [['score', 'book_id'], 'required'],
      [['score', 'book_id', 'user_id'], 'integer'],
      ['score', 'in', 'range' => [1, 2, 3, 4, 5]],
 //     [['book_id', 'user_id'], 'exist', 'skipOnError' => true],
    ];
  }

  public function attributeLabels() {
    return [
      'book_score_id' => 'ID',
      'score' => 'Puntuación',
      'book_id' => 'Libro',
      'user_id' => 'Usuario',
    ];
  }

  // Relaciones si las necesitas
  public function getBook() {
    return $this->hasOne(Book::class, ['id' => 'book_id']);
  }

  public function getUser() {
    return $this->hasOne(User::class, ['id' => 'user_id']);
  }
}