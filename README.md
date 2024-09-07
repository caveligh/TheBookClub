# The Book Club

The Book Club es una aplicación web desarrollada con Yii2 que permite a los usuarios gestionar y compartir información sobre libros, autores y calificaciones.

## Características

- Gestión de libros: Añadir, editar y eliminar libros.
- Gestión de autores: Añadir, editar y eliminar autores.
- Sistema de calificación: Los usuarios pueden calificar los libros.
- Colección personal: Los usuarios pueden marcar libros como propios.
- Búsqueda de libros y autores.

## Imagenes
![Login](https://i.ibb.co/ftMhqsZ/login.jpg "Login")
![Indice](https://i.ibb.co/ch8sWbW/index.jpg "Indice")
![All_Books](https://i.ibb.co/LnYFyPR/books.jpg "All_Books")
![Book_id](https://i.ibb.co/vBD54sB/book-203.jpg "Book_id")
![Book_id_vote](https://i.ibb.co/4tJ8wrp/book-4-vote.jpg "Book_id_vote")
![Book_id_point](https://i.ibb.co/fNVHzmt/book-4.jpg "Book_id_point")
![All_Autores](https://i.ibb.co/HVbTM8T/autores.jpg "All_Autores")
![Autor](https://i.ibb.co/bFhBMX7/autor-145.jpg "Autor")


## Requisitos

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Composer

## Instalación

1. Clona el repositorio:

## Estructura del Directorio

      assets/       contiene la definición de assets
      commands/     contiene los comandos de la consola (controladores)
      config/       contiene configuraciones de aplicaciones
      controllers/  contiene clases de controladores Web
      mail/         contiene archivos de vista para correos electrónicos
      models/       contiene clases de modelos
      runtime/      contiene archivos generados durante el tiempo de ejecución
      tests/        contiene varios tests para la aplicación básica
      vendor/       contiene paquetes dependientes de terceros
      views/        contiene archivos de vistas para la aplicación Web
      web/          contiene el script de entrada y los recursos Web
      


## Requerimientos

El requisito mínimo de esta plantilla de proyecto es que su servidor Web soporte PHP 7.4.


## Installation
------------

### Install via Composer

Si no dispone de [Composer](https://getcomposer.org/), puede instalarlo siguiendo las instrucciones
en [getcomposer.org](https://getcomposer.org/doc/00-intro.md#installation-nix).

A continuación, puede instalar esta plantilla de proyecto utilizando el siguiente comando:

~~~
composer create-project --prefer-dist yiisoft/yii2-app-basic basic
~~~

Ahora deberías poder acceder a la aplicación a través de la siguiente URL, asumiendo que `basic` es el directorio directamente bajo la raíz Web.

~~~
http://localhost/basic/web/
~~~

### Install from an Archive File

Extraiga el archivo descargado de [yiiframework.com](https://www.yiiframework.com/download/) a un directorio llamado `basic` que esté directamente bajo la raíz de la Web.

Establezca la clave de validación de cookies en el archivo `config/web.php` en una cadena secreta aleatoria:

```php
'request' => [
    // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
    'cookieValidationKey' => '<secret random string goes here>',
],
```

A continuación, puede acceder a la aplicación a través de la siguiente URL:

~~~
http://localhost/basic/web/
~~~


### Install with Docker

Actualice sus paquetes de proveedores

    docker-compose run --rm php composer update --prefer-dist
    
Ejecute los activadores de instalación (creación de código de validación de cookies)

    docker-compose run --rm php composer install    
    
Iniciar el contenedor

    docker-compose up -d
    
A continuación, puede acceder a la aplicación a través de la siguiente URL:

    http://127.0.0.1:8000

**NOTAS:** 
- Versión mínima requerida del motor Docker `17.04` para el desarrollo (véase [Performance tuning for volume mounts](https://docs.docker.com/docker-for-mac/osxfs-caching/))
- La configuración por defecto utiliza un host-volumen en su directorio home `.docker-composer` para las cachés de composer


## Configuration
-------------

### Database

Edite el archivo `config/db.php` con datos reales, por ejemplo:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

**NOTAS:**
- Yii no creará la base de datos por ti, esto tiene que hacerse manualmente antes de que puedas acceder a ella.
- Compruebe y edite los demás archivos del directorio `config/` para personalizar su aplicación según sea necesario.
- Consulte el archivo README del directorio `tests` para obtener información específica sobre las pruebas de aplicaciones básicas.


## Pruebas

Las pruebas se encuentran en el directorio `tests`. Se desarrollan con [Codeception PHP Testing Framework](https://codeception.com/). 
Por defecto, hay 3 conjuntos de pruebas:

- `unit`
- `functional`
- `acceptance`

Las pruebas pueden ejecutarse ejecutando

```
vendor/bin/codecept run
```

El comando anterior ejecutará pruebas unitarias y funcionales. 
Las pruebas unitarias prueban los componentes del sistema, mientras que las pruebas funcionales 
prueban la interacción con el usuario. Las pruebas de aceptación están deshabilitadas por defecto 
ya que requieren una configuración adicional puesto que realizan pruebas en el navegador real.


### Ejecución de pruebas de aceptación

Para ejecutar pruebas de aceptación haga lo siguiente: 

1. Cambie el nombre de `tests/acceptance.suite.yml.example` a `tests/acceptance.suite.yml` para activar la configuración de la suite

2. Sustituir `codeception/base` paquete en `composer.json` con `codeception/codeception` para instalar la versión completa de Codeception

3. Actualizar dependencias con Composer 

    ```
    composer update  
    ```

4. Descargar [Selenium Server](https://www.seleniumhq.org/download/) y lánzarlo:

    ```
    java -jar ~/selenium-server-standalone-x.xx.x.jar
    ```

    En caso de utilizar Selenium Server 3.0 con el navegador Firefox desde v48 o Google Chrome desde v53 debe descargar [GeckoDriver](https://github.com/mozilla/geckodriver/releases) or [ChromeDriver](https://sites.google.com/a/chromium.org/chromedriver/downloads) y lanzar Selenium con él:

    ```
    # for Firefox
    java -jar -Dwebdriver.gecko.driver=~/geckodriver ~/selenium-server-standalone-3.xx.x.jar
    
    # for Google Chrome
    java -jar -Dwebdriver.chrome.driver=~/chromedriver ~/selenium-server-standalone-3.xx.x.jar
    ``` 
    
    Como alternativa se puede utilizar un contenedor Docker ya configurado con versiones anteriores de Selenium y Firefox:
    
    ```
    docker run --net=host selenium/standalone-firefox:2.53.0
    ```

5. (Opcional) Crea la base de datos `yii2basic_test` y actualizala aplicando migraciones si las tienes.

   ```
   tests/bin/yii migrate
   ```

   La configuración de la base de datos se encuentra en `config/test_db.php`.


6. Inicie el servidor web:

    ```
    tests/bin/yii serve
    ```

7. Ahora puede ejecutar todas las pruebas disponibles

   ```
   # run all available tests
   vendor/bin/codecept run

   # run acceptance tests
   vendor/bin/codecept run acceptance

   # run only unit and functional tests
   vendor/bin/codecept run unit,functional
   ```

### Cobertura del código

Por defecto, la cobertura de código está desactivada en el archivo de configuración `codeception.yml`, 
debe descomentar las filas necesarias para poder recopilar la cobertura de código. 
Puede ejecutar sus pruebas y recopilar la cobertura con el siguiente comando:

```
#collect coverage for all tests
vendor/bin/codecept run --coverage --coverage-html --coverage-xml

#collect coverage only for unit tests
vendor/bin/codecept run unit --coverage --coverage-html --coverage-xml

#collect coverage for unit and functional tests
vendor/bin/codecept run functional,unit --coverage --coverage-html --coverage-xml
```

Puede ver los resultados de la cobertura del código en el directorio `tests/_output`.
=======
# TheBookClub
Portal Web con informacion de un Club de Lectores
>>>>>>> e00630f918bb54ae060bd915307534acb1f424f4
