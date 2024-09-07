<?php

namespace app\models;

use yii\db\ActiveRecord;

class Book extends ActiveRecord 
{
    public static function tableName() 
    {
        return 'books';
    }

    public function getId() {
      return $this->book_id;
    }

    public function rules()
    {
      return [
        [['title', 'author_id'], 'required'],
        [['author_id'], 'integer'],
        [['title'], 'string', 'max' => 255],
      ];
    }
    
    public function attributeLabels()
    {
      return [
        'book_id' => 'ID',
        'title' => 'Título',
        'author_id' => 'ID del Autor',
      ];
    }
    public function getTitle() 
    {
        return $this->title;
    }

    public function getAuthor() 
    {
        return $this
        //                         author.author_id / book.author_id
          ->hasOne(Author::class, ['author_id' => 'author_id'])
          ->one();
    }
    public function toString() {
      return sprintf("(%d) %s - %s",
        $this->id,
        $this->title,
        $this->author ? $this->author->name : 'Desconocido'
      ) ;
    }
    public function getVotes() {
      return $this->hasMany(BookScore::class, ['book_id' => 'book_id'])
        ->all();
    }
  
    public function getScore():string {
      $i = 0;
      $sum = 0;
      foreach($this->votes as $vote) {
        $i++;
        $sum += $vote->score;
      }
  
      if($i == 0) {
        return "Sin votos";
      }
      return sprintf("%0.2f (%d votos)", $sum/$i, $i);
    }
  }