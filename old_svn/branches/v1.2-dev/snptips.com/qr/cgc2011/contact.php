<?php
if (session_id() == '') session_start();
/*******************************************************************************
*  Title: Easy PHP Contact Form (Captcha Version)
*  Version: 2.0 @ September 14, 2010
*  Author: Vishal P. Rao
*  Website: http://www.easyphpcontactform.com
********************************************************************************
*  COPYRIGHT NOTICE
*  Copyright 2010 Vishal P. Rao. All Rights Reserved.
*
*  This script may be used and modified free of charge by anyone
*  AS LONG AS COPYRIGHT NOTICES AND ALL THE COMMENTS REMAIN INTACT.
*  By using this code you agree to indemnify Vishal P. Rao or 
*  www.easyphpcontactform.com from any liability that might arise from 
*  it's use.
*
*  Selling the code for this program, in part or full, without prior
*  written consent is expressly forbidden.
*
*  Obtain permission before redistributing this software over the Internet
*  or in any other medium. In all cases copyright and header must remain
*  intact. This Copyright is in full effect in any country that has
*  International Trade Agreements with the India
*
*  Removing any of the copyright notices without purchasing a license
*  is illegal! 
*******************************************************************************/

/*******************************************************************************
 *	Script configuration - Refer README.txt
*******************************************************************************/

include_once "contact-config.php";

$error_message = '';

if (!isset($_POST['submit'])) {

  showForm();

} else { //form submitted

  $error = 0;
  
  if(!empty($_POST['fname'])) {
  	$fname[2] = clean_var($_POST['fname']);
  }
  else {
    $error = 1;
    $fname[3] = 'color:#FF0000;';
  }
  
  if(!empty($_POST['lname'])) {
  	$lname[2] = clean_var($_POST['lname']);
  }
  else {
    $error = 1;
    $lname[3] = 'color:#FF0000;';
  }
  
  if(!empty($_POST['phone'])) {
  	$phone[2] = clean_var($_POST['phone']);
  }
  else {
    $phone[3] = clean_var($_POST['phone']);
  }
  
  if(!empty($_POST['city'])) {
  	$city[2] = clean_var($_POST['city']);
  }
  else {
    $city[3] = clean_var($_POST['city']);
  }
  
   if(!empty($_POST['state'])) {
  	$state[2] = clean_var($_POST['state']);
  }
  else {
    $state[3] = clean_var($_POST['state']);
  }
  
   if(!empty($_POST['snptips_installed'])) {
  	$snptips_installed[2] = clean_var($_POST['snptips_installed']);
  }
  else {
    $snptips_installed[3] = clean_var($_POST['snptips_installed']);
  }
  
   if(!empty($_POST['snptips_future'])) {
  	$snptips_future[2] = clean_var($_POST['snptips_future']);
  }
  else {
    $snptips_future[3] = clean_var($_POST['snptips_future']);
  }
  
   if(!empty($_POST['gift'])) {
  	$gift[2] = clean_var($_POST['gift']);
  }
  else {
    $snptips_future[3] = clean_var($_POST['snptips_future']);
  }
  if(!empty($_POST['email'])) {
  	$email[2] = clean_var($_POST['email']);
  	if (!validEmail($email[2])) {
  	  $error = 1;
  	  $email[3] = 'color:#FF0000;';
  	  $email[4] = '<strong><span style="color:#FF0000;">Invalid email</span></strong>';
	  }
  }
  else {
    $error = 1;
    $email[3] = 'color:#FF0000;';
  }


  if(empty($_POST['captcha_code'])) {
    $error = 1;
    $code[3] = 'color:#FF0000;';
  } else {
  	include_once "contact-securimage.php";
		$securimage = new Securimage();
    $valid = $securimage->check($_POST['captcha_code']);

    if(!$valid) {
      $error = 1;
      $code[3] = 'color:#FF0000;';   
      $code[4] = '<strong><span style="color:#FF0000;">Incorrect code</span></strong>';
    }
  }

  if ($error == 1) {
    $error_message = '<span style="font-weight:bold;font-size:90%;color:#ff0000">Please correct/enter field(s) in red.<br /><br /></span>';

    showForm();

  } else {
  	
  	if (function_exists('htmlspecialchars_decode')) $subject[2] = htmlspecialchars_decode($subject[2], ENT_QUOTES);
  	if (function_exists('htmlspecialchars_decode')) $message[2] = htmlspecialchars_decode($message[2], ENT_QUOTES);  	
  	
    $body .= "$fname[0]: $fname[2]\r\n\r\n";
    $body .= "$lname[0]: $lname[2]\r\n\r\n";
    $body .= "$email[0]: $email[2]\r\n\r\n";
    $body .= "$phone[0]: $phone[2]\r\n\r\n";
    $body .= "$city[0]: $city[2]\r\n\r\n";
    $body .= "$state[0]: $state[2]\r\n\r\n";
    $body .= "$snptips_installed[0]: $snptips_installed[2]\r\n\r\n";
    $body .= "$snptips_future[0]: $snptips_future[2]\r\n\r\n";
    $body .= "$gift[0]: $gift[2]\r\n\r\n";
    
    if (!$from) $from_value = $email[2];
    else $from_value = $from;
    
    $headers = "Content-type: text/plain; $charset" . "\r\n";
    $headers .= "From: $from_value" . "\r\n";
    $headers .= "Reply-To: $email[2]" . "\r\n";
    
    mail($to,"$subject_prefix", $body, $headers);
    
    if (!$thank_you_url) {    
      if ($use_header_footer) include $header_file;
      echo '<a name="cform"><!--Form--></a>'."\n";
      echo '<div id="formContainer" style="width:'.$form_width.';height:'.$form_height.';text-align:left; vertical-align:top;">'."\n";
      echo $GLOBALS['thank_you_message']."\n";
      echo '</div>'."\n";
      if ($use_header_footer) include $footer_file;
	  }
	  else {
	  	header("Location: $thank_you_url");
	  }
       	
  }

} //else submitted



