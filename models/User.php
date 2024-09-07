<?php

namespace app\models;

use yii\db\ActiveRecord;
use Exception;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
/*    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;
*/
    public $password_repeat;
    public $email;
    public static function tableName() 
    {
        return 'users';
        //return {{%users}} //Prefijos de tabla. Esto permite que Yii2 maneje automáticamente los prefijos de tabla si los configuras
    }

    public function rules() {
        return [
            [['username', 'password'], 'required'],
            ['username', 'filter', 'filter' => function($v) {
                $v = ltrim(rtrim($v));
                $v = strtolower($v);
                return $v;
            }],
            ['username', 'unique'],
            ['username', 'string', 'length' => [3, 100]],
            ['password', 'compare', 'compareAttribute' => 'password_repeat'],
            ['password_repeat', 'default'],
            ['bio', 'default'],
            ['email', 'email'],
        ];
    }
        
    public function attributeLabels() {
        return 
        [
            'username' => 'usuario',
        ];
    }

    public function attributeHints () {
        return [
            'username' => 'deberá ser único en el sistema',
            'password_repeat' => 'tiene que ser igual al anterior',
        ];
    }    

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        //return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
        $user = self::findOne($id);
        if(empty($user)) {
            return null;
        }
        return $user;
        //return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $user = self::findOne(['token' => $token]);
        if(empty($user)) {
            return null;
        }
        return $user;
    }    
    // public static function findIdentityByAccessToken($token, $type = null)
    // {
    //     foreach (self::$users as $user) {
    //         if ($user['accessToken'] === $token) {
    //             return new static($user);
    //         }
    //     }

    //     return null;
    // }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $user = self::find()->where(['username' => $username])->one();
        if(empty($user)) {
            return null;
        }
        return $user;
    }
    public function hasBook($book_id): bool {
        $ub = UserBook::find()->where([
            'user_id' => $this->id,
            'book_id' => $book_id
        ])->all();
        if (empty($ub)) {
            return false;
        }
        return true;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->user_id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

        /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->email;
    }
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return password_verify($password, $this->password);
    }

    public function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    public function verifyPassword($inputPassword, $storedHash) {
        return password_verify($inputPassword, $storedHash);
    }

    public function getVotes() {
        return $this->hasMany(BookScore::class, ['user_id' => 'user_id'])->all();
      }
  
      public function getVotesCount() {
        return count($this->votes);
      }
  
      public function getVotesAvg() {
        $i = 0;
        $sum = 0;
        foreach($this->votes as $vote) {
          $i++;
          $sum += $vote->score;
        }
        if($i == 0) {
          return "sin votos";
        }
        return sprintf("%0.2f", $sum/$i);
      }

      public function hasVotedFor($book_id) {
        $bs = BookScore::find()
          ->where([
            'book_id' => $book_id,
            'user_id' => $this->id,
          ])
          ->one();
        if(empty($bs)) {
          return false;
        }
        return true;
      }
  
      public function getVoteForBook($book_id) {
        return $this->hasOne(BookScore::class, ['user_id' => 'user_id'])
        ->where(['book_id' => $book_id])
        ->one();
    }        
}
