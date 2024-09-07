<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;

use app\models\User;

class UserController extends Controller {

  public function actionNew($username, $password) {
    $user = new User;
    $user->username = $username;
    $user->setPassword($password);
    if($user->save()) {
      printf("new user ok, id: %d\n", $user->id);
    } else {
      printf("problema creando usuario\n");
      // Mostrar errores específicos
      print_r($user->getErrors());
    }
    return ExitCode::OK;
  }

  public function actionCheck($username, $password) {
    $user = User::findOne(['username' => $username]);
    if(!empty($user)) {
      if($user->validatePassword($password)) {
        printf("login valido\n");
        return ExitCode::OK;
      }
    }
    printf("login inválido\n");
    return ExitCode::OK;
  }

}
