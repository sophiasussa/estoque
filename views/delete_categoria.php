<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

require_once "controllers/CategoriaController.php";

if (isset($_GET["id"])) {
    $categoriaController = new CategoriaController();
    $categoriaController->delete($_GET["id"]);

    header("Location: ?pg=categorias");
}