<?php
namespace Models;
use Classes\Model;

Class UserModel Extends Model{
	
	public function authorization($login, $password){	
		
		$query ="select * from users where login='".$this->db->link->real_escape_string($login)."' ";
		
		$this->run($query);	
		$user=mysqli_fetch_assoc($this->result);
		
		if ($user['password']==$password)
			return $user;	
		else
			{			
			return "error";	
			}
	}
}