<?php // Connecting, selecting database
    include("config.ini");
    $link = mysqli_connect(HOST,USER,PASSWORD,DB);
    $query = 'DELETE FROM users WHERE id='.$_GET['id'];
    mysqli_query($link, $query) or die("Could not connect: ".mysqli_error($link));
    echo '<meta http-equiv="refresh" content="0;URL=admin_user.php">';
    mysqli_close($link);
?>
            