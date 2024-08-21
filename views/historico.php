<?php
require_once "controllers/HistoricoController.php";
require_once "controllers/UsuarioController.php";
require_once "controllers/AcaoController.php";


$historicoController = new HistoricoController();
$usuarioController = new UsuarioController();
$acaoController = new AcaoController();

$historicoList = $historicoController->getAllHistorico();

function getNomeUsuario($usuarioController, $id) {
    $usuario = $usuarioController->findById($id);
    return $usuario ? $usuario->getNome() : 'Desconhecido';
}

function getNomeAcao($acaoController, $id) {
    $acao = $acaoController->findById($id);
    return $acao ? $acao->getNome() : 'Desconhecida';
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Estoque</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style>
        body {
            background-image: url('../images/logistica.avif');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            margin-top: 30px;
        }

        .custom-heading {
            font-family: "Arial Black", sans-serif;
            font-size: 30px;
            font-weight: bold;
            color: #000;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center custom-heading">Histórico de Estoque</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Data e Hora</th>
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
                        <td><?php echo htmlspecialchars(getNomeUsuario($usuarioController, $registro['id_usuario'])); ?></td>
                        <td><?php echo htmlspecialchars(getNomeAcao($acaoController, $registro['id_acao'])); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>