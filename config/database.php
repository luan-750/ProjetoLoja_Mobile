<?php

/*
A classe database ira permitir a comunicação com o banco de dados.

Nesta classe teremos a string de conexão com o banco, bem com:
- Nome de usuário: "root"
- Senha: "" -> Vazio
- Banco de dados: dbloja
- Porta de comunicação: 3306
- Servidor: localhost

E uma variável para a conexão do banco que será usada em outros arquivos. Portanto 
essa varável deve ser pública.
*/

class Database{
    public $conexao;
    public function getConnection(){
        try{
            $conexao = new PDO("mysql:host=localhost;port=3306;dbname=dbloja","root","");
            // Definir o tipo de caracter para banco de dados no formato de utf8
            $conexao->exec("set name utf8");
        }
        catch(PDOException $e){
            echo "Erro a estabelecer a conexão com o banco. "+$e->getMessage();
        }
        return $conexao;
    }
}



?>