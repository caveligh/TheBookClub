{use class="yii\helpers\Html"}

<h1>Todos los libros</h1>

<ol>
    {foreach $books as $book}
    <Li>{Html::a($book->toString(),
      ['book/detail', 'id' => $book->id])}
    </li>
    {/foreach}
</ol>
