<?php

if(!defined('IN_GS')){ die('you cannot load this page directly.'); }

/**
* SendMailSmtpClass
*
* Class for sending letters via SMTP with authorization
* Can work via SSL protocol
* Tested on mail servers yandex.ru, mail.ru and gmail.com, smtp.beget.com
*
* v 1.1
* Added:
* - Ehlo server greeting in priority, if not the server did not respond, then helo is sent
* - Working with utf-8 and windows-1251 encodings
* - Ability to send to multiple recipients
* - Automatic generation of letter headers
* - Ability to attach files to the letter
*
* @author Ipatov Evgeniy <admin@vk-book.ru>
* @version 1.1
* 
* NetExplorer mod v1.0 for my-smtp-contact.php (GetSimple CMS plugin) netexplorer@yandex.ru
*/
class SendMailSmtpClass {

    /**
    *
    * @var string $smtp_username - login
    * @var string $smtp_password - password
    * @var string $smtp_host - host
    * @var string $smtp_from - from whom
    * @var integer $smtp_port - port
    * @var string $smtp_charset - encoding
    *
    */   
    public $smtp_username;
    public $smtp_password;
    public $smtp_host;
    public $smtp_from;
    public $smtp_port;
    public $smtp_charset;
	public $boundary;
    public $addFile = false;
    public $multipart;
	
	/**
	 CSS styles for email tarts.
	 */
	private $_styles = array(
		'body'  => 'margin: 0 0 0 0; padding: 10px 10px 10px 10px; background: #ffffff; color: #000000; font-size: 14px; font-family: Arial, Helvetica, sans-serif; line-height: 18px;', 
		'a'     => 'color: #003399; text-decoration: underline; font-size: 14px; font-family: Arial, Helvetica, sans-serif; line-height: 18px;', 
		'p'     => 'margin: 0 0 20px 0; padding: 0 0 0 0; color: #000000; font-size: 14px; font-family: Arial, Helvetica, sans-serif; line-height: 18px;', 
		'ul'    => 'margin: 0 0 20px 20px; padding: 0 0 0 0; color: #000000; font-size: 14px; font-family: Arial, Helvetica, sans-serif; line-height: 18px;', 
		'ol'    => 'margin: 0 0 20px 20px; padding: 0 0 0 0; color: #000000; font-size: 14px; font-family: Arial, Helvetica, sans-serif; line-height: 18px;', 
		'table' => 'margin: 0 0 20px 0; border: 1px solid #dddddd; border-collapse: collapse;',
		'th'    => 'padding: 10px; border: 1px solid #dddddd; vertical-align: middle; background-color: #eeeeee; color: #000000; font-size: 14px; font-family: Arial, Helvetica, sans-serif; line-height: 18px;',
		'td'    => 'padding: 10px; border: 1px solid #dddddd; vertical-align: middle; background-color: #ffffff; color: #000000; font-size: 14px; font-family: Arial, Helvetica, sans-serif; line-height: 18px;', 
		'h1'    => 'margin: 0 0 20px 0; padding: 0 0 0 0; color: #000000; font-size: 22px; font-family: Arial, Helvetica, sans-serif; line-height: 26px; font-weight: bold;', 
		'h2'    => 'margin: 0 0 20px 0; padding: 0 0 0 0; color: #000000; font-size: 20px; font-family: Arial, Helvetica, sans-serif; line-height: 24px; font-weight: bold;', 
		'h3'    => 'margin: 0 0 20px 0; padding: 0 0 0 0; color: #000000; font-size: 18px; font-family: Arial, Helvetica, sans-serif; line-height: 22px; font-weight: bold;', 
		'h4'    => 'margin: 0 0 20px 0; padding: 0 0 0 0; color: #000000; font-size: 16px; font-family: Arial, Helvetica, sans-serif; line-height: 20px; font-weight: bold;', 
		'hr'    => 'height: 1px; border: none; color: #dddddd; background: #dddddd; margin: 0 0 20px 0;'
	);

