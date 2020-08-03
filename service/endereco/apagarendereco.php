<?php

/*
Vamos construir os cabeçalhos para o trabalho com a api
*/

header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json;charset=utf-8");

/*
Para deletaros dados no banco é preciso
informar na api que essa ação ira ocorrer com o método DELETE, que
é responsável pela deleção de dados da api
*/
header("Access-Control-Allow-Methods:DELETE");

include_once "../../config/database.php";

include_once "../../domain/endereco.php";

$database = new Database();
$db = $database->getConnection();

$endereco = new Endereco($db);

/*
O cliente ira enviar os dados no formato Json. Porém
nós precisamos dos dados no formato php para cadastrar em
banco de dados.
Para realizar essa conversão iremos usar o comando json_decode
Assim o cliente envia os dados e estes serão convertidos para php.
*/

$data = json_decode(file_get_contents("php://input"));

/*
Verificar se os dados vindos do usuário estão preenchidos
*/
if(!empty($data->idendereco)){

    $endereco->idendereco = $data->idendereco;

    if($endereco->apagarEndereco()){
        header("HTTP/1.0 200");
        echo json_encode(array("mensagem"=>"Endereço apagado com sucesso!"));
    }
    else{
        header("HTTP/1.0 400");
        echo json_encode(array("mensagem"=>"Não foi possível apagar o endereço"));
    }
}
else{
    header("HTTP/1.0 400");
    echo json_encode(array("mensagem"=>"Você precisa preencher todos os campos"));
}

?>