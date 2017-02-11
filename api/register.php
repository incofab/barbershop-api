<?php

require_once __DIR__ . '/../config/k.php';
require_once __DIR__ .  '/../../api/controller/Controller.php';

// Accept requests in both arrays and json format
if(is_array($_REQUEST)) $request = $_REQUEST;
else $request = json_decode($_REQUEST, true);

$ctrl = new Controller();

if(!isset($request['r'])) return outputJSON([SUCCESS => false, MESSAGE => 'Invalid parametes supplied']);

if($request['r'] == 'register'){
    $username = $_POST['username'];
	$email = $_POST['email'];
    $password = $_POST['password'];
    $firstname = $_POST['firstname']; 
    $lastname = $_POST['lastname'];
    $phone = $_POST['phone'];
    $organization = $_POST['organisation'];
    $country = $_POST['country'];
	
	$varname = $ctrl->checkExistingUserName($username);
	if ($varname[0]['username'] != "" || $varname[0]['username'] != null){
        return outputJSON([SUCCESS => false, MESSAGE => 'Username Already Exist!']);
    } 
	
	$varsPhone = $ctrl->checkExistingPhone($phone);
	if ($varsPhone[0]['phone'] != "" || $varsPhone[0]['phone'] != null){
        return outputJSON([SUCCESS => false, MESSAGE => 'Phone Already Exist!']);
    } 
	
    $vars = $ctrl->checkExistingEmail($email);
	
    if ($vars[0]['email'] != "" || $vars[0]['email'] != null){
        return outputJSON([SUCCESS => false, MESSAGE => 'Email Already Exist!']);
    }    
    
	$res = $ctrl->createShort_UsersDetails($email, sha1($password), $firstname, $lastname, $phone, $organization, $country, $username);
	if ($res == 0) {
		return outputJSON([SUCCESS => false, MESSAGE => 'Registration Not Successful!']);
	} 
	
	$res = $ctrl->md5_ThreeWayEncryption($res);
	$link = $_SERVER['SERVER_NAME'] . "/api/controller/api_file.php?avt=activate&ml=" . $email . "&ky=" . $res;
	$to = $email;
	$subject = "Welcome to Barbershop Connect!";
	$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>[SUBJECT]</title>
	<style type="text/css">

@media screen and (max-width: 600px) {
    table[class="container"] {
        width: 95% !important;
    }
}

	#outlook a {padding:0;}
		body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}
		.ExternalClass {width:100%;}
		.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
		#backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
		img {outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;}
		a img {border:none;}
		.image_fix {display:block;}
		p {margin: 1em 0;}
		h1, h2, h3, h4, h5, h6 {color: black !important;}
		h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {color: blue !important;}
		h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {
			color: red !important; 
		 }
		h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {
			color: purple !important; 
		}
		table td {border-collapse: collapse;}
		table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }
		a {color: #000;}
		@media only screen and (max-device-width: 480px) {
			a[href^="tel"], a[href^="sms"] {
						text-decoration: none;
						color: black; /* or whatever your want */
						pointer-events: none;
						cursor: default;
					}

			.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
						text-decoration: default;
						color: orange !important; /* or whatever your want */
						pointer-events: auto;
						cursor: default;
					}
		}


		@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
			a[href^="tel"], a[href^="sms"] {
						text-decoration: none;
						color: blue; /* or whatever your want */
						pointer-events: none;
						cursor: default;
					}

			.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
						text-decoration: default;
						color: orange !important;
						pointer-events: auto;
						cursor: default;
					}
		}

		@media only screen and (-webkit-min-device-pixel-ratio: 2) {
			/* Put your iPhone 4g styles in here */
		}

		@media only screen and (-webkit-device-pixel-ratio:.75){
			/* Put CSS for low density (ldpi) Android layouts in here */
		}
		@media only screen and (-webkit-device-pixel-ratio:1){
			/* Put CSS for medium density (mdpi) Android layouts in here */
		}
		@media only screen and (-webkit-device-pixel-ratio:1.5){
			/* Put CSS for high density (hdpi) Android layouts in here */
		}
		/* end Android targeting */
		h2{
			color:#181818;
			font-family:Helvetica, Arial, sans-serif;
			font-size:22px;
			line-height: 22px;
			font-weight: normal;
		}
		a.link1{

		}
		a.link2{
			color:#fff;
			text-decoration:none;
			font-family:Helvetica, Arial, sans-serif;
			font-size:16px;
			color:#fff;border-radius:4px;
		}
		p{
			color:#555;
			font-family:Helvetica, Arial, sans-serif;
			font-size:16px;
			line-height:160%;
		}
	</style>