	/**
	 * Adding styles to the tags.
	 */
	public function addHtmlStyle($html)
	{
		foreach ($this->_styles as $tag => $style) {
			preg_match_all('/<' . $tag . '([\s].*?)?>/i', $html, $matchs, PREG_SET_ORDER); 
			foreach ($matchs as $match) {
				$attrs = array();
				if (!empty($match[1])) {
					preg_match_all('/[ ]?(.*?)=[\"|\'](.*?)[\"|\'][ ]?/', $match[1], $chanks);
					if (!empty($chanks[1]) && !empty($chanks[2])) {
						$attrs = array_combine($chanks[1], $chanks[2]);
					}
				} 

				if (empty($attrs['style'])) {
					$attrs['style'] = $style;
				} else {
					$attrs['style'] = rtrim($attrs['style'], '; ') . '; ' . $style;
				}
				
				$compile = array();
				foreach ($attrs as $name => $value) {
					$compile[] = $name . '="' . $value . '"';
				}
				
				$html = str_replace($match[0], '<' . $tag . ' ' . implode(' ', $compile) . '>', $html);
			}
		}
		
		return $html;
	}
    
    public function __construct($smtp_username, $smtp_password, $smtp_host, $smtp_port = 25, $smtp_charset = "utf-8") {
        $this->smtp_username = $smtp_username;
        $this->smtp_password = $smtp_password;
        $this->smtp_host = $smtp_host;
        $this->smtp_port = $smtp_port;
        $this->smtp_charset = $smtp_charset;
		
		// file delimiter
		$this->boundary = "--".md5(uniqid(time()));
		$this->multipart = "";
    }
    
    /**
    * Sending letter
    *
    * @param string $mailTo - email recipient
    * @param string $subject - letter subject
    * @param string $message - message body
    * @param string $smtp_from - the sender. Array with name and e-mail
    *
    * @return bool | string Returns true in cases of sending, otherwise the error text
	*
    */
    function send($mailTo, $subject, $message, $smtp_from) {

		//** Text of the letter.
		$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			</head>
			<body>
				' . $message . '
			</body>
		</html>';
		
		//** Add styles to tags.
		$message = $this->addHtmlStyle($message);
		
		// preparation of the contents of the letter to send
		$contentMail = $this->getContentMail($subject, $message, $smtp_from, $mailTo);
        
        try {
            if(!$socket = @fsockopen($this->smtp_host, $this->smtp_port, $errorNumber, $errorDescription, 30)){
                throw new Exception($errorNumber.".".$errorDescription);
            }
            if (!$this->_parseServer($socket, "220")){
                throw new Exception('Connection error');
            }
			
			$server_name = $_SERVER["SERVER_NAME"];
            fputs($socket, "EHLO $server_name\r\n");
			if(!$this->_parseServer($socket, "250")){
				// if the server did not respond to EHLO, then send HELO
				fputs($socket, "HELO $server_name\r\n");
				if (!$this->_parseServer($socket, "250")) {				
					fclose($socket);
					throw new Exception('Error of command sending: HELO');
				}				
			}
			
            fputs($socket, "AUTH LOGIN\r\n");
            if (!$this->_parseServer($socket, "334")) {
                fclose($socket);
                throw new Exception('Autorization error');
            }
			
            fputs($socket, base64_encode($this->smtp_username) . "\r\n");
            if (!$this->_parseServer($socket, "334")) {
                fclose($socket);
                throw new Exception('Autorization error');
            }
            
            fputs($socket, base64_encode($this->smtp_password) . "\r\n");
            if (!$this->_parseServer($socket, "235")) {
                fclose($socket);
                throw new Exception('Autorization error');
            }
			
            fputs($socket, "MAIL FROM: <".$this->smtp_username.">\r\n");
            if (!$this->_parseServer($socket, "250")) {
                fclose($socket);
                throw new Exception('Error of command sending: MAIL FROM');
            }
            
			$mailTo = str_replace(" ", "", $mailTo);
			$emails_to_array = explode(',', $mailTo);
			foreach($emails_to_array as $email) {
				fputs($socket, "RCPT TO: <{$email}>\r\n");
				if (!$this->_parseServer($socket, "250")) {
					fclose($socket);
					throw new Exception('Error of command sending: RCPT TO');
				}
			}
			
            fputs($socket, "DATA\r\n");     
            if (!$this->_parseServer($socket, "354")) {
                fclose($socket);
                throw new Exception('Error of command sending: DATA');
            }
            
            fputs($socket, $contentMail."\r\n.\r\n");
            if (!$this->_parseServer($socket, "250")) {
                fclose($socket);
                throw new Exception("E-mail didn't sent");
            }
            
            fputs($socket, "QUIT\r\n");
            fclose($socket);
        } catch (Exception $e) {
            return  $e->getMessage();
        }
        return true;
    }
	
		
	// add file to email
	public function addFile($path, $realname){
		$file = @fopen($path, "rb");
		if(!$file) {
			throw new Exception("File `{$path}` didn't open");
		}		
		$data = fread($file,  filesize( $path ) );
		fclose($file);
		$filename = basename($path);		
		$multipart  =  "\r\n--{$this->boundary}\r\n";   
		$multipart .= "Content-Type: application/octet-stream; name=\"$filename\"\r\n";   
		$multipart .= "Content-Transfer-Encoding: base64\r\n";   
		$multipart .= "Content-Disposition: attachment; filename=\"$realname\"\r\n";   
		$multipart .= "\r\n";
		$multipart .= chunk_split(base64_encode($data));  
        
		$this->multipart .= $multipart;
		$this->addFile = true;		
	}
    
