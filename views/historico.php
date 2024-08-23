<?php
require_once "security/restrict.php";
require_once "controllers/HistoricoController.php";
require_once "controllers/UsuarioController.php";
require_once "controllers/AcaoController.php";


$historicoController = new HistoricoController();
$usuarioController = new UsuarioController();
$acaoController = new AcaoController();

$historicoList = $historicoController->obterHistorico();
?>
<div class="container mt-5">
    <h1 class="text-center mb-4">Historico do Estoque</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Data</th>
                <th>Quantidade</th>
                <th>Usuário</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($historicoList as $registro) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($registro['data']); ?></td>
                    <td><?php echo htmlspecialchars($registro['qtd']); ?></td>
                    <td><?php echo htmlspecialchars($registro['usuario']); ?></td>
                    <td><?php echo htmlspecialchars($registro['acao']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>