<?php

if(!defined('IN_GS')){ die('You cannot load this page directly.'); }

Error_Reporting(0); // E_ALL & ~E_NOTICE

/*
Plugin Name: My SMTP Contact (my-smtp-contact.php)
Description: Contact form with a captcha, alternative fields and the ability to send emails via SMTP
Version: 1.1.2 / mar 2021
Author: NetExplorer
Email: netexplorer@yandex.ru
Author URI: http://netexplorer.h1n.ru

This plugin will help you to set up a contact form with captcha and checkbox. 
Plugin can be used SMTP (Simple Mail Transfer Protocol) to send mail.

How to install a contact form?

Unzip and place file in the plugin folder of GetSimple. Then activate the plugin. 
Add this line of code to the template where you would like to display the contact form.
Or create a component and paste this code into it.

<?php if ( function_exists('GetMSC') ) { print GetMSC(); } ?> OR short code in the page: [#GetMSC#]

Standard PHP mail sending is enabled by default.
SMTP tested with @yandex.ru, @mail.ru, @gmail.com ...

The plugin can be translated into other languages. See /lang/en.php, ru.php ... 
Make your translation and upload the "xx.php" file to the directory - /lang/ - then select your language file in the plugin settings.
Do not use 'id', 'name' attribute for alternative fields.

Also see LICENSE.txt, README.txt
*/

// Get correct id for plugin
$m_smtp_c_thisfile = basename(__FILE__, '.php');

// Load configuration
require(GSROOTPATH.'plugins/'.$m_smtp_c_thisfile.'/cfg.php');

// Load language
require(GSROOTPATH.'plugins/'.$m_smtp_c_thisfile.'/lang/'.$m_smtp_c_language.'.php');

// Register plugin
register_plugin(
    $m_smtp_c_thisfile,    // ID of plugin, should be filename minus php
    $m_smtp_c_plugin_name,    // Title of plugin
    '1.1.2 (edit by multicolor)',    // Version of plugin
    'NetExplorer',    // Author of plugin
    'http://netexplorer.h1n.ru',    // Author URL
    $m_smtp_c_small_description,    // Plugin Description
    'plugins',    // Page type of plugin
    'm_smtp_c_options'    // Function that displays content
);

// Load plugin CSS correction for GS >= 3.4
if (@$_GET['id'] == 'my-smtp-contact' && round(floatval(GSVERSION), 2) >= '3.4') {
register_style('m_smtp_c_admin_style_correction', $SITEURL.'plugins/'.$m_smtp_c_thisfile.'/admin_correction.css', false, 'all');
queue_style('m_smtp_c_admin_style_correction', GSBACK);
}

// Load CSS default
if ($m_smtp_c_default_css == 'on') {
register_style('m_smtp_c_default_style', $SITEURL.'plugins/'.$m_smtp_c_thisfile.'/style.css', false, 'all');
queue_style('m_smtp_c_default_style', GSFRONT);
}

// Load CSS for notifications
register_style('m_smtp_c_notifications_style', $SITEURL.'plugins/'.$m_smtp_c_thisfile.'/notifications.css', false, 'all');
queue_style('m_smtp_c_notifications_style', GSFRONT);

// Creates a menu option on the Admin/Theme sidebar
add_action('plugins-sidebar', 'createSideMenu', array($m_smtp_c_thisfile, $m_smtp_c_plugin_name));

// activate filter
add_filter('content', 'ShortCodeGetMSC');

// Show options in plugin page
function m_smtp_c_options() {
	global $m_smtp_c_thisfile, $m_smtp_c_language;
	
	// Load language
	require(GSROOTPATH.'plugins/'.$m_smtp_c_thisfile.'/lang/'.$m_smtp_c_language.'.php');
	
	// Please do not remove the donation links
	echo $m_smtp_c_description . '
<b>'.$m_smtp_c_admin_donate.'</b><form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank" style="display: inline;">
<input type="hidden" name="cmd" value="_donations">
<input type="hidden" name="business" value="netexplorer@yandex.ru">
<input type="hidden" name="currency_code" value="USD">
<input type="submit" border="0" name="submit" class="button" value="PayPal">
</form> <button class="button" onclick="window.open(\'https://yoomoney.ru/to/410012986152433\')">YooMoney</button>
';

	// Load plugin settings
	require(GSROOTPATH.'plugins/'.$m_smtp_c_thisfile.'/admin.php');
}



