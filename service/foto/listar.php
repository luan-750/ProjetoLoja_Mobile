<?php

/*
Vamos criar um Header, ou seja, um cabeçalho.
Este cabeçalho permite o acesso a listagem de usuarios com diversas origens.
Por isso estamos usando o *(asterisco) para essa permissão que será para
 - http
 - https
 - file
 - ftp
*/
header("Access-Control-Allow-Origin:*");

/*
Vamos definir qual será o formato de dados que o cliente ira enviar e
receber em ralação a api. Este formato será do tipo JSON(Javascript on
Notation)
*/
header("Content-Type: application/json;charset=utf-8");

/*
Abaixo estamos incluindo o arquivo database.php que possui a
classe Database com a conexão com o banco de dados.
*/

include_once "../../config/database.php";

/*
O arquivo foto.php será incluido para que a classe Foto
seja usada. Vale lembrar que esta classe possui o CRUD 
*/
include_once "../../domain/foto.php";

/*
Criamos um objeto chamado $database. É uma instância da classe Database
que está na pasta config e isso nos dará acesso a todo o seu conteudo
publico.
*/

$database = new Database();

/*
Executar a função que está dentro do database chamada getConnection, pois
esta função realiza a conexao com o banco de dados
*/

$db = $database->getConnection();

/*
Vamos fazer uma instância da classe foto para ter acesso a todo 
o seu conteúdo.
*/


$foto = new Foto($db);

$rs = $foto->listar();

/*
Vamos construir uma estrutura exibir os dados do banco no formato de
json.
Como esses dados estão dispostos em linhas e colunas, nós precisaremos
criar um array para exibir todos os dados corretamente
*/

if($rs->rowCount()>0){
    $foto_arr["saida"] = array();
/*
A estrutura while(enquanto) realiza a busca de todos as fotos cadastradas
até chegar ao final da tabela e tras os dados para fetch array organizar
em formato de array.
Assim será mais fácil de adicionar no array de foto para apresentar
ao final
*/
    while($linha = $rs->fetch(PDO::FETCH_ASSOC)){
        
        /*
        O comando extract é capaz de separar de forma mais simples os
        campos da tabela fotos
        */
        extract($linha);
        $array_item = array(
            "idfoto"=>$idfoto,
            "foto1"=>$foto1,
            "foto2"=>$foto2,
            "foto3"=>$foto3,
            "foto4"=>$foto4
        );

        array_push($foto_arr["saida"],$array_item);

    }
    
    header("HTTP/1.0 200");
    echo json_encode($foto_arr);
}
else{
    header("HTTP/1.0 400");
    echo json_encode(array("mensagem"=>"Não há fotos cadastradas"));
}

?>