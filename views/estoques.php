<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

require_once "controllers/ProdutoController.php";
require_once "controllers/EstoqueController.php";

$produtoController = new ProdutoController();
$estoqueController = new EstoqueController();
$produtos = $produtoController->findAll();

if (isset($_SESSION['mensagem'])) {
    echo "<script>alert('" . $_SESSION['mensagem'] . "')</script>";
    unset($_SESSION['mensagem']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $produtoId = $_POST['produto_id'];
    $quantidade = $_POST['quantidade'];
    $acao = $_POST['acao'];

    if ($acao == 'adicionar') {
        $estoqueController->addEstoque($produtoId, $quantidade);
    } elseif ($acao == 'remover') {
        $estoqueController->removeEstoque($produtoId, $quantidade);
    }
}
?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Gerenciamento de Estoque</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Categoria</th>
                <th>Preço</th>
                <th>Quantidade em Estoque</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produtos as $produto) : ?>
                <?php
                    $estoque = $estoqueController->findByProdutoId($produto->getId());
                    $quantidadeEstoque = $estoque != null ? $estoque->getQuantidade() : 0;
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($produto->getId()); ?></td>
                    <td><?php echo htmlspecialchars($produto->getNome()); ?></td>
                    <td><?php echo htmlspecialchars($produto->getDescricao()); ?></td>
                    <td><?php echo htmlspecialchars($produto->getCategoria()->getNome()); ?></td>
                    <td><?php echo htmlspecialchars($produto->getPreco()); ?></td>
                    <td><?php echo htmlspecialchars($quantidadeEstoque); ?></td>
                    <td>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="produto_id" value="<?php echo $produto->getId(); ?>">
                            <input type="number" name="quantidade" placeholder="Quantidade" class="form-control mb-2" required>
                            <button type="submit" name="acao" value="adicionar" class="btn btn-success mb-2">Adicionar</button>
                            <button type="submit" name="acao" value="remover" class="btn btn-danger mb-2">Remover</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>