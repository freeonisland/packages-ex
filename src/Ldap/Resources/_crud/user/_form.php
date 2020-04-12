<form action="<?= $action ?>" name="user_form" method="post">
    <input type="hidden" name="uid" value="<?=$user['cn'][0]?>"/>
    <?php foreach($user as $propertie => $value): ?>
        <div>
            <label for="<?= $propertie ?>"><?= $propertie ?></label>
            <input type="text" name="<?= $propertie ?>" value="<?= is_array($value)?implode(',',$value):$value ?>"/>
        </div>
    <?php endforeach; ?>
    <button type="submit"><?= 'create'==$_ctrl_action ? 'Create' : 'Update' ?> user</button>
</form>

