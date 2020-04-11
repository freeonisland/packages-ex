<form action="<?= $action ?>" name="user_form" method="post">
    <?php foreach($user as $propertie => $value): ?>
        <div>
            <label for="user_<?= $propertie ?>"><?= $propertie ?></label>
            <input type="text" name="user_<?= $propertie ?>" value="<?= $value ?>"/>
        </div>
    <?php endforeach; ?>
    <button type="submit"><?= 'create'==$_ctrl_action ? 'Create' : 'Update' ?> user</button>
</form>

<script>
    
</script>