<?php

include_once "../../Config/DBManager.php";
require_once("../../Config/mail_configuration.php");
date_default_timezone_set("Asia/Kolkata");
if(!class_exists('../../vendor/PHPMailer')) {
    require('../../vendor/PHPMailer/class.phpmailer.php');
	require('../../vendor/PHPMailer/class.smtp.php');
}


/*
*
* Author : Mahantesh - A - Policepatil.
* Class  : UserController Class
* This class forms a data access layer,
* This class is used for CURD operations (CREATE, UPDATE, READ, DELETE).
*
*/
class UserController {
	
	private $dbObj;
	
	/*
	*
	* Method : Constructor.	
	*
	*/
	function __construct() {	
			$this->dbObj=new DBManager();	
	}
	/*
	*
	* Method : Validates the login form and returns response
	*
	*/
	public function validate($post)
	{
			$user =$post['username'];
	    $pass =$post['password'];

	    if($user == "" || $pass == "") {
	      $response["error_code"] = 401;
	      $response["message"] = "Either username or password field is empty.";	
	      
	    }else{
	    	$response["error_code"] = 200;
	    	$response["message"] = "Validation successful";	
	    }
	    return $response;
	}

	/*
	*
	* Method : Returns a user for a given id
	*
	*/
	public function show($id)
	{
			try{
				$sql = "SELECT id, name, user_name, email from users where id = ?";
				//print_r($sql); exit;
				$stmt = $this->dbObj->dbconn->prepare($sql);
				$stmt->execute(array($id));
				$basicResult = $stmt -> fetch(PDO::FETCH_ASSOC);
				return $basicResult;
			}
			catch(PDOException $e){
				echo ($e->getMessage ());
			}
	}

	/*
	*
	* Method : Returns a user for a given id
	*
	*/
	public function authenticate($user_name, $password)
	{
			try{
				$sql = "SELECT * from users where user_name = ? AND password = ?";
				$stmt = $this->dbObj->dbconn->prepare($sql);
				$stmt->execute(array($user_name, $password));
				$basicResult = $stmt->fetch(PDO::FETCH_ASSOC);
				return $basicResult;
			}
			catch(PDOException $e){
				echo ($e->getMessage ());
			}			
	}

	/*
	*
	* Method : creates a new user
	*
	*/
	
	public function store($name, $email, $user_name, $password) 
	{
			try{
				$sql="INSERT INTO users(name, email, user_name, password) values (?,?,?,?)";
				$stmt= $this->dbObj->dbconn->prepare($sql);
				$result = $stmt->execute(array($name, $email, $user_name, $password));
				return $result;
			}
			catch(PDOException $e){
				echo($e->getMessage());
			}	
	}

	/*
	*
	* Updates an existing user
	*/
	
	public function update($name, $email, $user_name, $password, $id) 
	{
			try{				
				$sql="UPDATE users SET name = ?, email = ?, user_name = ?, password = ? WHERE id = ?";
				$stmt= $this->dbObj->dbconn->prepare($sql);
				$result = $stmt->execute(array($name, $email, $user_name, $password, $id));
				return $result;
			}
			catch(PDOException $e){
				echo($e->getMessage());
			}	
	}

	/*
	*
	* Method : Deletes an existing user
	*
	*/
	
	public function delete($id) 
	{
			try{
				$sql="DELETE FROM users WHERE id = ?";
				$stmt= $this->dbObj->dbconn->prepare($sql);
				$result = $stmt->execute(array($id));
				return $result;
			}
			catch(PDOException $e){
				echo($e->getMessage());
			}
	
	}

	/*
	*
	* Method : Sends E-Mail notification to user.
	*
	*/
	public function notifyUser($id, $name, $quantity, $price)
	{
		
			$mail = new PHPMailer();

			$emailBody = "<div>" . $user_name 
								 . ",<br><br><p>Click this link to recover your password<br><br><a href='" 
								 . PROJECT_HOME 
								 . "/projects/teraspin2/webapps/teraspin2/main/src/php/forgot_password/DatabaseLayer/resetPasswordManager.php?email=" 
								 . $email . "&token=". $token . "'>Click Here</a><br><br></p>Regards,<br> Admin.</div>";
			
			$mail->IsSMTP();
			$mail->SMTPDebug  = 0;
			$mail->SMTPAuth   = TRUE;
			$mail->SMTPSecure = "tls";
			$mail->Port       = PORT;  
			$mail->Username   = MAIL_USERNAME;
			$mail->Password   = MAIL_PASSWORD;
			$mail->Host       = MAIL_HOST;
			$mail->Mailer     = MAILER;

			$mail->SMTPOptions = array(
				'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
				)
			);

			$mail->SetFrom(SERDER_EMAIL, SENDER_NAME);
			$mail->AddReplyTo(SERDER_EMAIL, SENDER_NAME);
			$mail->ReturnPath=SERDER_EMAIL;	
			$mail->AddAddress($email);
			$mail->Subject = "Product Order Details";		
			$mail->MsgHTML($emailBody);
			$mail->IsHTML(true);
			$error_message = '';
			if(!$mail->Send()) {
				return false;
			} else {
				return true;
			}
			return $error_message;
		}	

}

?>	