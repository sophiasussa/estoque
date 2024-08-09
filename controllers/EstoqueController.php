<?php
require_once "models/Estoque.php";
require_once "controllers/ProdutoController.php";

class EstoqueController{

    public function findById($id){
        try{
            $conexao = Conexao::getInstance();
            
            $stmt = $conexao->prepare("SELECT * FROM estoque WHERE id = :id");
            $stmt->bindParam(":id", $id);
            
            $stmt->execute();
            
            $produtoController = new ProdutoController();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($resultado === false) {
                return null;
            }

        
            $estoque = new Estoque($resultado["id"], $produtoController->findById($resultado["id_produto"]), $resultado["quantidade"]);
            
            return $estoque;
        }catch (PDOException $e){
            echo "Erro ao buscar o estoque: " . $e->getMessage();
        }
    }

    public function save(Estoque $estoque) {
        try {
            $conexao = Conexao::getInstance();
            $stmt = $conexao->prepare("INSERT INTO estoque (id_produto, quantidade) VALUES (:id_produto, :quantidade)");
            $stmt->bindParam(":id_produto", $estoque->getProduto()->getId());
            $stmt->bindParam(":quantidade", $estoque->getQuantidade());

            $stmt->execute();

            $_SESSION['mensagem'] = 'Estoque adicionado com sucesso!';
        } catch(PDOException $e) {
            echo 'Erro ao adicionar estoque: ' . $e->getMessage();
        }
    }
    

    public function addEstoque($id, $quantidade){
        try{
            $conexao = Conexao::getInstance();
            $stmt = $conexao->prepare("UPDATE estoque SET quantidade = quantidade + :quantidade WHERE id = :id");
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":quantidade", $quantidade);

            $stmt->execute();

            echo '<script type="text/javascript">
                    window location = "?pgestoques";
                    </script>';
        }catch(PDOException $e){
            echo 'Erro ao adicionar estoque' . $e->getMessage();
        }
    }

    public function removeEstoque($id, $quantidade){
        try{
            $conexao = Conexao::getInstance();
            $estoque = findbyId($id);
            if($estoque->getQuantidade() < $quantidade){
                echo 'Quantidade indisponível em estoque' . $e->getMessage();
                return;
            }

            $stmt = $conexao->prepare("UPDATE estoque SET quantidade = quantidade - :quantidade WHERE id = :id");
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":quantidade", $quantidade);

            $stmt->execute();

            echo '<script type="text/javascript">
                    window location = "?pgestoques";
                    </script>';
        }catch(PDOException $e){
            echo 'Erro ao adicionar estoque' . $e->getMessage();
        }
    }
}