<?php
    if (isset($_SESSION['userId'])){
        header('Location: orders.php');
        die();
    }