<?php

if(!defined('IN_GS')){ die('you cannot load this page directly.'); }

/**
* PHP class for sending E-mail.
* 
* @author Snipp.ru
* @website http://snipp.ru/view/80
* @version 2.2
* 
* NetExplorer mod v1.0 for my-smtp-contact.php (GetSimple CMS plugin) netexplorer@yandex.ru
*/
class SendMailClass
{
	/**
	 From whom.
	 */
	public $fromEmail = '';
	public $fromName = '';
	
	/**
	 To whom.
	 */
	public $toEmail = '';
	public $toName = '';
	
	/**
	 The theme.
	 */
	public $subject = '';
	
	/**
	 The text.
	 */
	public $body = '';
	
	/**
	 An array of file titles.
	 */
	private $_files = array();
	
	/**
	 Manage the dumping.
	 */
	public $dump = false;
	
	/**
	 Directory where to save letters.
	 */
	public $dumpPath = '';
	
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
	 Checking the existence of the file.
	 If the directory does not exist, he tries to create it.
	 If the file exists , at the end of the file ascribes the prefix.
	 */
	private function safeFile($filename)
	{
		$dir = dirname($filename);
		if (!is_dir($dir)) {
			mkdir($dir, 0777, true);
		}
		
		$info   = pathinfo($filename);
		$name   = $dir . '/' . $info['filename']; 
		$ext    = (empty($info['extension'])) ? '' : '.' . $info['extension'];
		$prefix = '';
		
		if (is_file($name . $ext)) {
			$i = 1;
			$prefix = '_' . $i;
			
			while (is_file($name . $prefix . $ext)) {
				$prefix = '_' . ++$i;
			}
		}
		
		return $name . $prefix . $ext;
	}
	
	/**
	 * From whom.
	 */
	public function from($email, $name = null)
	{
		$this->fromEmail = $email;
		$this->fromName = $name;
	}
	
	/**
	 * To whom.
	 */
	public function to($email, $name = null)
	{
		$this->toEmail = $email;
		$this->toName = $name;
	}
	
	/**
	 * Adding a file to a letter.
	 */
	public function addFile($filename, $realname)
	{
		if (is_file($filename)) {
			$name = basename($filename);
			$fp   = fopen($filename, 'rb');  
			$file = fread($fp, filesize($filename));   
			fclose($fp);
			$this->_files[] = array( 
				'Content-Type: application/octet-stream; name="' . $name . '"',   
				'Content-Transfer-Encoding: base64',  
				'Content-Disposition: attachment; filename="' . $realname . '"',   
				'',
				chunk_split(base64_encode($file)),
			);
		}
	}
	
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
	
	/**
	 * Sending.
	 */
	public function send()
	{
		if (empty($this->toEmail)) {
			return false;
		}
		
		// From whom.
		$from = (empty($this->fromName)) ? $this->fromEmail : '=?UTF-8?B?' . base64_encode($this->fromName) . '?= <' . $this->fromEmail . '>';
		
		// To.
		$array_to = array();
		foreach (explode(',', $this->toEmail) as $row) {
			$row = trim($row);
			if (!empty($row)) {
				$array_to[] = (empty($this->toName)) ? $row : '=?UTF-8?B?' . base64_encode($this->toName) . '?= <' . $row . '>';
			}
		}
		
		// Topic of the letter.
		$subject = (empty($this->subject)) ? 'No subject' : $this->subject;
		// $subject = (empty($this->subject)) ? 'No subject' : '=?UTF-8?B?' . base64_encode($this->subject) . '?=';
		
		// Text of the letter.
		$body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			</head>
			<body>
				' . $this->body . '
			</body>
		</html>';
		
		// Add styles to tags.
		$body = $this->addHtmlStyle($body);
	
		$boundary = md5(uniqid(time()));
		
		// The title of the letter.
		$headers = array(
			'Content-Type: multipart/mixed; boundary="' . $boundary . '"',
			'Content-Transfer-Encoding: 7bit',
			'MIME-Version: 1.0',
			'From: ' . $from,
			'Date: ' . date('r')
		);
		
		// The body of the letter.
		$message = array(
			'--' . $boundary,
			'Content-Type: text/html; charset=UTF-8',
			'Content-Transfer-Encoding: base64',
			'',
			chunk_split(base64_encode($body))
		);
		
		if (!empty($this->_files)) {
			foreach ($this->_files as $row) {
				$message = array_merge($message, array('', '--' . $boundary), $row);
			}
		}
		
		$message[] = '';
		$message[] = '--' . $boundary . '--';
		$res = array();
		
		foreach ($array_to as $to) {
			// Dump the letter to the file.
			if ($this->dump == true) {
				if (empty($this->dumpPath)) {
					$this->dumpPath = dirname(__FILE__) . '/sendmail';
				}
				
				$dump = array_merge($headers, array('To: ' . $to, 'Subject: ' . $subject, ''), $message);
				$file = $this->safeFile($this->dumpPath . '/' . date('Y-m-d_H-i-s') . '.eml');
				file_put_contents($file, implode("\r\n", $dump));
			}
			$res[] = function_exists('mb_send_mail') ? mb_send_mail($to, $subject, implode("\r\n", $message), implode("\r\n", $headers)) : mail($to, $subject, implode("\r\n", $message), implode("\r\n", $headers));
		}
		
		return $res;
	}
}