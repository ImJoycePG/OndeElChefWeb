<?php
session_start();
if (!isset($_SESSION['dni'])) {
    header('Location: ../../login.html');
    exit();
}

?>