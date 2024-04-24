<?php

include_once "../../Config/DBManager.php";
require_once("../../Config/mail_configuration.php");
date_default_timezone_set("Asia/Kolkata");
if (!class_exists('../../vendor/PHPMailer')) {
	require('../../vendor/PHPMailer/class.phpmailer.php');
	require('../../vendor/PHPMailer/class.smtp.php');
}


/*
*
* Author : Mahantesh - A - Policepatil.
* Class  : ProductController Class
* This class forms a data access layer,
* This class is used for CURD operations (CREATE, UPDATE, READ, DELETE).
*
*/
class ProductController
{
	private $dbObj;
		
	/**
	 * Method __construct
	 *
	 * @return void
	 */
	function __construct()
	{
		$this->dbObj = new DBManager();
	}
		
	/**
	 * Method index
	 *
	 * @param $id $id [explicite description]
	 *
	 * @return void
	 */
	public function index($id)
	{
		try {
			$sql = "SELECT * from products where user_id = ?";
			$stmt = $this->dbObj->dbconn->prepare($sql);
			$stmt->execute(array($id));
			$basicResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $basicResult;
		} catch (PDOException $e) {
			echo ($e->getMessage());
		}
	}

		
	/**
	 * Method edit
	 *
	 * @param $id $id [explicite description]
	 *
	 * @return void
	 */
	public function edit($id)
	{
		try {
			$sql = "SELECT id, name, quantity, price from products where id = ?";
			$stmt = $this->dbObj->dbconn->prepare($sql);
			$stmt->execute(array($id));
			$basicResult = $stmt->fetch(PDO::FETCH_ASSOC);
			return $basicResult;
		} catch (PDOException $e) {
			echo ($e->getMessage());
		}
	}
		
	/**
	 * Method show
	 *
	 * @param $id $id [explicite description]
	 *
	 * @return void
	 */
	public function show($id)
	{
		try {
			$sql = "SELECT name, quantity, price from products where id = ?";
			$stmt = $this->dbObj->dbconn->prepare($sql);
			$stmt->execute(array($id));
			$basicResult = $stmt->fetch(PDO::FETCH_ASSOC);
			return $basicResult;
		} catch (PDOException $e) {
			echo ($e->getMessage());
		}
	}
	
	/**
	 * Method store
	 *
	 * @param $name $name [explicite description]
	 * @param $quantity $quantity [explicite description]
	 * @param $price $price [explicite description]
	 * @param $user_id $user_id [explicite description]
	 *
	 * @return void
	 */
	public function store($name, $quantity, $price, $user_id)
	{
		try {
			$sql = "INSERT INTO products(name, quantity, price, user_id) values (?,?,?,?)";
			$stmt = $this->dbObj->dbconn->prepare($sql);
			$result = $stmt->execute(array($name, $quantity, $price, $user_id));
			return $result;
		} catch (PDOException $e) {
			echo ($e->getMessage());
		}
	}
	
	/**
	 * Method update
	 *
	 * @param $id $id [explicite description]
	 * @param $name $name [explicite description]
	 * @param $quantity $quantity [explicite description]
	 * @param $price $price [explicite description]
	 *
	 * @return void
	 */
	public function update($id, $name, $quantity, $price)
	{
		try {

			$sql = "UPDATE products SET name = ?, quantity = ?, price = ? WHERE id = ?";
			$stmt = $this->dbObj->dbconn->prepare($sql);
			$result = $stmt->execute(array($name, $quantity, $price, $id));
			return $result;
		} catch (PDOException $e) {
			echo ($e->getMessage());
		}
	}
	
	/**
	 * Method delete
	 *
	 * @param $id $id [explicite description]
	 *
	 * @return void
	 */
	public function delete($id)
	{
		try {
			$sql = "DELETE FROM products WHERE id = ?";
			$stmt = $this->dbObj->dbconn->prepare($sql);
			$result = $stmt->execute(array($id));
			return $result;
		} catch (PDOException $e) {
			echo ($e->getMessage());
		}
	}
		
	/**
	 * Method notifyUser
	 *
	 * @param $id $id [explicite description]
	 * @param $name $name [explicite description]
	 * @param $quantity $quantity [explicite description]
	 * @param $price $price [explicite description]
	 *
	 * @return void
	 */
	public function notifyUser($id, $name, $quantity, $price)
	{

		$mail = new PHPMailer();

		$emailBody = "<div>" . $user_name
			. ",<br><br><p>Click this link to recover your password<br><br><a href='"
			. PROJECT_HOME
			. "/projects/teraspin2/webapps/teraspin2/main/src/php/forgot_password/DatabaseLayer/resetPasswordManager.php?email="
			. $email . "&token=" . $token . "'>Click Here</a><br><br></p>Regards,<br> Admin.</div>";

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
		$mail->ReturnPath = SERDER_EMAIL;
		$mail->AddAddress($email);
		$mail->Subject = "Product Order Details";
		$mail->MsgHTML($emailBody);
		$mail->IsHTML(true);
		$error_message = '';
		if (!$mail->Send()) {
			return false;
		} else {
			return true;
		}
		return $error_message;
	}
}
