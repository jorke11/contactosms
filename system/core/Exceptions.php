<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * Exceptions Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Exceptions
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/exceptions.html
 */
class CI_Exceptions {

    var $action;
    var $severity;
    var $message;
    var $filename;
    var $line;

    /**
     * Nesting level of the output buffering mechanism
     *
     * @var int
     * @access public
     */
    var $ob_level;

    /**
     * List if available error levels
     *
     * @var array
     * @access public
     */
    var $levels = array(
        E_ERROR => 'Error',
        E_WARNING => 'Warning',
        E_PARSE => 'Parsing Error',
        E_NOTICE => 'Notice',
        E_CORE_ERROR => 'Core Error',
        E_CORE_WARNING => 'Core Warning',
        E_COMPILE_ERROR => 'Compile Error',
        E_COMPILE_WARNING => 'Compile Warning',
        E_USER_ERROR => 'User Error',
        E_USER_WARNING => 'User Warning',
        E_USER_NOTICE => 'User Notice',
        E_STRICT => 'Runtime Notice'
    );

    /**
     * Constructor
     */
    public function __construct() {
        $this->ob_level = ob_get_level();
        // Note:  Do not log messages from this constructor.
    }

    // --------------------------------------------------------------------

    /**
     * Exception Logger
     *
     * This function logs PHP generated error messages
     *
     * @access	private
     * @param	string	the error severity
     * @param	string	the error string
     * @param	string	the error filepath
     * @param	string	the error line number
     * @return	string
     */
    function log_exception($severity, $message, $filepath, $line) {
        $severity = (!isset($this->levels[$severity])) ? $severity : $this->levels[$severity];

        log_message('error', 'Severity: ' . $severity . '  --> ' . $message . ' ' . $filepath . ' ' . $line, TRUE);
    }

    // --------------------------------------------------------------------

    /**
     * 404 Page Not Found Handler
     *
     * @access	private
     * @param	string	the page
     * @param 	bool	log error yes/no
     * @return	string
     */
    function show_404($page = '', $log_error = TRUE) {
        $heading = "404 Page Not Found";
        $message = "The page you requested was not found.";

        // By default we log this, but allow a dev to skip it
        if ($log_error) {
            log_message('error', '404 Page Not Found --> ' . $page);
        }

        echo $this->show_error($heading, $message, 'error_404', 404);
        exit;
    }

    // --------------------------------------------------------------------

    /**
     * General Error Page
     *
     * This function takes an error message as input
     * (either as a string or an array) and displays
     * it using the specified template.
     *
     * @access	private
     * @param	string	the heading
     * @param	string	the message
     * @param	string	the template name
     * @param 	int		the status code
     * @return	string
     */
    function show_error($heading, $message, $template = 'error_general', $status_code = 500) {
        set_status_header($status_code);

        $message = '<p>' . implode('</p><p>', (!is_array($message)) ? array($message) : $message) . '</p>';
        print_r($message);
        exit;
        if (ob_get_level() > $this->ob_level + 1) {
            ob_end_flush();
        }
        ob_start();
        include(APPPATH . 'errors/' . $template . '.php');
        $buffer = ob_get_contents();
        ob_end_clean();
        return $buffer;
    }

    // --------------------------------------------------------------------

    /**
     * Native PHP error handler
     *
     * @access	private
     * @param	string	the error severity
     * @param	string	the error string
     * @param	string	the error filepath
     * @param	string	the error line number
     * @return	string
     */
    function show_php_error($severity, $message, $filepath, $line) {
        $severity = (!isset($this->levels[$severity])) ? $severity : $this->levels[$severity];

        $filepath = str_replace("\\", "/", $filepath);


        // For safety reasons we do not show the full file path
        if (FALSE !== strpos($filepath, '/')) {
            $x = explode('/', $filepath);
            $filepath = $x[count($x) - 2] . '/' . end($x);
        }

        if (ob_get_level() > $this->ob_level + 1) {
            ob_end_flush();
        }

        ob_start();
        include(APPPATH . 'errors/error_php.php');
        $buffer = ob_get_contents();
        ob_end_clean();
        echo $buffer;
        
    }

    function ErrorPhp($linea, $msj, $archivo) {
        require APPPATH . 'libraries/PHPMailer/PHPMailerAutoload.php';


        $mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'ssl://smtp.googlemail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'notifica@contactosms.com.co';                 // SMTP username
        $mail->Password = 'notifica2014';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to

        $mail->From = 'jorke8710@gmail.com';
        $mail->FromName = 'Debugger';
        $mail->addAddress('oskarcuervo@gmail.com', 'OC5');     // Add a recipient
        $mail->CharSet = 'UTF-8';
        $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
        $mail->isHTML(true);                                  // Set email format to HTML
        $usuario=(isset($_SESSION["usuario"]))?$_SESSION["usuario"]:'Cron';
        $mail->Subject = 'Errores Php';
        $mail->Body = '<b>Linea: </b> ' . $linea . '<br>';
        $mail->Body .= '<b>Usuario: </b>' . $_SESSION["usuario"] . '<br>';
        $mail->Body .= '<b>Error: </b> ' . $msj . '<br>';
        $mail->Body .= '<b>Archivo: </b> ' . $archivo . '<br>';

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }

}

// END Exceptions Class

/* End of file Exceptions.php */
/* Location: ./system/core/Exceptions.php */
