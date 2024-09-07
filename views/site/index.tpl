{use class="Yii"}
{use class='yii\helpers\Html'}
{use class="app\models\Book"}

<h1>Indice de sitio</h1>

{if Yii::$app->user->isGuest}
  Hola invitado, {Html::a('login', ['site/login'])}
{else}
  {assign "user" Yii::$app->user->identity}
  <p>hola {$user->username} 👋</p>
  <p>has votado {$user->votesCount} veces y
    promedio de {$user->votesAvg}</p>
{/if}

<p>
  {if isset($book_count)}
    Hay {Html::a("{$book_count} libros", ['book/all'])}
  {/if}
  {if isset($author_count)}
    y {Html::a("{$author_count} autores", ['author/all'])}
  {/if}
  registrados en el sistema.
</p>
<h3>Acciones:</h3>
<ul>
  <li>{Html::a('Crear libro', ['book/new'])}</li>
  <li>{Html::a('Agregar autor', ['author/new'])}</li>
</ul>
