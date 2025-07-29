<?php

$receiving_email_address = 'mismailshah496@gmail.com'; // Change to your Gmail

if( file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php' )) {
  include( $php_email_form );
} else {
  die( 'Unable to load the "PHP Email Form" Library!');
}

$contact = new PHP_Email_Form;
$contact->ajax = true;

$contact->to = $receiving_email_address;
$contact->from_name = $_POST['name'];
$contact->from_email = $_POST['email'];
$contact->subject = $_POST['subject'];

$contact->smtp = array(
  'host' => 'smtp.gmail.com',
  'username' => 'mismailshah496@gmail.com', // your Gmail
  'password' => 'djeu kixs iicj wlyn', // the 16-character app password from step 2
  'port' => '587',
  'encryption' => 'tls'
);

$contact->add_message( $_POST['name'], 'From');
$contact->add_message( $_POST['email'], 'Email');
$contact->add_message( $_POST['message'], 'Message', 10);

echo $contact->send();
?>
