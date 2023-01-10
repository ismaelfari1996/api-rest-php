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

    public function delete($id){
        $stmt=$this->db->prepare('DELETE FROM '.$this->table.' WHERE id=:id');
        $stmt->bindParam(':id',$id,PDO::PARAM_INT);
        $stmt->execute();
        return [["INFO"=>"Registro eliminado"]];

    }

    public function update($data){
        $data=json_decode($data,true);
        $user=$this->getById($data['id']);
        $user=new User($user[0]->id,$user[0]->name,$user[0]->email);

        $name=isset($data['name'])?$data['name']:$user->getName();
        $id=$user->getId();
        $email=isset($data['email'])?$data['email']:$user->getEmail();
        $stmt=$this->db->prepare("UPDATE ".$this->table." SET name=:name, email=:email WHERE id=:id");
        $stmt->bindParam(":name",$name,PDO::PARAM_STR);
        $stmt->bindParam(":email",$email,PDO::PARAM_STR);
        $stmt->bindParam(":id",$id,PDO::PARAM_INT);
        $stmt->execute();
        return [["INFO"=>"Registro actualizado"]];
    }
 }