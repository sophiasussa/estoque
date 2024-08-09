<?php
require_once "controllers/EstoqueController.php";

if (isset($_GET["id"])) {
    $estoqueController = new EstoqueController();
    $estoqueController->delete($_GET["id"]);

    header("Location: ?pg=estoques");
    exit();
}
?>