<?php
require_once dirname(__DIR__) . "/models/Conexao.php";
require_once dirname(__DIR__) . "/models/Usuario.php";

class UsuarioController {
    public function login($login, $senha)
    {
        try {
            $conexao = Conexao::getInstance();
            $stmt = $conexao->prepare("SELECT *
            FROM usuario WHERE login = :login");
            $stmt->bindParam(":login", $login);
            $stmt->execute();

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($resultado) {
                $usuario = new Usuario(
                    $resultado["id"],
                    $resultado["nome"],
                    $resultado["login"],
                    $resultado["senha"]
            );
                if ($senha===$usuario->getSenha()) {
                    unset($_SESSION['id_usuario']);
                    $_SESSION['id_usuario'] = $usuario->getId();
                    
                    header("Location: ../index.php");
                } else {
                    $_SESSION['mensagem'] = 'Senha incorreta';
                    return false;
                }
            } else {
                $_SESSION['mensagem'] = 'Usuário não encontrado';
                return false;
            }
        } catch (PDOException $e) {
            echo "Erro ao buscar a usuario: " . $e->getMessage();
        }
    }

    public function cadastrar($login, $nome, $senha)
    {
        try {
            $conexao = Conexao::getInstance();
            $stmt = $conexao->prepare("SELECT COUNT(*) FROM usuario WHERE login = :login");
            $stmt->bindParam(":login", $login);
            $stmt->execute();
    
            $count = $stmt->fetchColumn();
            
            if ($count > 0) {
                $_SESSION['mensagem'] = 'Login já está em uso.';
                return false;
            }
    
            $stmt = $conexao->prepare("INSERT INTO usuario (nome, login, senha) VALUES (:nome, :login, :senha)");
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":login", $login);
            $stmt->bindParam(":senha", $senha);

            $stmt->execute();
            header("Location: ../index.php");
            exit();
    
        } catch (PDOException $e) {
            echo"Erro ao cadastrar o usuário: " . $e->getMessage();
        }
    }

    public function logout() {
        unset($_SESSION["id_usuario"]);
        session_destroy();
        header("Location: views/login.php");
        exit();
    }

    public function findById($id) {
        try {
            $conexao = Conexao::getInstance();
            $stmt = $conexao->prepare("SELECT * FROM usuario WHERE id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($resultado) {
                return new Usuario(
                    $resultado["id"],
                    $resultado["nome"],
                    $resultado["login"],
                    $resultado["senha"]
                );
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Erro ao buscar o usuário: " . $e->getMessage();
            return null;
        }
    }
}