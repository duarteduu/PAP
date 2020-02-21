<?php
    if(!$_SESSION['isAdmin']){
        header('Location: orders.php');
    }