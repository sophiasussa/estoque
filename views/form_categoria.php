<?php
require_once "security/restrict.php";
require_once "controllers/CategoriaController.php";

if (isset($_GET["id"])) {
	$categoriaController = new CategoriaController();
	$categoria = $categoriaController->findById($_GET["id"]);
}

if (
	isset($_POST["nome"])
) {
	$categoriaController = new CategoriaController();

	$categoria = new Categoria(null, $_POST["nome"]);

	if (isset($_GET["id"])) {
		$categoria->setId($_GET["id"]);
		$categoriaController->update($categoria);
	} else {

		$categoriaController->save($categoria);
	}

	header("Location: ?pg=categorias");

	exit();
}

?>

<div class="container mt-2">
	<h1 class="text-center mb-0">Cadastro de Categoria</h1>
	<form method="POST">

		<div class="form-group">
			<label for="nome">Nome</label>
			<input type="text" class="form-control" id="nome" name="nome" value="<?php echo isset($categoria) ? $categoria->getNome() : ''; ?>">
		</div>
		<input type="submit" class="btn btn-primary" id="salvar" name="salvar" value="Salvar">
	</form>
</div>