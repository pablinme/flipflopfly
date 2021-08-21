<?php
define(PW_SALT,'(+3%_');
class Recover
{
	static function checkUserOrEmail($username, $email)
	{
		global $mysqli;
		if (isset($email) && trim($email) != '') 
		{
			//email was entered
			$email = trim($email); 
			if ($SQL = $mysqli->prepare("SELECT `id` FROM `members` WHERE `email` = ? LIMIT 1"))
			{
				$SQL->bind_param('s', $email);
				$SQL->execute();
				$SQL->store_result();
				$numRows = $SQL->num_rows();
				$SQL->bind_result($userID);
				$SQL->fetch();
				//$SQL->close();
				if ($numRows >= 1) return array('status'=>true,'userID'=>$userID);
			} 
			else 
			{ 
				return array('status'=>false,'userID'=>0); 
			}
		}
		elseif (isset($username) && trim($username) != '') 
		{
			//username was entered
			$username = trim($username);
			if ($SQL = $mysqli->prepare("SELECT `id` FROM `members` WHERE username = ? LIMIT 1"))
			{
				$SQL->bind_param('s', $username);
				$SQL->execute();
				$SQL->store_result();
				$numRows = $SQL->num_rows();
				$SQL->bind_result($userID);
				$SQL->fetch();
				//$SQL->close();
				if ($numRows >= 1) return array('status'=>true,'userID'=>$userID);
			} 
			else 
			{ 
				return array('status'=>false,'userID'=>0); 
			}
		} 
		else 
		{
			//nothing was entered;
			return array('status'=>false,'userID'=>0); 
		}
	}//function checkUserOrEmail($username, $email)

	static function sendPasswordEmail($userID)
	{
		global $mysqli;
		if ($SQL = $mysqli->prepare("SELECT `username`,`email`,`password` FROM `members` WHERE `id` = ? LIMIT 1"))
		{
			$SQL->bind_param('i',$userID);
			$SQL->execute();
			$SQL->store_result();
			$SQL->bind_result($username,$email,$pword);
			$SQL->fetch();
			//$SQL->close();
			$expFormat = mktime(date("H"), date("i"), date("s"), date("m")  , date("d")+3, date("Y"));
			$expDate = date("Y-m-d H:i:s",$expFormat);
			$key = md5($username . '_' . $email . rand(0,10000) .$expDate . PW_SALT);
			if ($SQL = $mysqli->prepare("INSERT INTO `recoveryemails` (`UserID`,`Key`,`expDate`) VALUES (?,?,?)"))
			{
				$SQL->bind_param('iss',$userID,$key,$expDate);
				$SQL->execute();
				//$SQL->close();
				$passwordLink = "<a href=http://chasqui.pableins.com/recover?a=recover&email=" . $key . "&u=" . urlencode(base64_encode($userID)) . "\">http://chasqui.pableins.com/recover?a=recover&email=" . $key . "&u=" . urlencode(base64_encode($userID)) . "</a>";
				$message = "<p>Dear $username,</p>";
				$message .= "<p>Please visit the following link to reset your password:</p>";
				$message .= "<p>$passwordLink\r\n";
				$message .= "<p>The link will expire after 3 days.</p>";
				$message .= "<p>If you did not request email, no action is needed.</p>";
				$message .= "<p>Thanks,</p>";
				$message .= "<p>Chasqui</p>";
				$headers .= "From: Chasqui Support <recoverchasqui@gmail.com> \n";
				$headers .= "To-Sender: \n";
				$headers .= "X-Mailer: PHP\n"; // mailer
				$headers .= "Reply-To: recoverchasqui@gmail.com\n"; // Reply address
				$headers .= "Return-Path: recoverchasqui@gmail.com\n"; //Return Path for errors
				$headers .= "Content-Type: text/html; charset=iso-8859-1"; //Enc-type
				$subject = "Password Recover Information";
				@mail($email,$subject,$message,$headers);
				return str_replace("\r\n","<br/ >",$message);
			}
		}
	}//function sendPasswordEmail($userID)

	static function checkEmailKey($key, $userID)
	{
		global $mysqli;
		$curDate = date("Y-m-d H:i:s");
		if ($SQL = $mysqli->prepare("SELECT `UserID` FROM `recoveryemails` WHERE `Key` = ? AND `UserID` = ? AND `expDate` >= ?"))
		{
			$SQL->bind_param('sis',$key,$userID,$curDate);
			$SQL->execute();
			$SQL->execute();
			$SQL->store_result();
			$numRows = $SQL->num_rows();
			$SQL->bind_result($userID);
			$SQL->fetch();
			//$SQL->close();
			if ($numRows > 0 && $userID != '')
			{
				return array('status'=>true,'userID'=>$userID);
			}
		}
		return false;
	}//function checkEmailKey($key, $userID)

	static function updateUserPassword($userID, $passw, $key)
	{
		global $mysqli;
		if (self::checkEmailKey($key,$userID) === false) return false;
	
		// Create a random salt
		$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
		// Create salted password (Careful not to over season)
		$passw = hash('sha512', $passw.$random_salt);
	
		if ($insert_stmt = $mysqli->prepare("UPDATE `members` SET `password` = ?, `salt` = ? WHERE `id` = ?"))
		{
			$insert_stmt->bind_param('ssi',$passw,$random_salt,$userID);
			$insert_stmt->execute();
			//$insert_stmt->close();

			if($delete_stmt = $mysqli->prepare("DELETE FROM `recoveryemails` WHERE `Key` = ?"))
			{
				$delete_stmt->bind_param('s',$key);
				$delete_stmt->execute();
				//$delete_stmt->close();
				return true;
			}
		}
	}//function updateUserPassword($userID, $passw, $key)

	static function getUserName($userID)
	{
		global $mysqli;
		if ($SQL = $mysqli->prepare("SELECT `username` FROM `members` WHERE `id` = ?"))
		{
			$SQL->bind_param('i',$userID);
			$SQL->execute();
			$SQL->store_result();
			$SQL->bind_result($username);
			$SQL->fetch();
			//$SQL->close();
		}
		return $username;
	}//function getUserName($userID)

}

?>