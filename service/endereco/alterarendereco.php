<?php

/*
Vamos construir os cabeçalhos para o trabalho com a api
*/

header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json;charset=utf-8");

/*
Para efetuar cadastro de dados no banco é preciso
informar na api que essa ação ira ocorrer com o método PUT, que
é responsável pela atualização de dados da api
*/
header("Access-Control-Allow-Methods:PUT");

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
if(!empty($data->idendereco) &&!empty($data->tipo) && !empty($data->logradouro) && !empty($data->numero) && !empty($data->complemento) && !empty($data->bairro) && !empty($data->cep)){

    $endereco->idendereco = $data->idendereco;
    $endereco->tipo = $data->tipo;
    $endereco->logradouro = $data->logradouro;
    $endereco->numero = $data->numero;
    $endereco->complemento = $data->complemento;
    $endereco->bairro = $data->bairro;
    $endereco->cep = $data->cep;

    if($endereco->alterarEndereco()){
        header("HTTP/1.0 201");
        echo json_encode(array("mensagem"=>"Endereço alterado com sucesso!"));
    }
    else{
        header("HTTP/1.0 400");
        echo json_encode(array("mensagem"=>"Não foi possível alterar o endereço"));
    }
}
else{
    header("HTTP/1.0 400");
    echo json_encode(array("mensagem"=>"Você precisa preencher todos os campos"));
}

?>