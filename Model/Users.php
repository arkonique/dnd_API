<?php
require_once PROJECT_ROOT_PATH."/Model/Database.php";
 
class UserModel extends Database
{

    public function __construct(protected string $table)
    {
        parent::__construct();
    }
    public function getUsers($u,$p)
    {
        $p2=$this->select("SELECT password FROM ".$this->table." WHERE username=?",[$u])[0]['password'];
        $p2=substr($p2,10,-10);
        //echo "s=".$p2."\n p=".$p."\n";
        if ($p==$p2) {
            return $this->select("SELECT * FROM ".$this->table." WHERE username=?",[$u]);
        }
        else {
            return "nomatch";
        }
    }

    public function listUsers($col)
    {
        return $this->select("SELECT ".$col." FROM ".$this->table);
    }

    public function getSalt($u)
    {
        return $this->select("SELECT salt FROM ".$this->table." where username=?",[$u]);
    }

    public function getUserFromToken($t)
    {
        return $this->select("SELECT name FROM ".$this->table." where token=?",[$t]);
    }

    public function addUsers($data)
    {
        return $this->executeStatement("INSERT into ".$this->table." (username,password,name,token,dmcode,salt) values (?,?,?,?,?,?)",$data);
    }

    public function random_str(
        int $length = 64,
        string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ): string {
        if ($length < 1) {
            throw new \RangeException("Length must be a positive integer");
        }
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

}
?>