<script type="colorScheme" class="swatch active">
  {
    "name":"Default",
    "bgBody":"ffffff",
    "link":"fff",
    "color":"555555",
    "bgItem":"ffffff",
    "title":"181818"
  }
</script>

</head>' .
                    '<body>
	<!-- Wrapper/Container Table: Use a wrapper table to control the width and the background color consistently of your email. Use this approach instead of setting attributes on the body tag. -->
	<table cellpadding="0" width="100%" cellspacing="0" border="0" id="backgroundTable" class="bgBody">
	<tr>
		<td>
	<table cellpadding="0" width="620" class="container" align="center" cellspacing="0" border="0">
	<tr>
		<td>
		<!-- Tables are the most common way to format your email consistently. Set your table widths inside cells and in most cases reset cellpadding, cellspacing, and border to zero. Use nested tables as a way to space effectively in your message. -->
		<table cellpadding="0" cellspacing="0" border="0" align="center" width="600" class="container">
			<tr>
				<td class="movableContentContainer bgItem">
					<div class="movableContent">
						<table cellpadding="0" cellspacing="0" border="0" align="center" width="600" class="container">
							<tr height="40">
								<td width="200">&nbsp;</td>
								<td width="200">&nbsp;</td>
								<td width="200">&nbsp;</td>
							</tr>
							<tr>
								<td width="200" valign="top">&nbsp;</td>
								<td width="200" valign="top" align="center">
									<div class="contentEditableContainer contentImageEditable">
					                	<div class="contentEditable" align="center" >
					                  		<img src="http://barbershop.pixietechng.com/images/logo.jpg" width="200" height="130"  alt="Logo"  data-default="placeholder" />
					                	</div>
					              	</div>
								</td>
								<td width="200" valign="top">&nbsp;</td>
							</tr>
							<tr height="25">
								<td width="200">&nbsp;</td>
								<td width="200">&nbsp;</td>
								<td width="200">&nbsp;</td>
							</tr>
						</table>
					</div>

					<div class="movableContent">
						<table cellpadding="0" cellspacing="0" border="0" align="center" width="600" class="container">
							<tr>
								<td width="100%" colspan="3" align="center" style="padding-bottom:10px;padding-top:25px;">
									<div class="contentEditableContainer contentTextEditable">
					                	<div class="contentEditable" align="center" >
					                  		<h2>Welcome ' . $firstname. ' to Barbershop.com.</h2>
					                	</div>
					              	</div>
								</td>
							</tr>
							<tr>
								<td width="100">&nbsp;</td>
								<td width="400" align="center">
									<div class="contentEditableContainer contentTextEditable">
					                	<div class="contentEditable" align="left" >
					                  		<p >Hi <strong> ' . $firstname . ' ' . $lastname . '</strong> ,
					                  			<br/>
					                  			<br/>' .
                    "Click on the link below to activate your profile. If you're no longer interested in hearing from us, simply click on unsubscribe below (or ignore this message) and we won't send you any more newsletters.</p>
					                	</div>
					              	</div>
								</td>" .
                    '<td width="100">&nbsp;</td>
							</tr>
						</table>
						<table cellpadding="0" cellspacing="0" border="0" align="center" width="600" class="container">
							<tr>
								<td width="200">&nbsp;</td>
								<td width="200" align="center" style="padding-top:25px;">
									<table cellpadding="0" cellspacing="0" border="0" align="center" width="200" height="50">
										<tr>
											<td bgcolor="#5cb85c" align="center" style="border-radius:4px;" width="200" height="50">
												<div class="contentEditableContainer contentTextEditable">
								                	<div class="contentEditable" align="center" >
								                  		<a target="_blank" href="' . $link . '" class="link2">Click here to Activate</a>
								                	</div>
								              	</div>
											</td>
										</tr>
										<tr><td><p> or Copy and paste the link to your browser</p> '. $link .'</td></tr>
									</table>
								</td>
								<td width="200">&nbsp;</td>
							</tr>
						</table>
					</div>
					<div class="movableContent">
						<table cellpadding="0" cellspacing="0" border="0" align="center" width="600" class="container">
							<tr>
								<td width="100%" colspan="2" style="padding-top:65px;">
									<hr style="height:1px;border:none;color:#333;background-color:#ddd;" />
								</td>
							</tr>
							<tr>
								<td width="60%" height="70" valign="middle" style="padding-bottom:20px;">
									<div class="contentEditableContainer contentTextEditable">
					                	<div class="contentEditable" align="left" >
					                  		<span style="font-size:13px;color:#181818;font-family:Helvetica, Arial, sans-serif;line-height:200%;">Sent to [' . $to . '] by [BARBERSHOP.com]</span>
											<br/>
											<span style="font-size:11px;color:#555;font-family:Helvetica, Arial, sans-serif;line-height:200%;">[' . $country . '] | [' . $phone . ']</span>
											<br/>
											<span style="font-size:13px;color:#181818;font-family:Helvetica, Arial, sans-serif;line-height:200%;">
											<a target="_blank" href="[FORWARD]" style="text-decoration:none;color:#555">Forward to a friend</a>
											</span>
											<br/>
											<span style="font-size:13px;color:#181818;font-family:Helvetica, Arial, sans-serif;line-height:200%;">
											<a target="_blank" href="[UNSUBSCRIBE]" style="text-decoration:none;color:#555">click here to unsubscribe</a></span>
					                	</div>
					              	</div>
								</td>
								<td width="40%" height="70" align="right" valign="top" align="right" style="padding-bottom:20px;">
									<table width="100%" border="0" cellspacing="0" cellpadding="0" align="right">
										<tr>
											<td width="57%"></td>
											<td valign="top" width="34">
												<div class="contentEditableContainer contentFacebookEditable" style="display:inline;">
							                        <div class="contentEditable" >
							                            <img src="images/facebook.png" data-default="placeholder" data-max-width="30" data-customIcon="true" width="30" height="30" alt="facebook" style="margin-right:40x;">
							                        </div>
							                    </div>
											</td>
											<td valign="top" width="34">
												<div class="contentEditableContainer contentTwitterEditable" style="display:inline;">
							                      <div class="contentEditable" >
							                        <img src="images/twitter.png" data-default="placeholder" data-max-width="30" data-customIcon="true" width="30" height="30" alt="twitter" style="margin-right:40x;">
							                      </div>
							                    </div>
											</td>
											<td valign="top" width="34">
												<div class="contentEditableContainer contentImageEditable" style="display:inline;">
							                      <div class="contentEditable" >
							                        <a target="_blank" href="#" data-default="placeholder"  style="text-decoration:none;">
														<img src="images/pinterest.png" width="30" height="30" data-max-width="30" alt="pinterest" style="margin-right:40x;" />
													</a>
							                      </div>
							                    </div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
		</table>
	</td></tr></table>
		</td>
	</tr>
	</table>
	</body>
	</html>';

	// Always set content-type when sending HTML email
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

	// More headers
	$headers .= 'From: <no-reply@barbershop.com>' . "\r\n";
	mail($to, $subject, $message, $headers);
	
	return outputJSON([SUCCESS => true, MESSAGE => 'Registration Successful!. Please check your email for activation']);
            
}