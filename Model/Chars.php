<?php
require_once PROJECT_ROOT_PATH."/Model/Database.php";

// make a class which calls all of the character classes as a wrapper
class CharacterModel extends Database{
    public function __construct(protected string $table)
    {
        parent::__construct();
    }
    // get all characters for a specific user
    public function getData($token){
        return $this->select("SELECT * FROM ".$this->table." WHERE token=?",[$token]);
    }

    // get a specific character
    public function getChar($id){
        return $this->select("SELECT * FROM ".$this->table." WHERE srno=?",[$id]);
    }
    // get all character class details


    // add new character (insert into all tables)
}

?>