//*** Get My SMTP Contact ***//
function GetMSC($my_msc_dir = 'no-forms') {
	global $m_smtp_c_thisfile, $my_smtp_c_msg_no_form, $SITEURL;
	
	if (!file_exists(GSROOTPATH.'plugins/'.$m_smtp_c_thisfile.'/forms/'.$my_msc_dir)) { 
		$return = '<p style="text-align: center;">'.$my_smtp_c_msg_no_form.'</p>';
		goto _end_GetMSC;
	}
	
	// Load configuration
	require(GSROOTPATH.'plugins/'.$m_smtp_c_thisfile.'/cfg.php');
	// Load contact form configuration
	require(GSROOTPATH.'plugins/'.$m_smtp_c_thisfile.'/forms/'.$my_msc_dir.'/cfg.php');
	// Load language
	require(GSROOTPATH.'plugins/'.$m_smtp_c_thisfile.'/lang/'.$m_smtp_c_language.'.php');
	
	if (!function_exists('m_smtp_c_StrToLower')) { function m_smtp_c_StrToLower($string) {
	return function_exists('mb_strtolower') ? mb_strtolower($string, 'UTF-8') : strtolower($string);
	}}
	
	if (!function_exists('m_smtp_c_StrLen')) { function m_smtp_c_StrLen($string) {
	return function_exists('mb_strlen') ? mb_strlen($string, 'UTF-8') : strlen(utf8_decode($string));
	}}
	
	if (!function_exists('m_smtp_c_SafeEmail')) { function m_smtp_c_SafeEmail($string) {
	$string = (string) $string;
	$string = str_replace(array('\n', '\r'), ' ', $string);
	$string = preg_replace('/\s+/', ' ', $string);
	$string = trim($string);
	return $string;
	}}

	if (!function_exists('m_smtp_c_GetFileFormat')) { function m_smtp_c_GetFileFormat($arr_names) {
	$tmp_arr = explode('.', $arr_names);
	$file_format = m_smtp_c_StrToLower(end($tmp_arr));
	return htmlspecialchars($file_format);	  
	}}

	if (!function_exists('m_smtp_c_Translit')) { function m_smtp_c_Translit($string) {
	$string = (string) $string; // convert to string value
	$string = strip_tags($string); // remove HTML tags
	$string = str_replace(array('\n', '\r'), ' ', $string); // remove the carriage return
	$string = preg_replace('/\s+/', ' ', $string); // remove duplicate spaces
	$string = trim($string); // remove spaces at the beginning and end of the line
	$string = m_smtp_c_StrToLower($string); // translate the string to lowercase (sometimes you need to set the locale)
	$string = strtr($string, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>''));
	$string = preg_replace('/[^0-9a-z-_ \.]/i', '', $string); // clear the string of invalid characters
	$count = substr_count($string, '.');
	$string = preg_replace('/\./', '', $string, --$count); // remove all points except the last one
	$string = str_replace(' ', '-', $string); // replace spaces with a minus sign
	return $string;
	}}


//*** FORM ***//
$return = '
<script>
   function m_smtp_c_setTagAttributes(selector, tag, tag_attribute, iflag)
	{
		
			if ( document.querySelectorAll(selector) ) 
			 {
			    var elements = document.querySelectorAll(selector);					
				for (var i = 0; i < elements.length; i++) 
					{
						if ( !elements[i].getAttribute(tag) ) // if no attribute
						 {	 
							 if (iflag) { elements[i].setAttribute(tag, tag_attribute + i); } else { elements[i].setAttribute(tag, tag_attribute); }
						 }
						 
						 if ( document.getElementById(tag_attribute + i) ) 
						  { 
							if ( document.querySelector("#" + tag_attribute + i + " + label") ) // if label
							 { 
							  element = document.querySelector("#" + tag_attribute + i + " + label");
							  if ( !element.getAttribute("for") )  
							   {
							    element.setAttribute("for", tag_attribute + i);
							   }
							 }
						  }			 
					}	
			 }	
			 
	}';

// Verify or no on client (alternative fields)
if ($m_smtp_c_alternative_fields == 'on' && $m_smtp_c_client_server == 'client_server') {
$return .= '
   function m_smtp_c_BeforeSubmit_'.$my_msc_dir.'() 
	{
		
	 function in_array(value, array) 
      {
       for(var i = 0; i < array.length; i++)
	    {
         if( value == array[i]) return true;
        }
      return false;
      }
		
	  var arr_fields_Name = '.json_encode($m_smtp_c_arr_fields_Name).';
	  var valid_file_format = '.json_encode($m_smtp_c_valid_file_format).';
	  var fields_Name_err_size = "", fields_Name_err_format = "";
	  var ext = "";
	  var error = 0, error_msg = "";
	  var arr_form_elements = document.querySelector("#m_smtp_c_form_'.$my_msc_dir.'").childNodes.length;
	  
	  for (var i = 0; i < arr_form_elements; i++) 
	   { 
	    if ( document.querySelector("#m_smtp_c_'.$my_msc_dir.' #m_smtp_c_qty_field_'.$my_msc_dir.'_"+i+" input") ) 
		 {
		  var input = document.querySelector("#m_smtp_c_'.$my_msc_dir.' #m_smtp_c_qty_field_'.$my_msc_dir.'_"+i+" input");
		  
		  if ( input.getAttribute("type") === "file" ) 
		   {
			if ( input.files[0] )
			 {
			  var file = input.files[0];
			  var parts = file.name.split("."); if (parts.length > 1) { ext = parts.pop().toLowerCase(); }
			  
			   // validation of the file size 
			   if (file.size > '.$m_smtp_c_limit_file_size.') 
			    {  
				 fields_Name_err_size = fields_Name_err_size + "<p class=\'m_smtp_c_field_error\'>" + arr_fields_Name[i] + "'.$m_smtp_c_Maxsize_error.'</p>";
				 error = 1;
				}
			 
			   // file format validation
			   if ( !in_array(ext, valid_file_format) )
			    {
				 fields_Name_err_format = fields_Name_err_format + "<p class=\'m_smtp_c_field_error\'>" + arr_fields_Name[i]+ "'.$m_smtp_c_Format_error.'</p>";
				 error = 1;
			    }
			 }
		   }
		   
		 }
	   }
	    
	  if (error == 1) 
	   { 
	    if (fields_Name_err_size) { error_msg = error_msg + fields_Name_err_size; }
	    if (fields_Name_err_format) { error_msg = error_msg + fields_Name_err_format; }
		
		'.($m_smtp_c_window_msg == 'on'
		? 'm_smtp_c_AlertModal("m_smtp_c_pale-red", "'.$m_smtp_c_Error_header.'", error_msg);'
		: 'm_smtp_c_AlertPage("#m_smtp_c_'.$my_msc_dir.'", error_msg);'
		).'
		
		return false;
	   }
	   
	 return true;
	}';
}

