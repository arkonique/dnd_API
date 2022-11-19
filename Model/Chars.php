<?php
require_once PROJECT_ROOT_PATH."/Model/Database.php";

// make a class which calls all of the character classes as a wrapper
class CharacterModel extends Database{
    public function __construct(protected string $table)
    {
        parent::__construct();
    }
    // get all character personal details
    public function getData($token){
        //echo "SELECT * FROM ".$this->table." WHERE token=?";
        return $this->select("SELECT * FROM ".$this->table." WHERE token=?",[$token]);
    }
    // get all character class details 


    // add new character (insert into all tables)
}

?>