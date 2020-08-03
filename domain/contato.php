<?php

class Contato{
    public $idcontato;
    public $email;
    public $telefone;

    public function __construct($db){
        $this->conexao = $db;
    }

    /*
    Função para listar todos os contatos cadastrados no banco de dados.
    */
    public function listar(){
        $query = "select * from contato";
        /*
        Será criada a variável stmt(Statement - Sentença)
        par guardar a preparação da consulta select que será executada
        posteriormente
        */
        $stmt = $this->conexao->prepare($query);

        //Executar a consulta e retornar os seus dados.
        $stmt->execute();

        return $stmt;
    }

    public function cadastro(){
        $query = "insert into contato set email=:e, telefone=:t";

        $stmt = $this->conexao->prepare($query);

        /*Vamos vincular os dados que veem do app ou navegador com os campos de
        banco de dados
        */
        $stmt->bindParam(":e",$this->email);
        $stmt->bindParam(":t",$this->telefone);

        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }

    }  

    public function apagarContato(){
        $query = "delete from contato where idcontato=:id";

        $stmt = $this->conexao->prepare($query);

        /*Vamos vincular os dados que veem do app ou navegador com os campos de
        banco de dados
        */
        $stmt->bindParam(":id",$this->idcontato);

        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }
    public function alterarContato(){
        $query = "update contato set email=:e, telefone=:t where idcontato=:id ";

        $stmt = $this->conexao->prepare($query);

        /*Vamos vincular os dados que veem do app ou navegador com os campos de
        banco de dados
        */      
        $stmt->bindParam(":e",$this->email);
        $stmt->bindParam(":t",$this->telefone);
        $stmt->bindParam(":id",$this->idcontato);
        
        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }
}



?>