$return .= '
   function m_smtp_c_AlertModal(type_massage, header, message) 
    {   
	  if (document.querySelector(".m_smtp_c_container")) 
	   { 
		 document.querySelector(".m_smtp_c_container").remove(); 
	   }
	   
	  var msgModal = "<div class=\'m_smtp_c_container\'> <div id=\'msgModal\' class=\'m_smtp_c_modal\'> <div class=\'m_smtp_c_modal-content m_smtp_c_card-4\'> <div class=\'m_smtp_c_container "+type_massage+"\'> <span id=\'msgModal-spanClose\' class=\'m_smtp_c_button m_smtp_c_display-topright\'>&times;</span> <div class=\'h6\'>"+header+"</div> </div> <div class=\'m_smtp_c_container\'>" +message+ "</div> <div class=\'m_smtp_c_container "+type_massage+"\'> <span>&nbsp;</span> </div> </div> </div></div>";
	  document.body.insertAdjacentHTML(\'beforeend\', msgModal);
	  document.querySelector("#msgModal").setAttribute("onclick", "document.querySelector(\'#msgModal\').style.display=\'none\'");
	  document.querySelector("#msgModal-spanClose").setAttribute("onclick", "document.querySelector(\'#msgModal\').style.display=\'none\'");
		
	  document.querySelector("#msgModal").style.display="block";
    }
';

$return .= '
   function m_smtp_c_AlertPage(selector, message) 
	{
	  if (document.querySelector(".m_smtp_c_panel")) 
	   { 
		 document.querySelector(".m_smtp_c_panel").remove(); 
	   }
	   
	  var msgPage = "<div class=\'m_smtp_c_panel m_smtp_c_pale-red m_smtp_c_display-container\'><span id=\'msgPage-spanClose\' class=\'m_smtp_c_button m_smtp_c_display-topright\'>&times;</span><div class=\'h6\'>'.$m_smtp_c_Error_header.'</div>"+message+"</div>";
	  document.querySelector(selector).insertAdjacentHTML(\'afterend\', msgPage);
	  document.querySelector("#msgPage-spanClose").setAttribute("onclick", "this.parentElement.style.display=\'none\'");
	}
';

$return .= '
   function m_smtp_c_AfterSubmit_'.$my_msc_dir.'()
    {
		
	 function set_value(i, elements, values, cflag) 
	  {
		if ( elements[i] )
		 {
	      for (var key in values) 
		   { 
			if ( elements[i].getAttribute("name") === key )
			 {
	           if (!cflag) { elements[i].value = values[key]; }
			 }
			 
			 if ( elements[i].getAttribute("value") === values[key] )
			 { 
	           if (cflag) { elements[i].setAttribute("checked", ""); }
			 }
	       }
		 }
	  }
		
	 var arr_fields_value = '.json_encode($_POST).';
	 var arr_form_elements = document.querySelector("#m_smtp_c_form_'.$my_msc_dir.'").childNodes.length;
	 var arr_inputs = document.querySelectorAll("#m_smtp_c_'.$my_msc_dir.' input");
	 var arr_textareas = document.querySelectorAll("#m_smtp_c_'.$my_msc_dir.' textarea");
	 var arr_selects = document.querySelectorAll("#m_smtp_c_'.$my_msc_dir.' select");
	 for (var i = 0; i < arr_form_elements; i++) 
	  {
	   if (arr_inputs[i]) 
	   {
	    if (arr_inputs[i].getAttribute("type") != "file" &&
            arr_inputs[i].getAttribute("type") != "radio" &&
			arr_inputs[i].getAttribute("type") != "checkbox" &&
			arr_inputs[i].getAttribute("type") != "reset" &&
			arr_inputs[i].getAttribute("type") != "button" &&
			arr_inputs[i].getAttribute("type") != "submit" &&
			arr_inputs[i].getAttribute("type") != "hidden")
		 {  
		  set_value(i, arr_inputs, arr_fields_value);
		 }
		 
		if (arr_inputs[i].getAttribute("type") === "radio" || arr_inputs[i].getAttribute("type") === "checkbox") 
		 {
		  set_value(i, arr_inputs, arr_fields_value, true);
		 }
	   }
	   	   
	   set_value(i, arr_selects, arr_fields_value);
	     
	   set_value(i, arr_textareas, arr_fields_value);
	  }
	  
	 var captcha_code = document.querySelector("#my_captcha_code_input_'.$my_msc_dir.'");
	 if (captcha_code) { captcha_code.value = ""; }
	  
	}
</script>';
	
$return .= '
<div id="m_smtp_c_'.$my_msc_dir.'" class="m_smtp_c">';

// Form
if (in_array('file', $m_smtp_c_arr_fields_Type)) { 
$multipart_form_data = 'enctype="multipart/form-data"'; 
if ($m_smtp_c_alternative_fields == 'on' && $m_smtp_c_client_server == 'client_server') { $before_submit = 'm_smtp_c_BeforeSubmit_'.$my_msc_dir.'();'; } else { $before_submit = ''; } // verify or no on client (alternative fields)
$max_file_size = '<input type="hidden" name="max_file_size" value="'.$m_smtp_c_limit_file_size.'">';
} 
else { 
$multipart_form_data = '';
$before_submit = '';
$max_file_size = '';
}

if ($m_smtp_c_agree_checkbox == 'on') { // with checkbox
$return .= '
<form id="m_smtp_c_form_'.$my_msc_dir.'" class="m_smtp_c_form" name="m_smtp_c_form_'.$my_msc_dir.'" method="post" onsubmit="if (document.getElementById(\'m_smtp_c_agree_'.$my_msc_dir.'\').checked) { return '.$before_submit.' this.submit(); } else { '.($m_smtp_c_window_msg == 'on' ? 'm_smtp_c_AlertModal(\'m_smtp_c_pale-red\', \''.$m_smtp_c_Error_header.'\', \'<p class=\\\'m_smtp_c_field_error\\\'>'.$m_smtp_c_agree_error.'</p>\');' : 'm_smtp_c_AlertPage(\'#m_smtp_c_'.$my_msc_dir.'\', \'<p class=\\\'m_smtp_c_field_error\\\'>'.$m_smtp_c_agree_error.'</p>\');').' return false; }" '.$multipart_form_data.'>
'.$max_file_size.'';
}
else { // without checkbox
$return .= '
<form id="m_smtp_c_form_'.$my_msc_dir.'" class="m_smtp_c_form" name="m_smtp_c_form_'.$my_msc_dir.'" method="post" onsubmit="return '.$before_submit.' this.submit();" '.$multipart_form_data.'>
'.$max_file_size.'';
}

// Alternative fields
if ($m_smtp_c_alternative_fields == 'on') {
 for ($i = 0; $i < $m_smtp_c_qty_fields; $i++) :
  if (array_key_exists($i, $m_smtp_c_arr_fields_Name)) 
  {  
   if ($m_smtp_c_arr_fields_Name[$i] != '' && $m_smtp_c_arr_fields_Code[$i] != '') // if filled
   {
	$return .= '
	<p id="m_smtp_c_qty_field_'.$my_msc_dir.'_'.$i.'" class="m_smtp_c_qty_field">';
	if ($m_smtp_c_arr_fields_Name_ok[$i] == 'ok') {
	$return .=
	$m_smtp_c_arr_fields_Name[$i];
	}
	$return .=
	htmlspecialchars_decode($m_smtp_c_arr_fields_Code[$i]).'
	</p>';	
	}
   }
 endfor;
 
 $return .= '
 <script>
	m_smtp_c_setTagAttributes("#m_smtp_c_'.$my_msc_dir.' .m_smtp_c_qty_field input", "id", "m_smtp_c_qty_input_'.$my_msc_dir.'_", true);
	m_smtp_c_setTagAttributes("#m_smtp_c_'.$my_msc_dir.' .m_smtp_c_qty_field textarea", "id", "m_smtp_c_qty_textarea_'.$my_msc_dir.'_", true);
	m_smtp_c_setTagAttributes("#m_smtp_c_'.$my_msc_dir.' .m_smtp_c_qty_field select", "id", "m_smtp_c_qty_select_'.$my_msc_dir.'_", true);
	
	var arr_tags_Name = '.json_encode($m_smtp_c_arr_tags_Name).';
	var arr_fields_Required = '.json_encode($m_smtp_c_arr_fields_Required).';
	var arr_fields_Type = '.json_encode($m_smtp_c_arr_fields_Type).';
	var arr_fields_Maxlength = '.json_encode($m_smtp_c_arr_fields_Maxlength).';
	var client_server = "'.$m_smtp_c_client_server.'";
	for (var i = 0; i < '.$m_smtp_c_qty_fields.'; i++)
	 {
		m_smtp_c_setTagAttributes("#m_smtp_c_'.$my_msc_dir.' #m_smtp_c_qty_field_'.$my_msc_dir.'_"+i+" input", "name", "alt_field_"+arr_tags_Name[i], false);
		m_smtp_c_setTagAttributes("#m_smtp_c_'.$my_msc_dir.' #m_smtp_c_qty_field_'.$my_msc_dir.'_"+i+" textarea", "name", "alt_field_"+arr_tags_Name[i], false);
		m_smtp_c_setTagAttributes("#m_smtp_c_'.$my_msc_dir.' #m_smtp_c_qty_field_'.$my_msc_dir.'_"+i+" select", "name", "alt_field_"+arr_tags_Name[i], false);
		
		if (arr_fields_Type[i] != "---") 
		 {
		   m_smtp_c_setTagAttributes("#m_smtp_c_'.$my_msc_dir.' #m_smtp_c_qty_field_'.$my_msc_dir.'_"+i+" input", "type", arr_fields_Type[i], false);
		 }
		
		if (client_server === "client_server") // verify or no on client
		{
		 if (arr_fields_Maxlength[i] != "---") 
		 {
		   m_smtp_c_setTagAttributes("#m_smtp_c_'.$my_msc_dir.' #m_smtp_c_qty_field_'.$my_msc_dir.'_"+i+" input", "maxlength", arr_fields_Maxlength[i], false);
		   m_smtp_c_setTagAttributes("#m_smtp_c_'.$my_msc_dir.' #m_smtp_c_qty_field_'.$my_msc_dir.'_"+i+" textarea", "maxlength", arr_fields_Maxlength[i], false); 
		 }
			
		 if (arr_fields_Required[i] != "---") 
		 {
		   m_smtp_c_setTagAttributes("#m_smtp_c_'.$my_msc_dir.' #m_smtp_c_qty_field_'.$my_msc_dir.'_"+i+" input", "required", "", false);
		   m_smtp_c_setTagAttributes("#m_smtp_c_'.$my_msc_dir.' #m_smtp_c_qty_field_'.$my_msc_dir.'_"+i+" textarea", "required", "", false);		   
		 }
		}
		
		if (arr_fields_Type[i] === "checkbox") 
		 {
		  var checkbox_inputs = document.querySelectorAll("#m_smtp_c_'.$my_msc_dir.' #m_smtp_c_qty_field_'.$my_msc_dir.'_"+i+" input[type=\'checkbox\']"); 
          for (var j = 0; j < checkbox_inputs.length; j++) {
             if ( !checkbox_inputs[j].getAttribute("onclick") ) { checkbox_inputs[j].setAttribute("onclick", "m_smtp_c_forCheckbox_'.$my_msc_dir.'(this)"); }
		  }
		}
	 }

// checked only one (group checkboxes in one field)
function m_smtp_c_forCheckbox_'.$my_msc_dir.'(element) {
		  var checkbox_inputs = document.querySelectorAll("#m_smtp_c_'.$my_msc_dir.' input[type=\'checkbox\'][name=\'" + element.name + "\']");
          for (var i = 0; i < checkbox_inputs.length; i++) {
            if (checkbox_inputs[i]) { checkbox_inputs[i].onchange = checkboxHandler; }
		  }
          function checkboxHandler(e) {
            for (var j = 0; j < checkbox_inputs.length; j++) {
                if (checkbox_inputs[j].checked && checkbox_inputs[j] !== this) {
                    checkbox_inputs[j].checked = false;
				}
			}
          }
}
 </script>';
}

// Fields
else {
$return .= '
<p id="m_smtp_c_std_field_0" class="m_smtp_c_std_field">
'.$m_smtp_c_Name.'<br>
<input id="m_smtp_c_std_input_0" size="26" type="text" value="" name="m_smtp_c_name_value" '.($m_smtp_c_client_server == 'client_server' ? 'maxlength="200" required' : '').'>
</p>
<p id="m_smtp_c_std_field_1" class="m_smtp_c_std_field">
'.$m_smtp_c_Email.'<br>
<input id="m_smtp_c_std_input_1" size="26" type="'.($m_smtp_c_client_server == 'client_server' ? 'email' : 'text').'" value="" name="m_smtp_c_email_value" '.($m_smtp_c_client_server == 'client_server' ? 'maxlength="200" required' : '').'>
</p>
<p id="m_smtp_c_std_field_2" class="m_smtp_c_std_field">
'.$m_smtp_c_Message.'<br>
<textarea id="m_smtp_c_std_textarea_0" rows="5" cols="50" name="m_smtp_c_message_value" '.($m_smtp_c_client_server == 'client_server' ? 'maxlength="5000" required' : '').'></textarea>
</p>';
}

// Captcha
if ($m_smtp_c_digital_captcha == 'on') {
$return .= '
<p id="m_smtp_c_std_field_captcha" class="m_smtp_c_std_field">
<a href="#" onclick="document.getElementById(\'my_captcha_'.$my_msc_dir.'\').src = \''.$SITEURL.'plugins/'.$m_smtp_c_thisfile.'/captcha.php?my_msc_dir='.$my_msc_dir.'&rand=\' + Math.random(); document.getElementById(\'my_captcha_code_input_'.$my_msc_dir.'\').value = \'\'; return false;">
<img id="my_captcha_'.$my_msc_dir.'" src="'.$SITEURL.'plugins/'.$m_smtp_c_thisfile.'/captcha.php?my_msc_dir='.$my_msc_dir.'&rand='.m_smtp_c_Rand(0, 9999).'" alt="captcha"></a>
<br>
'.$m_smtp_c_Captcha.'
<br>
<input id="my_captcha_code_input_'.$my_msc_dir.'" class="my_captcha_code_input" type="text" name="m_smtp_c_captcha_name_'.$my_msc_dir.'" value="" size="6" maxlength="5" onkeyup="this.value = this.value.replace(/[^\d]+/g, \'\');" pattern="\d{5}" '.($m_smtp_c_client_server == 'client_server' ? 'required' : '').'>
</p>';
}

// Checkbox
if ($m_smtp_c_agree_checkbox == 'on') {
$return .= '
<p id="m_smtp_c_std_field_agree_'.$my_msc_dir.'" class="m_smtp_c_std_field">
<input id="m_smtp_c_agree_'.$my_msc_dir.'" style="vertical-align: middle;" type="checkbox" name="m_smtp_c_agree_'.$my_msc_dir.'" value="ok">
<label for="m_smtp_c_agree_'.$my_msc_dir.'">'.$m_smtp_c_agree.'</label>
</p>';
}

// Simple spam protect & submitted test
$return .= '
<p style="display:none!important;">
<input id="m_smtp_c_submitted_'.$my_msc_dir.'" type="hidden" value="true" name="m_smtp_c_submitted_'.$my_msc_dir.'">
<input id="m_smtp_c_sender_e-mail_'.$my_msc_dir.'" size="6" type="text" value="" name="m_smtp_c_sender_e-mail_'.$my_msc_dir.'" placeholder="do not fill" maxlength="200">
</p>';

// Submit button
$return .= '
<p class="m_smtp_c_Submit">
<input id="m_smtp_c_Submit_'.$my_msc_dir.'" type="submit" name="m_smtp_c_Submit_'.$my_msc_dir.'" value="'.$m_smtp_c_Submit.'">
</p>

</form>

</div>';


//*** MAIL ***//
	$error = 0;
    $m_smtp_c_success_msg = '';
	$j = 0;
	
    if (isset($_POST['m_smtp_c_submitted_'.$my_msc_dir.''])) {
			
		// Alternative fields
		if ($m_smtp_c_alternative_fields == 'on') {
			
		 $m_smtp_c_arr_fields_value = array(); 
		 		 	 	 
		 for ($i = 0; $i < $m_smtp_c_qty_fields; $i++) {
			 
		 if (array_key_exists($i, $m_smtp_c_arr_fields_Name)) 
         {
		  $m_smtp_c_arr_fields_value[$i] = htmlspecialchars(@$_POST['alt_field_'.$i]);
		  //$return .= "$i - $m_smtp_c_arr_fields_Name[$i] - $m_smtp_c_arr_fields_value[$i] <br>";
		  
		  // maxlength
		  if ($m_smtp_c_arr_fields_Maxlength[$i] != '---') { 
		   if ( m_smtp_c_StrLen($m_smtp_c_arr_fields_value[$i]) > intval($m_smtp_c_arr_fields_Maxlength[$i]) ) {
		    $m_smtp_c_success_msg .= '<p class="m_smtp_c_field_error"><span class="m_smtp_c_name_error">'.$m_smtp_c_arr_fields_Name[$i].'</span> '.$m_smtp_c_Maxlength_error.'<br></p>';
			$error = 1;
		   }
		  }
		 
		  // required without file
		  if ($m_smtp_c_arr_fields_Type[$i] != 'file' && $m_smtp_c_arr_fields_value[$i] == '') {
		   if ($m_smtp_c_arr_fields_Required[$i] == 'required' && $m_smtp_c_arr_fields_value[$i] == '') { 
			$m_smtp_c_success_msg .= '<p class="m_smtp_c_field_error"><span class="m_smtp_c_name_error">'.$m_smtp_c_arr_fields_Name[$i].'</span> '.$m_smtp_c_Required_error.'<br></p>';
            $error = 1;
		   }
		  }
		  
		  // email
		  if ($m_smtp_c_arr_fields_Type[$i] == 'email') {
		   if (!preg_match("/^[^@]+@[^@.]+\.[^@]+$/", $m_smtp_c_arr_fields_value[$i])) { 
            $m_smtp_c_success_msg .= '<p class="m_smtp_c_field_error"><span class="m_smtp_c_name_error">'.$m_smtp_c_arr_fields_Name[$i].'</span> '.$m_smtp_c_Email_error.'<br></p>';
            $error = 1;
           }
		  }
		  
		  // file
		  if ($m_smtp_c_arr_fields_Type[$i] == 'file') {
		   $m_smtp_c_S_FILES = array_values($_FILES);
		   
		    if ($m_smtp_c_S_FILES[$j]['name'] != '') {
			 if ($m_smtp_c_S_FILES[$j]['error'] != 0) {
			  $m_smtp_c_success_msg .= '<p class="m_smtp_c_field_error"><span class="m_smtp_c_name_error">'.$m_smtp_c_arr_fields_Name[$i].'</span> '.$m_smtp_c_Upload_error.' '.$m_smtp_c_S_FILES[$j]['error'].'.<br></p>';
              $error = 1;
             }
			 else {
			  // validation of the file size
			  if ($m_smtp_c_S_FILES[$j]['size'] > $m_smtp_c_limit_file_size) { 
			   $m_smtp_c_success_msg .= '<p class="m_smtp_c_field_error"><span class="m_smtp_c_name_error">'.$m_smtp_c_arr_fields_Name[$i].'</span> '.$m_smtp_c_Maxsize_error.'<br></p>';
			   $error = 1;
              }
			  // file format validation
			  $m_smtp_c_file_format = m_smtp_c_GetFileFormat($m_smtp_c_S_FILES[$j]['name']);
			  if (!in_array($m_smtp_c_file_format, $m_smtp_c_valid_file_format)) {
			   $m_smtp_c_success_msg .= '<p class="m_smtp_c_field_error"><span class="m_smtp_c_name_error">'.$m_smtp_c_arr_fields_Name[$i].'</span> '.$m_smtp_c_Format_error.'<br></p>';
			   $error = 1;
			  }
			 }
		    }
			// required with file
			elseif ($m_smtp_c_arr_fields_Required[$i] == 'required') { 
			  $m_smtp_c_success_msg .= '<p class="m_smtp_c_field_error"><span class="m_smtp_c_name_error">'.$m_smtp_c_arr_fields_Name[$i].'</span> '.$m_smtp_c_Required_error.'<br></p>';
              $error = 1;
			 }
		   $j++;
		  } 
		 
		 }
		 }

		} 
		
		// Fields
		else {
     	 $m_smtp_c_name_value = htmlspecialchars($_POST['m_smtp_c_name_value']);
         $m_smtp_c_email_value = htmlspecialchars($_POST['m_smtp_c_email_value']);
         $m_smtp_c_message_value = htmlspecialchars($_POST['m_smtp_c_message_value']);
		 
		 if ( m_smtp_c_StrLen($m_smtp_c_name_value) > 200 || m_smtp_c_StrLen($m_smtp_c_email_value) > 200 || m_smtp_c_StrLen($m_smtp_c_message_value) > 5000 ) {
		    $m_smtp_c_success_msg .= '<p class="m_smtp_c_field_error">'.$m_smtp_c_Maxlength_error.'<br></p>';
			$error = 1;
		 }
		
		 if (empty($m_smtp_c_name_value) || empty($m_smtp_c_email_value) || empty($m_smtp_c_message_value)) {
            $m_smtp_c_success_msg .= '<p class="m_smtp_c_field_error">'.$m_smtp_c_NameEmailMessage_error.'<br></p>';
            $error = 1;
         }
         if (!preg_match("/^[^@]+@[^@.]+\.[^@]+$/", $m_smtp_c_email_value)) {
            $m_smtp_c_success_msg .= '<p class="m_smtp_c_field_error">'.$m_smtp_c_Email_error.'<br></p>';
            $error = 1;
         }
		}

		// For all fields
		// captcha
		if ($m_smtp_c_digital_captcha == 'on') { 
		 if (md5($_POST['m_smtp_c_captcha_name_'.$my_msc_dir.''] . $m_smtp_c_digitSalt) != $_COOKIE['MSC_digit_'.$my_msc_dir.'']) {
            $m_smtp_c_success_msg .= '<p class="m_smtp_c_field_error">'.$m_smtp_c_Captcha_error.'<br></p>';
            $error = 1;  		
         }
		}
		
		// simple spam protect
		if ($_POST['m_smtp_c_sender_e-mail'] != '') { 
			$m_smtp_c_success_msg .= '<p class="m_smtp_c_field_error">'.$m_smtp_c_StopSpam_error.'<br></p>';
            $error = 1;
		}
		
        // If no erors
        if ($error != 1) {
			
			$m_smtp_c_success_msg = '<p class="m_smtp_c_field_success">'.$m_smtp_c_Success.'<br></p>';
			
			$site = htmlspecialchars($_SERVER['HTTP_HOST']);
			$ip = htmlspecialchars($_SERVER['REMOTE_ADDR']);
			$useragent = htmlspecialchars($_SERVER['HTTP_USER_AGENT']);
			$footer = '
				<hr>
				<p>
					<a href="//'.$site.'">'.$site.'</a><br>
					IP: '.$ip.'<br>
					'.$useragent.'
				</p>';
			
			// Alternative fields
			if ($m_smtp_c_alternative_fields == 'on') {
				  $message = '
				<h1>'.$m_smtp_c_subject.'</h1>
				<ul>';
				for ($i = 0; $i < $m_smtp_c_qty_fields; $i++) :
				if (array_key_exists($i, $m_smtp_c_arr_fields_Name)) { 
				 if ($m_smtp_c_on_off_substituting_email == 'checked' && $m_smtp_c_arr_fields_Type[$i] == 'email') { // Substituting the senders email in the "from" field (last field with type "email" will be "from")
				    $m_smtp_c_email_value = m_smtp_c_SafeEmail($m_smtp_c_arr_fields_value[$i]);
					$m_smtp_c_email_from_fake_for_smtp = $m_smtp_c_email_value;
					$m_smtp_c_standard_email_from = $m_smtp_c_email_value;
				 }
				 if ($m_smtp_c_arr_fields_Type[$i] != 'file' && $m_smtp_c_arr_fields_Type[$i] != 'button' && $m_smtp_c_arr_fields_Type[$i] != 'reset') {
				  $message .= '
					<li><b>'.$m_smtp_c_arr_fields_Name[$i].'</b> '.m_smtp_c_SafeEmail($m_smtp_c_arr_fields_value[$i]).'</li>';
				 }
				}
				endfor;
				  $message .= '
				</ul>';
				  $message .= $footer;
			}
			
			// Fields
			else {
				  $m_smtp_c_email_value = m_smtp_c_SafeEmail($m_smtp_c_email_value); // email
				  if ($m_smtp_c_on_off_substituting_email == 'checked') { // Substituting the senders email in the "from" field
					$m_smtp_c_email_from_fake_for_smtp = $m_smtp_c_email_value;
					$m_smtp_c_standard_email_from = $m_smtp_c_email_value;
				  }
				  $message = '
				<h1>'.$m_smtp_c_subject.'</h1>
				<ul>';
				  $message .= '
					<li><b>'.$m_smtp_c_Name.'</b> '.m_smtp_c_SafeEmail($m_smtp_c_name_value).'</li>
					<li><b>'.$m_smtp_c_Email.'</b> '.$m_smtp_c_email_value.'</li>
					<li><b>'.$m_smtp_c_Message.'</b> '.m_smtp_c_SafeEmail($m_smtp_c_message_value).'</li>';
				  $message .= '
				</ul>';
				  $message .= $footer;
			}
			
			if ($m_smtp_c_smtp_or_standard == 'smtp') { // SMTP
				require(GSROOTPATH.'plugins/'.$m_smtp_c_thisfile.'/SendMailSmtpClass.php');
				$mail = new SendMailSmtpClass($m_smtp_c_email_from, $m_smtp_c_email_from_password, $m_smtp_c_email_from_ssl, $m_smtp_c_email_from_port, "UTF-8");
				if ($m_smtp_c_on_off_substituting_email == 'checked') {
				$from = array($m_smtp_c_sender_name, $m_smtp_c_email_from_fake_for_smtp);
				}
				else {
				$from = array($m_smtp_c_sender_name, $m_smtp_c_email_from);
				}
				
				goto SEND;
			} 
			elseif ($m_smtp_c_smtp_or_standard == 'standard') { // standard php
				require(GSROOTPATH.'plugins/'.$m_smtp_c_thisfile.'/SendMailClass.php');
				$mail = new SendMailClass;
				$mail->from($m_smtp_c_standard_email_from, $m_smtp_c_sender_name);
				$mail->to($m_smtp_c_email_to, '');
				$mail->subject = $m_smtp_c_subject;
				
				goto SEND;
			}

			SEND:
			    if ($m_smtp_c_alternative_fields == 'on') { 
			    // Adding files to the letter and send
				if (in_array('file', $m_smtp_c_arr_fields_Type)) {
				for ($i = 0, $count_m_smtp_c_S_FILES = count($m_smtp_c_S_FILES); $i < $count_m_smtp_c_S_FILES; $i++) :
				 if ($m_smtp_c_S_FILES[$i]['tmp_name'] != '') { 
				  $m_smtp_c_file_format = m_smtp_c_GetFileFormat($m_smtp_c_S_FILES[$i]['name']);
				  //$uploadfile = tempnam(sys_get_temp_dir(), sha1($m_smtp_c_S_FILES[$i]['name']));  																	 			 // +
				  $uploadfile = GSROOTPATH.'plugins/'.$m_smtp_c_thisfile.'/tmp/'.md5(m_smtp_c_Rand(0, 9999).$m_smtp_c_S_FILES[$i]['name'].m_smtp_c_Rand(0, 9999)).'.'.$m_smtp_c_file_format; 	 // -
				  if (move_uploaded_file($m_smtp_c_S_FILES[$i]['tmp_name'], $uploadfile)) {
				   $mail->addFile($uploadfile, 'file-'.($i+1).'-'.m_smtp_c_Translit($m_smtp_c_S_FILES[$i]['name']));
				   if ( file_exists($uploadfile) ) { unlink($uploadfile); } 															 								 			 // -
			      } 
				  else { 
				   $m_smtp_c_success_msg .= '<p class="m_smtp_c_field_error">'.$m_smtp_c_Move_error.' '.htmlspecialchars($m_smtp_c_S_FILES[$i]['name']).'<br></p>';
				  }
				 }
				endfor;
				}
			    }
				
				if ($m_smtp_c_smtp_or_standard == 'smtp') { // SMTP
				$mail->send($m_smtp_c_email_to, $m_smtp_c_subject, $message, $from);
				}
				elseif ($m_smtp_c_smtp_or_standard == 'standard') { // standard php
				$mail->body = $message;
				$mail->send();
				}
			
			$_POST = array(); //$_FILES = array();
            $m_smtp_c_email_value = $m_smtp_c_name_value = $m_smtp_c_message_value = '';
        }
		else {
			  $return .= '<script> m_smtp_c_AfterSubmit_'.$my_msc_dir.'(); </script>';
		}
		
	 // Message
	 if ($m_smtp_c_window_msg == 'on') { // Plugin messages in modal window
	 $return .= '<script> /*window.onload = function() {*/ m_smtp_c_AlertModal(\''.($error == 0 ? 'm_smtp_c_pale-green' : 'm_smtp_c_pale-red').'\', \''.($error == 0 ? $m_smtp_c_Success_header : $m_smtp_c_Error_header).'\', \''.$m_smtp_c_success_msg.'\'); /*}*/ </script>';
	 }
	 if ($m_smtp_c_window_msg == 'off') { // Plugin messages on page
	 $return .= '<div class="m_smtp_c_panel '.($error == 0 ? 'm_smtp_c_pale-green' : 'm_smtp_c_pale-red').' m_smtp_c_display-container"><span onclick="this.parentElement.style.display=\'none\'" class="m_smtp_c_button msgPage-spanClose m_smtp_c_display-topright">&times;</span><div class="h6">'.($error == 0 ? $m_smtp_c_Success_header : $m_smtp_c_Error_header).'</div>'.$m_smtp_c_success_msg.'</div>';
	 }
	 
    }
	
_end_GetMSC:
	
return $return;	
}

// Search and replace
function ShortCodeGetMSC($content) {
 preg_match_all("|\[\#(.*)\#\]|U", $content, $matches);
 //print_r($matches);
 for($i = 0, $count = count($matches[1]); $i < $count; $i++) {
  $arr_tmp = explode(':', $matches[1][$i]);
  $my_msc_dir = $arr_tmp[1]; 
  if ($matches[1][$i] == "GetMSC:$my_msc_dir") {
	 $content = str_ireplace("[#GetMSC:$my_msc_dir#]", GetMSC($my_msc_dir), $content);
  }
 }

return $content;
}

?>