<?php
require_once "models/Acao.php";
require_once "models/Conexao.php";

class AcaoController {

    public function findById($id) {
        try {
            $conexao = Conexao::getInstance();
            $stmt = $conexao->prepare("SELECT * FROM acao WHERE id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($resultado) {
                return new Acao(
                    $resultado["id"],
                    $resultado["nome"]
                );
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Erro ao buscar a ação: " . $e->getMessage();
            return null;
        }
    }

}