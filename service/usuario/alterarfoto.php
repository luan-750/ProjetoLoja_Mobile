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

include_once "../../domain/usuario.php";

$database = new Database();
$db = $database->getConnection();

$usuario = new Usuario($db);

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
if(!empty($data->idusuario) && !empty($data->foto)){

    $usuario->foto = $data->foto;
    $usuario->idusuario = $data->idusuario;

    if($usuario->alterarFoto()){
        header("HTTP/1.0 201");
        echo json_encode(array("mensagem"=>"Foto alterada com sucesso!"));
    }
    else{
        header("HTTP/1.0 400");
        echo json_encode(array("mensagem"=>"Não foi possível alterar a foto"));
    }
}
else{
    header("HTTP/1.0 400");
    echo json_encode(array("mensagem"=>"Você precisa preencher todos os campos"));
}

?>