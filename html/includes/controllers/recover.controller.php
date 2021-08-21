<?php

/* This controller renders the recover page */

class RecoverController
{
	public function handleRequest()
	{

		if($show=='' && !isset($_POST['p'])) { $show = 'recover'; } //which form step to show by default

		if ($_SESSION['lockout'] == true && (mktime() > $_SESSION['lastTime'] + 900))
		{
			$_SESSION['lockout'] = false;
			$_SESSION['badCount'] = 0;
		}

		if (isset($_POST['subStep']) && !isset($_GET['a']) && $_SESSION['lockout'] != true)
		{
			switch($_POST['subStep'])
			{
				case 1:
				//we just submitted an email or username for verification
				$result = Recover::checkUserOrEmail($_POST['username'],$_POST['email']);
				if ($result['status'] == false )
				{
					$error = true;
					$show = 'notFound';
				} 
				else
				{
					$error = false;
					$show = 'rc_success';
					$passwordMessage = Recover::sendPasswordEmail($result['userID']);
					$_SESSION['badCount'] = 0;

				}
				break;
				case 3:
				//we are submitting a new password (only for encrypted)
				if ($_POST['userID'] == '' || $_POST['key'] == '') header("location: /login/");
				if (!isset($_POST['p']))
				{
					$error = true;
					$show = 'reset';
				}
				else
				{
					$error = false;
					//$show = 'recoverSuccess';
					//updateUserPassword($_POST['userID'], $_POST['pw1'], $_POST['key']);
				}
				break;
			}
		} 
		elseif (isset($_GET['a']) && $_GET['a'] == 'recover' && $_GET['email'] != "") 
		{
			$show = 'invalidKey';
			$result = Recover::checkEmailKey($_GET['email'],urldecode(base64_decode($_GET['u'])));
			if ($result == false)
			{
				$error = true;
				$show = 'invalidKey';
			} 
			elseif ($result['status'] == true) 
			{
				$error = false;
				$show = 'reset';
				$securityUser = $result['userID'];
			}
		}
			
		if ($_SESSION['badCount'] >= 3)
		{
			$show = 'limit';
			$_SESSION['lockout'] = true;
			$_SESSION['lastTime'] = '' ? mktime() : $_SESSION['lastTime'];
		}

		if(isset($_POST['userID'], $_POST['p'], $_POST['key'])) 
		{ 
			$userID = $_POST['userID'];
	
			$passw = $_POST['p']; // The hashed password.
	
			$key = $_POST['key'];
	
			if(Recover::updateUserPassword($userID, $passw, $key) == true) 
			{
				$show = 'done';
			}
			else
			{
				$show = 'error';
			}
			
		}
		
		switch($show) 
		{
			case 'done':
				render('rc_done', array('title' => 'Password Recover', 'recover'=>true)); //passwd was reseted
				break;
				
			case 'error':
				render('rc_error', array('title' => 'Password Recover', 'recover'=>true)); //passwd was not reseted
				break;
				
			case 'recover':
				render('recover', array('title' => 'Password Recover', 'recover'=>true)); //first page of recovery
				break;
						
			case 'notFound':
				render('rc_notFound', array('title' => 'Password Recover', 'recover'=>true)); //user not found, by email or username
				break;
			
			case 'rc_success': 
				render('rc_success', array('title' => 'Password Recover', 'recover'=>true)); //link for recovery sent to email
				break; 
				
			case 'reset':
				render('rc_reset', array('title' => 'Password Recover', 'error' => $error, 'securityUser' => $securityUser, 'recover'=>true)); //reset the passwd form
    			break; 
    		
    		case 'limit':
				render('rc_limit', array('title' => 'Password Recover', 'recover'=>true)); //locked out
				break;
			
			default:
				render('message',array('title'=>'Error',
				   'body' => 'there was an error!'));
				break; 
		}
		//ob_flush();
		//$mysqli->close();
	}
}


?>