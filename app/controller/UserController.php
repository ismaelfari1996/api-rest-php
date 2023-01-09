<?php
include (ROOT.'/app/repository/UserRepository.php');
class UserController{
    private $db;
    private UserRepository $userRepository;
    function __construct($db){
        $this->db=$db;
        $this->userRepository=new UserRepository($db);
    }

    public function getAllUsers(){
        header('Content-Type: application/json');
        echo json_encode($this->userRepository->getAllUser());
    }

    public function getById($id){
        header('Content-Type: application/json');
        echo json_encode($this->userRepository->getById($id));
        http_response_code(200);
    }

    public function save(){
        $jsonData=file_get_contents('php://input');
        echo json_encode($this->userRepository->save($jsonData));
    }
}
