<?php
require_once "security/restrict.php";
require_once "controllers/CategoriaController.php";

if (isset($_GET["id"])) {
    $categoriaController = new CategoriaController();
    $categoriaController->delete($_GET["id"]);

    header("Location: ?pg=categorias");
}