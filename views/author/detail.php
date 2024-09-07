<?php

use yii\helpers\Html;

?>
<h1><?= $authorvw->toString() ?></h1>


<p>La cantidad total de tus obras es:
  <?= $authorCount ?>
</p>
<p>El promedio de todas sus obras es:
  <?= $authorvw->score ?>
</p>

<h2>Libros:</h2>
<ol>
<?php foreach($authorvw->books as $book) {?>
  <li>
    <?= Html::a($book->title, ['book/detail', 'id' => $book->id]) ?>
    <?= $book->author->getScore($book->id) ?>
  </li>
<?php } ?>
</ol>
