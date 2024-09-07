<?php

namespace app\models;

use yii\db\ActiveRecord;

class UserBook extends ActiveRecord {
    public static function tableName() {
        return 'user_books';
    }
    public static function primaryKey()
    {
        return ['user_books_id'];
    }
    public function rules()
    {
        return [
            [['user_id', 'book_id'], 'required'],
            [['user_id', 'book_id'], 'integer'],
            [['created_at', 'modified_at'], 'safe'],
            [['user_id', 'book_id'], 'unique', 'targetAttribute' => ['user_id', 'book_id'], 'message' => 'Ya tienes este libro en tu colección.'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'user_books_id' => 'ID',
            'user_id' => 'User ID',
            'book_id' => 'Book ID',
            'created_at' => 'Created At',
            'modified_at' => 'Modified At',
        ];
    }
    public function getId() {
        return $this->user_books_id;
    }
}
