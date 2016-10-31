<?php
/*
 * @Author Nachiket Kulkarni <kulkarninachiketv@gmail.com>
 * @Version 1.0
 * @Package Database
 */
class Database{
	/* 
	 * Create variables for credentials to database.
	 */
	private $db_host = "localhost";  
	private $db_user = "root";  
	private $db_pass = "";  
	private $db_name = "shoppingkart";	 
	private $con;	 
	function __construct() {  
           if(!$this->con){
			$myconn = @mysql_connect($this->db_host,$this->db_user,$this->db_pass);   
				if($myconn){
					$seldb = @mysql_select_db($this->db_name,$myconn);  
					if($seldb){
						$this->con = true;
						return true;  // Connection has been made return TRUE
					}else{
						array_push($this->result,mysql_error()); 
						return false;  // Problem selecting database return FALSE
					}  
				}else{
					array_push($this->result,mysql_error());
					return false; // Problem connecting return FALSE
				}  
			}else{  
				return true; // Connection has already been made return TRUE 
			}  
        }  
	public function Close(){  
		mysql_close();  
	}  
} 
