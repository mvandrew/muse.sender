<?php

define( "_MS_LIB", dirname(__FILE__) );

// Include config
require_once ( _MS_LIB . '/config.php' );

// Include PHPMailer classes
require_once ( _MS_LIB . '/phpmailer/src/Exception.php' );
require_once ( _MS_LIB . '/phpmailer/src/SMTP.php' );
require_once ( _MS_LIB . '/phpmailer/src/PHPMailer.php' );

// Include script classes
require_once ( _MS_LIB . '/classes/class_ssl_mailer.php' );