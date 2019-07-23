<?php
	if (isset($_POST["key"])) {
		
		//Get Email
		if ($_POST["key"] == "get_email") {
			
			$start = trim($_POST["start"]);
			$limit = trim($_POST["limit"]);

			require_once 'class/Db_Functions.php';
			$database = new Db_Functions();

			$result = $database->getAllCustomer($start,$limit);

			if (count($result)>0) {
				
				$response = "";
				foreach ($result as $value) {

					$response .='
					<tr>
						<td>'.$value['customer_name'].'</td>
						<td>'.$value['customer_email'].'</td>

						<td>
						<input type="hidden" value="'.$value["customer_email"].'" name="emails[]">
						 <input type="checkbox" name="single_select[]"  class="single_select" data-customer_email="'.$value["customer_email"].'" data-customer_name="'.$value["customer_name"].'" />
						</td>
					</tr>
				';
				}
				exit($response);
				

			} else {

				exit("reachedMax");
			}
		}

		/**
		* Send Email
		*/
		if ($_POST["key"] == "send_email") {


			require 'PHPMailer/PHPMailerAutoload.php';
            $mail = new PHPMailer;

			$emails = $_POST["emails"];
			$message = $_POST["message"];
				
				$sender_email = "lynfordlagondi828@gmail.com";

                $subject= "SPecial Email";
                $bodyContent = "";
               
                
                $mail->isSMTP();                                   // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com';                    // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                            // Enable SMTP authentication
                $mail->Username = 'lynfordlagondi828@gmail.com';          // SMTP username
                $mail->Password = 'harrisonford828'; // SMTP password
                $mail->SMTPSecure = 'tls';                         // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587;                                 // TCP port to connect to


                $mail->setFrom($sender_email);
				$mail->addReplyTo($sender_email);

				//Email Storage
				$mail->addAddress("ford@gmail.com");
				////////
				
				foreach($emails as $value):
					$mail->AddCC($value);
				endforeach;
			

                $mail->isHTML(true);  // Set email format to HTML

                $bodyContent .= '<br>'. 'Sender: ' .$sender_email . '<br>' . 'Subject:' . $subject . '<br>' .'Message: '. $message;

                $mail->Subject = $subject;
                $mail->Body    = $bodyContent;

                if(!$mail->send()){
                    //$message = ' Message could not be sent.';
                    exit('failed');
                } else {
                    exit('Email sent');
                }
			}
		}
	
?>