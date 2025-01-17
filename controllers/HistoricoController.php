<?php
require_once "models/Conexao.php";

class HistoricoController {

    public function registrarHistorico($produtoId, $quantidade, $usuarioId, $acaoId)
    {
        try {
            $conexao = Conexao::getInstance();
            $stmt = $conexao->prepare("
                INSERT INTO historico (data, qtd, id_usuario, id_acao)
                VALUES (NOW(), :quantidade, :usuarioId, :acaoId)
            ");
            $stmt->bindParam(":quantidade", $quantidade);
            $stmt->bindParam(":usuarioId", $usuarioId);
            $stmt->bindParam(":acaoId", $acaoId);

            $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao registrar o histórico: " . $e->getMessage();
        }
    }

    public function obterHistorico()
    {
        try {
            $conexao = Conexao::getInstance();
            $stmt = $conexao->prepare("
                SELECT h.data, h.qtd, u.nome AS usuario, a.nome AS acao
                FROM historico h
                JOIN usuario u ON h.id_usuario = u.id
                JOIN acao a ON h.id_acao = a.id
                ORDER BY h.data DESC
            ");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao buscar o histórico: " . $e->getMessage();
        }
    }
}