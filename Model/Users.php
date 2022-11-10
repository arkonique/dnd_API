<?php
require_once PROJECT_ROOT_PATH."/Model/Database.php";
 
class UserModel extends Database
{
    public function getUsers($u,$p)
    {
        return $this->select("SELECT * FROM users WHERE username=? AND password=?",[$u,$p]);
    }

    public function listUsers()
    {
        return $this->select("SELECT username FROM users");
    }

    public function addUsers($data)
    {
        return $this->executeStatement("INSERT into users (username,password,name,token,dmcode) values (?,?,?,?,?)",$data);
    }

}
?>