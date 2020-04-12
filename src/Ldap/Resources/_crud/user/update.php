<h2>Update user</h2>
<?php 
    $action='/ldap/user/update/' . $user['cn'][0]; 
    $_ctrl_action = 'update'; 
    include __DIR__.'/_form.php';
?>
<a href="/ldap/user/list">Back to list</a>