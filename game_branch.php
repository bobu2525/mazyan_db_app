<?php

if(isset($_POST['game_result'])==true)
{
    header('Location:game_result.php');
    exit();
}

if(isset($_POST['seiseki'])==true)
{
    header('Location:kensaku.php');
    exit();
}

?>