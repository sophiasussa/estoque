<?php
class Historico {
    private $id;
    private $data;
    private $qtd;
    private $usuario;
    private $acao;

    function __construct(
        $id,
        $data,
        $qtd,
        Usuario $usuario,
        Acao $acao,
    ){
        $this->id = $id;
        $this->data = $data;
        $this->qtd = $qtd;
        $this->usuario = $usuario;
        $this->acao = $acao;
    }

    function getId(){
        return $this->id;
    }
    function setId($id){
        $this->id = $id;
    }

    function getData(){
        return $this->data;
    }
    function setData($data){
        $this->data = $data;
    }

    function getQtd(){
        return $this->qtd;
    }
    function setQtd($qtd){
        $this->qtd = $qtd;
    }

    function getUsuario(){
        return $this->usuario;
    }
    function setUsuario(Usuario $usuario){
        $this->usuario = $usuario;
    }

    function getAcao(){
        return $this->acao;
    }
    function setAcao(Acao $acao){
        $this->acao = $acao;
    }
}