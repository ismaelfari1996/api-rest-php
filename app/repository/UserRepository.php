 <?php
 require_once ROOT.'/app/model/User.php';
 class UserRepository{
    private $db;
    private $table="users";
    private User $user;
    public function __construct($db){
        $this->db=$db;
    }

    public function getAllUser(){
        $users= array();
        $stmt=$this->db->prepare('SELECT * FROM '.$this->table);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
        
    }

    public function getById($id){
        $stmt=$this->db->prepare('SELECT * FROM '.$this->table.' WHERE id=:id');
        $stmt->bindValue(':id',$id,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }
    public function save($user){
        $data= json_decode($user,true);
        $stmt=$this->db->prepare('INSERT INTO '.$this->table. '(name,email) VALUES(:name,:email)');
        $stmt->bindParam(':name',$data['name'],PDO::PARAM_STR);
        $stmt->bindParam(':email',$data['email'],PDO::PARAM_STR);
        $stmt->execute();
        return [["INFO"=>"Save data successful"]];

    }
 }