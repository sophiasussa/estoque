<?php
require_once "controllers/ProdutoController.php";
require_once "controllers/EstoqueController.php";

$produtoController = new ProdutoController();
$produtos = $produtoController->findAll();

if (isset($_GET["id"])) {
    $estoqueController = new EstoqueController();
    $estoque = $estoqueController->findById($_GET["id"]);
}

if (
    isset($_POST["produto_id"]) &&
    isset($_POST["quantidade"])
) {
    $produtoId = $_POST["produto_id"];
    $quantidade = $_POST["quantidade"];

    $produto = $produtoController->findById($produtoId);
    if ($produto) {
        $estoque = new Estoque(null, $produto, $quantidade);

        if (isset($_GET["id"])) {
            $estoque->setId($_GET["id"]);
            $estoqueController->update($estoque);
        } else {
            $estoqueController->save($estoque);
        }

        header("Location: ?pg=estoques");
        exit();
    } else {
        echo "Produto não encontrado.";
    }
}
?>

<div class="container mt-2">
    <h1 class="text-center mb-0">Adição de Estoque</h1>
    <form method="POST">

        <div class="form-group">
            <label for="produto_id">Produto</label>
            <select class="form-control" id="produto_id" name="produto_id">
                <?php foreach ($produtos as $produto): ?>
                    <option value="<?php echo $produto->getId(); ?>" 
                        <?php echo (isset($estoque) && $estoque->getProduto()->getId() == $produto->getId()) ? 'selected' : ''; ?>>
                        <?php echo $produto->getNome(); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="quantidade">Quantidade</label>
            <input type="number" class="form-control" id="quantidade" name="quantidade" value="<?php echo isset($estoque) ? $estoque->getQuantidade() : ''; ?>" required>
        </div>

        <input type="submit" class="btn btn-primary" id="salvar" name="salvar" value="Salvar">
    </form>
</div>
