<?php
namespace Models;
use Classes\Model;

Class TaskModel Extends Model{
	
	public function getTaskCount(){		
		$query ="SELECT COUNT(*)  AS count FROM tasks";
		$this->run($query);	
		return mysqli_fetch_assoc($this->result);;
		}
	
	public function getTasks($sort_type, $page=1){
		$order="";
		if ($sort_type==1)
			$order=" ORDER BY user_name ";
		elseif ($sort_type==2)
			$order=" ORDER BY email ";
		elseif ($sort_type==3)
			$order=" ORDER BY activated ";
		
		$page_start=($page-1)*3;		
		$limit=" LIMIT ".$page_start.", 3;";
		
		$query ="SELECT id, user_name, email, text, activated
					FROM tasks ".$order.$limit;	
			
		$this->run($query);		
		$array = array();
		while($row = mysqli_fetch_assoc($this->result)) { 
			$array[] = $row;
		}
		return $array;	
	}
	
	public function addTask($user, $email, $task){
		$query ="INSERT INTO tasks (user_name , email, text)
							VALUES (
									'".$this->db->link->real_escape_string($user)."', 
									'".$this->db->link->real_escape_string($email)."',
									'".$this->db->link->real_escape_string($task)."
									');";	
		$this->run($query);				
		if ($this->result)			
			return True;				
	}
	
	public function updateTask($id, $task, $status){			
		$query ="UPDATE tasks SET 	text='".$this->db->link->real_escape_string($task)."', 
									activated=".$this->db->link->real_escape_string($status)." 
							WHERE id=".$this->db->link->real_escape_string($id);		
		
		$this->run($query);	
		if ($this->result)
			return True;			
	}
}