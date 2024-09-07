{use class="yii\widgets\ActiveForm" type="block"}
<h1>Crear Usuario</h1>

{ActiveForm id="new-user" assign="form"}
    {$form->field($user, 'username')}
    {$form->field($user, 'email')}
    {$form->field($user, 'password')->passwordInput()}
    {$form->field($user, 'password_repeat')->passwordInput()}
    {$form->field($user, 'bio')->textArea()}
    <button type="submit" name="submit">Guardar</button>
{/ActiveForm}