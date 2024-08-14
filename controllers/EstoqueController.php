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

    public function findByProdutoId($id){
        try{
            $conexao = Conexao::getInstance();
            
            $stmt = $conexao->prepare("SELECT * FROM estoque WHERE id_produto = :id");
            $stmt->bindParam(":id", $id);
            
            $stmt->execute();
            
            $produtoController = new ProdutoController();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($resultado === false) {
                return null;
            }else{
                $estoque = new Estoque($resultado["id"], $produtoController->findById($resultado["id_produto"]), $resultado["quantidade"]);
                return $estoque;
            }
        }catch (PDOException $e){
            echo "Erro ao buscar o estoque: " . $e->getMessage();
        }
    }

    public function addEstoque($id, $quantidade){
        try{
          
            $estoque =$this->findByProdutoId($id);
            
            if($estoque == null){
                $conexao = Conexao::getInstance();
                $stmt = $conexao->prepare("INSERT INTO estoque (id_produto, quantidade) VALUES (:id, :quantidade)");
                $stmt->bindParam(":id",  $id);
                $stmt->bindParam(":quantidade", $quantidade);
    
                $stmt->execute();
    
                $_SESSION['mensagem'] = 'Estoque adicionado com sucesso!';

                echo '<script type="text/javascript">
                window location = "?pg=estoques";
                </script>';
            }else{

                $conexao = Conexao::getInstance();
                $stmt = $conexao->prepare("UPDATE estoque SET quantidade = quantidade + :quantidade WHERE id_produto = :id");
                $stmt->bindParam(":id", $id);
                $stmt->bindParam(":quantidade", $quantidade);

                $stmt->execute();

                echo '<script type="text/javascript">
                        window location = "?pg=estoques";
                        </script>';
            }
        }catch(PDOException $e){
            echo 'Erro ao adicionar estoque' . $e->getMessage();
        }
    }

    public function removeEstoque($id, $quantidade){
        try{
            $conexao = Conexao::getInstance();
            $estoque = $this->findByProdutoId($id);
           
            if($estoque->getQuantidade() < $quantidade){
                echo 'Quantidade indisponível em estoque';
                return;
            }

            $stmt = $conexao->prepare("UPDATE estoque SET quantidade = quantidade - :quantidade WHERE id_produto = :id");
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":quantidade", $quantidade);

            $stmt->execute();

            echo '<script type="text/javascript">
                    window location = "?pg=estoques";
                    </script>';
        }catch(PDOException $e){
            echo 'Erro ao adicionar estoque' . $e->getMessage();
        }
    }
}