	// parsing server response
    private function _parseServer($socket, $response) {
        while (@substr($responseServer, 3, 1) != ' ') {
            if (!($responseServer = fgets($socket, 256))) {
                return false;
            }
        }
        if (!(substr($responseServer, 0, 3) == $response)) {
            return false;
        }
        return true;        
    }
	
	// preparation of the contents of the letter
	private function getContentMail($subject, $message, $smtp_from, $mailTo){	
		// if the encoding is windows-1251, then re-encode the theme
		if( strtolower($this->smtp_charset) == "windows-1251" ){
			$subject = iconv('utf-8', 'windows-1251', $subject);
		}
        $contentMail = "Date: " . date("D, d M Y H:i:s") . " UT\r\n";
        $contentMail .= 'Subject: =?' . $this->smtp_charset . '?B?'  . base64_encode($subject) . "=?=\r\n";
		
		// letter header
		$headers = "MIME-Version: 1.0\r\n";
		// letter encoding
		if($this->addFile){
			// if there are files
			$headers .= "Content-Type: multipart/mixed; boundary=\"{$this->boundary}\"\r\n"; 
		}else{
			$headers .= "Content-type: text/html; charset={$this->smtp_charset}\r\n";
		}
		$headers .= "From: {$smtp_from[0]} <{$smtp_from[1]}>\r\n"; // from whom the letter
		$headers.= "To: ".$mailTo."\r\n"; // to whom
        $contentMail .= $headers . "\r\n";		
		
		if($this->addFile){
			// if there are files
			$multipart  = "--{$this->boundary}\r\n";   
			$multipart .= "Content-Type: text/html; charset=utf-8\r\n";   
			$multipart .= "Content-Transfer-Encoding: base64\r\n";   
			$multipart .= "\r\n";
			$multipart .= chunk_split(base64_encode($message)); 
			
			// files
			$multipart .= $this->multipart; 
			$multipart .= "\r\n--{$this->boundary}--\r\n";
			
			$contentMail .= $multipart;
		}else{
			$contentMail .= $message . "\r\n";
		}
		
		// if the encoding is windows-1251, then we will re-encode the whole letter
		if( strtolower($this->smtp_charset) == "windows-1251" ){
			$contentMail = iconv('utf-8', 'windows-1251', $contentMail);
		}	
		
		return $contentMail;
	}
	
}

?>