<?php

//$config=require_once "./init.php";



echo "<br/> <br/> <br/> <br/> <br/> <br/> <br/> <br/>"


?>



$url="http://192.168.101.24:8080/api/public/log-in";
$data=array("userName"=>"admin","userPassword"=>"admin");
$options = array(
    "http" => array(
      "header"  => "Content-type: application/json\r\n",
      "method"  => "POST",
      "content" => json_encode($data),
    ),
  );
 

  // Crear un contexto de solicitud con las opciones definidas
  $context  = stream_context_create($options);

  // Realizar la solicitud HTTP POST a la API
  $response = file_get_contents($url, false, $context);

  // Decodificar la respuesta en formato JSON
  $data = json_decode($response);

  // Acceder a los datos de la respuesta
  echo $data->token;
  echo $data->userName;

  ////Obetener la lista de usuarios
  $options = array(
    'http' => array(
        'header'  => "Content-type: application/json\r\n".
                      "Authorization: Bearer $data->token\r\n",
        'method'  => 'GET',
    ),
);
$context  = stream_context_create($options);

// Realizamos la solicitud GET a la API
$response = file_get_contents("http://localhost:8080/api/private/admin/person-list", false, $context);

// Decodificamos la respuesta en formato JSON
$response_data = json_decode($response);

// Accedemos a los datos
foreach($response_data as $value){
    echo $value->personName."<br/>";
}

