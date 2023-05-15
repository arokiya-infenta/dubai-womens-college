<?php defined('BASEPATH') OR exit('No direct script access allowed');
  $config = array(    
   
  
    'protocol'  => 'smtp', 
    'smtp_host' => 'ssl://smtp.gmail.com', 
    'smtp_port' => 465,    
    'smtp_user' => 'admissions@mssw.in',   
    'smtp_pass' => 'mssw@123456789',
    'mailtype'  => 'html',    
    'charset'   => 'utf-8',
   
  
);
/* $config = array('protocol'  => 'smtp',
    'smtp_host' => 'ssl://mail.supremecluster.com',
    'smtp_port' => 465,
    'smtp_user' => 'admin@iitmanagement.co.in',
    'smtp_pass' => 'ISTyuva20*',    
	'mailtype'  => 'html',
    'charset'   => 'utf-8'); */
 /*
$config = array(
    'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
    'smtp_host' => 'ssl://smtp.gmail.com', 
    'smtp_port' => 465, 
    'smtp_user' => 'admission.mssw@gmail.com', 
    'smtp_pass' => 'loveindia@123', 
    'smtp_crypto' => 'security', //can be 'ssl' or 'tls' for example
    'mailtype' => 'html', //plaintext 'text' mails or 'html'
    'smtp_timeout' => '4', //in seconds
    'charset' => 'iso-8859-1',
    'wordwrap' => TRUE,
    'newline' => '\r\n'
);
*/
/* $config = array(
    'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
    'smtp_host' => 'your_host',
    'smtp_port' => your_port,
    'smtp_user' => 'your_email',
    'smtp_pass' => 'your_password',
    'smtp_crypto' => 'security', //can be 'ssl' or 'tls' for example
    'mailtype' => 'html', //plaintext 'text' mails or 'html'
    'smtp_timeout' => '4', //in seconds
    'charset' => 'iso-8859-1',
    'wordwrap' => TRUE
); */