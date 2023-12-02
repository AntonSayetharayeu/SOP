<div class="container">
    <?php
    if (isset($_POST['userId']))
        load_user_info($_POST['userId']);
    else
        load_user_info($_SESSION['u_id']);
    ?>
</div>