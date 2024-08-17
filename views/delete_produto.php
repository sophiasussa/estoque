<?php
require_once "security/restrict.php";
require_once "controllers/ProdutoController.php";

if (isset($_GET["id"])) {
    $produtoController = new ProdutoController();
    $produtoController->delete($_GET["id"]);

    header("Location: ?pg=produtos");
}