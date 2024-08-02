<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


//configure aqui seu email
$config['protocol']='smtp';
$config['smtp_host']='smtp.gmail.com';
$config['smtp_crypto'] = 'tls';
$config['smtp_port']= 587;
$config['starttls'] = TRUE;
$config['validate']= TRUE;
$config['smtp_user']='';
$config['smtp_pass']='';
$config['charset']='UTF-8';
$config['mailtype']='html';
$config['newline']="\r\n"; 



