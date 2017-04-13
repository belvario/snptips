<?php
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

/*******************************************************************************
 *	IMPORTANT
*******************************************************************************/

/* Email address where the messages should be delivered */

$to = 'kwoods@5amsolutions.com';

/* This will be appended to the subject of contact form message */

$subject_prefix = 'SNPTips QR Promo Submission';

/* Name of the file where you are including the contact form */

$where_included = '';

/*******************************************************************************
 *	OPTIONAL
*******************************************************************************/

/* From email address, in case your server prohibits sending emails from 
 * addresses other than those of your own domain (e.g. email@yourdomain.com). */

$from = 'website@snptips.com';

/* Whether to use header/footer files? If yes, then set to TRUE */

$use_header_footer = FALSE;

/* Form header file */

$header_file = 'contact-header.php';

/* Form footer file */

$footer_file = 'contact-footer.php';

/* Thank you message to be displayed after the form is submitted. Can include 
 * HTML tags. Write your message between <!-- Start message --> and <!-- End message --> */

$thank_you_message = <<<EOD
<!-- Start message -->
<div class="thankyou_panel">
<h1 style="margin:10px 0 10px 0 !important;">Thank You!</h1>
<p style="margin:0; float:none;"><strong>We have received your submission. If you've won, we'll get back to you using the contact information you provided. | Back to the <a href="../../">SNPTips Homepage</strong></p>
</div>
<!-- End message -->
EOD;

/* URL to be redirected to after the form is submitted. If this is specified, 
 * then the above message will not be shown and user will be redirected to this 
 * page after the form is submitted. */

$thank_you_url = '';

/* Default character encoding of emails */

$charset = 'charset=UTF-8';

/*******************************************************************************
 *	COSMETICS
*******************************************************************************/

/* Form width in px or % value */

$form_width = '710px';

/* Form height in px */

$form_height = '';

/* Form background color or image. Value can contain just a color value or 
 * complete background shorthand property (with background image). */
 
$form_background = '#ffffff';

/* Form border color */

$form_border_color = '#CCCCCC';

/* Form border width */

$form_border_width = '0';

/* Form border style. Examples - dotted, dashed, solid, double */

$form_border_style = 'solid';

/* Form cell padding */

$cell_padding = '3px';

/* Form left column width */

$left_col_width = '36%';


/*******************************************************************************
 *	Do not change anything below, unless of course you know very well 
 *	what you are doing :)
*******************************************************************************/

$fname = array('First Name','fname',NULL,NULL);
$lname = array('Last Name','lname',NULL,NULL);
$email = array('Email','email',NULL,NULL,NULL);
$phone = array('Phone','phone',NULL,NULL);
$city = array('City','city',NULL,NULL);
$state = array('State','state',NULL,NULL);
$snptips_installed = array('SNPTips Installed?','snptips_installed',NULL,NULL);
$snptips_future = array('Install SNPTips in the Future?','snptips_future',NULL,NULL);
$gift = array('Prize Choice','gift',NULL,NULL);
$message = array('Message','message',NULL,NULL);
$code = array('Code','captcha_code',NULL,NULL,NULL);

?>