function showForm()

{
global $fname, $lname, $email, $phone, $city, $state, $snptips_installed, $snptips_future, $gift, $subject, $code;
global $where_included, $use_header_footer, $header_file, $footer_file;
global $form_width, $form_height, $form_background, $form_border_color, $form_border_width, $form_border_style, $cell_padding, $left_col_width; 	

if ($use_header_footer) include $header_file;

echo $GLOBALS['error_message'];  

echo <<<EOD
<a name="cform"><!--Form--></a>
<div id="formContainer" style="width:{$form_width};">
<form method="post" class="cForm" action="{$where_included}#cform">
<table style="width:100%; background:{$form_background}; border:{$form_border_width} {$form_border_style} {$form_border_color}; padding:10px;" id="contactForm">
<tr>
<td colspan="2" style="padding:{$cell_padding};text-align:center;"><em><span style="font-size:12px;">Required fields are denoted by asterisks. Limit one submission per household.</span></em><br /><br /></td>
</tr>
<tr>
<td style="width:{$left_col_width}; text-align:right; vertical-align:middle; padding:{$cell_padding}; font-weight:bold; {$fname[3]}">{$fname[0]}*</td>
<td style="text-align:left; vertical-align:middle; padding:{$cell_padding};"><input type="text" size="40" name="{$fname[1]}" value="{$fname[2]}" id="{$fname[1]}" /></td>
</tr>
<tr>
<td style="width:{$left_col_width}; text-align:right; vertical-align:middle; padding:{$cell_padding}; font-weight:bold; {$lname[3]}">{$lname[0]}*</td>
<td style="text-align:left; vertical-align:middle; padding:{$cell_padding};"><input type="text" size="40" name="{$lname[1]}" value="{$lname[2]}" id="{$lname[1]}" /></td>
</tr>
<tr>
<td style="width:{$left_col_width}; text-align:right; vertical-align:middle; padding:{$cell_padding}; font-weight:bold; {$email[3]}">{$email[0]}*</td>
<td style="text-align:left; vertical-align:middle; padding:{$cell_padding};"><input type="text" size="40" name="{$email[1]}" value="{$email[2]}" id="{$email[1]}" /> {$email[4]}</td>
</tr>
<tr>
<td style="width:{$left_col_width}; text-align:right; vertical-align:middle; padding:{$cell_padding}; font-weight:bold; {$phone[3]}">{$phone[0]}</td>
<td style="text-align:left; vertical-align:middle; padding:{$cell_padding};"><input type="text" size="40" name="{$phone[1]}" value="{$phone[2]}" id="{$phone[1]}" /></td>
</tr>
<tr>
<td style="width:{$left_col_width}; text-align:right; vertical-align:middle; padding:{$cell_padding}; font-weight:bold; {$city[3]}">{$city[0]}</td>
<td style="text-align:left; vertical-align:middle; padding:{$cell_padding};"><input type="text" size="40" name="{$city[1]}" value="{$city[2]}" id="{$city[1]}" /></td>
</tr>
<tr>
<td style="width:{$left_col_width}; text-align:right; vertical-align:middle; padding:{$cell_padding}; font-weight:bold; {$state[3]}">{$state[0]}</td>
<td style="text-align:left; vertical-align:middle; padding:{$cell_padding};"><input type="text" size="40" name="{$state[1]}" value="{$state[2]}" id="{$state[1]}" /></td>
</tr>
<tr>
	<td colspan="2" style="border-top:1px dotted #ccc;"></td>
</tr>
<tr>
<td style="width:{$left_col_width}; text-align:right; vertical-align:middle; padding:6px 3px; font-weight:bold;">Have you installed SNPTips?</td>
<td style="text-align:left; vertical-align:middle; padding:6px 3px;">
<input type="radio" name="snptips_installed" id="snptips_not_installed" value="No" /> <label for="snptips_not_installed" style="display:inline; font-weight:normal;" />No</label> &nbsp;&nbsp;&nbsp;
<input type="radio" name="snptips_installed" id="snptips_installed" value="Yes" /> <label for="snptips_installed" style="display:inline; font-weight:normal;" />Yes</label>
</td>
</tr>
<tr>
<td style="width:{$left_col_width}; text-align:right; vertical-align:middle; padding:6px 3px; font-weight:bold;"><em>If no</em>, do you plan on installing it?</td>
<td style="text-align:left; vertical-align:middle; padding:6px 3px;">
<input type="radio" name="snptips_future" id="snptips_future_no" value="No" /> <label for="snptips_future_no" style="display:inline; font-weight:normal;" />No</label> &nbsp;&nbsp;&nbsp;
<input type="radio" name="snptips_future" id="snptips_future_yes" value="Yes" /> <label for="snptips_future_yes" style="display:inline; font-weight:normal;" />Yes</label>
</td>
</tr>
<tr>
<td style="width:{$left_col_width}; text-align:right; vertical-align:middle; padding:6px 3px; font-weight:bold;">Choose your prize:</td>
<td style="text-align:left; vertical-align:middle; padding:6px 3px;">
<input type="radio" name="gift" id="gift_apple" value="Apple Giftcard" /> <label for="gift_apple" style="display:inline; margin:5px 0; font-weight:normal;" />$200 Apple Giftcard</label> &nbsp;&nbsp;&nbsp;
<input type="radio" name="gift" id="gift_23andme" value="23andMe Service" /> <label for="gift_23andme" style="display:inline; margin:5px 0; font-weight:normal;" />1 Year of 23andMe Service</label>
</td>
</tr>
<tr>
	<td colspan="2" style="border-top:1px dotted #ccc;"></td>
</tr>
<tr>
<td style="width:{$left_col_width}; text-align:right; vertical-align:top; padding:{$cell_padding};">&nbsp;</td>
<td style="text-align:left; vertical-align:top; padding:{$cell_padding};"><img id="captcha" src="contact-securimage_show.php" alt="CAPTCHA Image" /></td>
</tr>
<tr>
<td style="width:{$left_col_width}; text-align:right; vertical-align:top; padding:{$cell_padding}; font-weight:bold; {$code[3]}">{$code[0]}*</td>
<td style="text-align:left; vertical-align:top; padding:{$cell_padding};"><input type="text" name="{$code[1]}" size="10" maxlength="5" id="{$code[1]}" /> {$code[4]}
<br /><span style="font-size:12px;">(Please enter the text in the image above. Text is not case sensitive.)<br />
<a href="#" onclick="document.getElementById('captcha').src = 'contact-securimage_show.php?' + Math.random(); return false">Click here if you cannot recognize the code.</a></span>
</td>
</tr>
<tr>
	<td colspan="2" style="border-top:1px dotted #ccc;"></td>
</tr>
<tr>
<td></td>
<td style="text-align:left; vertical-align:middle; padding:{$cell_padding};"><input type="submit" name="submit" value="Submit Entry Now!" style="border:1px solid #0af;background:#0af;margin-top:5px;padding:5px 15px;font-weight:bold;color:#fff;-moz-border-radius:5px; -webkit-border-radius:5px; border-radius:5px; -moz-box-shadow: 0 1px 3px rgba(0,0,0,0.2); -webkit-box-shadow: 0 1px 3px rgba(0,0,0,0.2);" id="submit_button" /></td>
</tr>
</table>
</form>
</div>
EOD;

if ($use_header_footer) include $footer_file;
}

function clean_var($variable) {
    $variable = strip_tags(stripslashes(trim(rtrim($variable))));
  return $variable;
}

/**
Email validation function. Thanks to http://www.linuxjournal.com/article/9585
*/
function validEmail($email)
{
   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex)
   {
      $isValid = false;
   }
   else
   {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64)
      {
         // local part length exceeded
         $isValid = false;
      }
      else if ($domainLen < 1 || $domainLen > 255)
      {
         // domain part length exceeded
         $isValid = false;
      }
      else if ($local[0] == '.' || $local[$localLen-1] == '.')
      {
         // local part starts or ends with '.'
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $local))
      {
         // local part has two consecutive dots
         $isValid = false;
      }
      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
      {
         // character not valid in domain part
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $domain))
      {
         // domain part has two consecutive dots
         $isValid = false;
      }
      else if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local)))
      {
         // character not valid in local part unless 
         // local part is quoted
         if (!preg_match('/^"(\\\\"|[^"])+"$/',
             str_replace("\\\\","",$local)))
         {
            $isValid = false;
         }
      }
      if ($isValid && function_exists('checkdnsrr'))
      {
      	if (!(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A"))) {
         // domain not found in DNS
         $isValid = false;
       }
      }
   }
   return $isValid;
}


?>