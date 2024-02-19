<?php
 
if(!defined('IN_GS')){ die('You cannot load this page directly.'); }

// 
// Plugin settings
//

// Directory deletion function
function my_smtp_c_rmRec($path) {
  if (is_file($path)) return unlink($path);
  if (is_dir($path)) {
    foreach(scandir($path) as $p) if (($p!='.') && ($p!='..'))
      my_smtp_c_rmRec($path.DIRECTORY_SEPARATOR.$p);
    return rmdir($path); 
    }
  return false;
}

// dirname with levels as in php7 for php5
function m_smtp_c_Dirname($path, $levels = 1) 
 {
	$arr = explode(DIRECTORY_SEPARATOR, dirname((string) $path));
	array_splice($arr, count($arr) + 1 - $levels);
	return implode(DIRECTORY_SEPARATOR, $arr);
 }
	$MSCDIR = m_smtp_c_Dirname(__FILE__, 2); // Similar to dirname in php7 (can try constant GSROOTPATH)
 
$thisfilew = GSDATAOTHERPATH .'website.xml';
if (file_exists($thisfilew)) 
 {
	$dataw = getXML($thisfilew);
	$MSCURL = $dataw->SITEURL;
	//$MSCURL = rtrim($dataw->SITEURL, '/') . '/';
 } else {
	$MSCURL = '/';
 } 

require($MSCDIR.'/'.$m_smtp_c_thisfile.'/cfg.php');
require($MSCDIR.'/'.$m_smtp_c_thisfile.'/active_cfg.php');
if ($my_smtp_c_selected_dir != 'no-forms') {
require($MSCDIR.'/'.$m_smtp_c_thisfile.'/forms/'.$my_smtp_c_selected_dir.'/cfg.php');
}

$my_smtp_c_forms_arr = file($MSCDIR.'/'.$m_smtp_c_thisfile.'/forms/ids-names.dat');
$my_smtp_c_forms_ids = [];
$my_smtp_c_forms_names = [];

if (!file_exists($MSCDIR.'/'.$m_smtp_c_thisfile.'/forms/'.$my_smtp_c_selected_dir)) { $my_smtp_c_selected_dir = 'no-forms'; $my_smtp_c_selected_name = $my_smtp_c_admin_no_аctive_form; $my_smtp_c_forms_arr[] = 'no-forms|'.$my_smtp_c_admin_no_аctive_form.''; }

for ($i = 0, $mg_count_arr = is_countable($my_smtp_c_forms_arr) ? count($my_smtp_c_forms_arr) : 0; $i < $mg_count_arr; $i++) {
	$my_smtp_c_forms_tmp = explode('|', $my_smtp_c_forms_arr[$i]);	 
	$my_smtp_c_forms_ids[] = trim($my_smtp_c_forms_tmp[0]);
	$my_smtp_c_forms_names[] = trim($my_smtp_c_forms_tmp[1]);
}

$act = @$_POST['act'];

if ($act) { echo '<div class="updated" style="display: block; margin-top: 20px;"><p>'.$m_smtp_c_admin_updating_settings.'</p></div>'; }

echo '
<script>
function m_smtp_c_random(n)
{
	var r = \'\';
	var arr = \'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789\';
	var al = arr.length
	for( var i=0; i < n; i++ ){
		r += arr[Math.floor(Math.random() * al)];
	}
	return r;
}

function my_smtp_c_CSSLoad(file){
	var link = document.createElement("link");
	link.setAttribute("rel", "stylesheet");
	link.setAttribute("type", "text/css");
	link.setAttribute("href", file);
	document.getElementsByTagName("head")[0].appendChild(link);
}

function my_smtp_c_JSLoad(file){
	var link = document.createElement("script");
	link.setAttribute("type", "text/javascript");
	link.setAttribute("src", file);
	document.getElementsByTagName("head")[0].appendChild(link);
}
</script>';

print <<< my_smtp_c_JS_code
<script>
var m_smtp_c_thisfile = "$m_smtp_c_thisfile";
var MSCURL = "$MSCURL";

var my_smtp_c_New = '<form name="my_smtp_c_New" action="load.php?id='+m_smtp_c_thisfile+'" method="post" enctype="multipart/form-data">'+
    '<input type="hidden" name="act" value="my_smtp_c_New">'+
	'<div class="a"><label>$my_smtp_c_admin_name</label>'+
	'<input class="text" style="width: 288px;" type="text" name="my_smtp_c_new_name" value="" required></div>'+	
	'<div class="b"><button type="submit">$my_smtp_c_btn_create</button>&nbsp;<button type="button" onclick="closewindow(\'window\');\">$my_smtp_c_btn_cancel</button>'+	
	'</div></form>';
	
var my_smtp_c_Delete = '<form name="my_smtp_c_Delete" action="load.php?id='+m_smtp_c_thisfile+'" method="post" enctype="multipart/form-data">'+
    '<input type="hidden" name="act" value="my_smtp_c_Delete">'+
	'<div class="a"><label>$my_smtp_c_admin_delete_form_confirm</label></div>'+
	'<div class="b"><button type="submit">$my_smtp_c_btn_delete</button>&nbsp;<button type="button" onclick="closewindow(\'window\');\">$my_smtp_c_btn_cancel</button>'+	
	'</div></form>';
	
var my_smtp_c_Rename = '<form name="my_smtp_c_Rename" action="load.php?id='+m_smtp_c_thisfile+'" method="post" enctype="multipart/form-data">'+
    '<input type="hidden" name="act" value="my_smtp_c_Rename">'+
	'<div class="a"><label>$my_smtp_c_admin_name</label>'+
	'<input class="text" type="hidden" name="my_smtp_c_old_id" value="">'+
	'<input class="text" type="hidden" name="my_smtp_c_old_name" value="">'+
	'<input class="text" style="width: 288px;" type="text" name="my_smtp_c_new_name" value="" required></div>'+
	'<div class="b"><button type="submit">$my_smtp_c_btn_rename</button>&nbsp;<button type="button" onclick="closewindow(\'window\');\">$my_smtp_c_btn_cancel</button>'+
	'</div></form>';
</script>


my_smtp_c_JS_code;


function m_smtp_c_Select($label, $name, $value, $key, $ch1, $tr1, $ch2, $tr2) {
			echo '
			<label>'.$label.'</label>
			<p>
			<select class="text" name="'.$name.'">';
				if($value == $key){
					echo '<option value="'.$ch1.'" selected>'.$tr1.'';
					echo '<option value="'.$ch2.'">'.$tr2.'';
				} 
				else {
					echo'<option value="'.$ch2.'" selected>'.$tr2.'';
					echo'<option value="'.$ch1.'">'.$tr1.'';
				}
			echo '
			</select>
			</p>';
}

function m_smtp_c_alt_fields_Select($m_smtp_c_qty_fields, $themes_ch, $i, $themes_name, $themes_option, $themes_arr) { 

			$tmp_themes_arr = '';
			if (!array_key_exists($m_smtp_c_qty_fields, $themes_ch)) { $themes_ch[] = ''; }
			for ( $l = 0, $count_themes_arr = is_countable($themes_arr) ? count($themes_arr) : 0; $l < $count_themes_arr; $l++ )
			{ 
			  if ($themes_arr[$l] == @$themes_ch[$i]) 
			  { 
			    $tmp_themes_arr = $themes_arr[$l]; 
                unset($themes_arr[$l]); 
			  }
			}
			if ($tmp_themes_arr != '') 
			{
			  array_unshift($themes_arr, $tmp_themes_arr); 
			}
		    echo '
		    <select class="text" style="max-width: 75px;" name="'.$themes_name.'[]">
			<option disabled>'.$themes_option.'</option>';
            foreach ($themes_arr as $key => $value) 
			{
               echo '<option value='.$themes_arr[$key].'>'.$value.'</option>'; 
            }
		    echo '
            </select>';
			
	return $themes_ch;
}

echo '
	<div class="error_place"></div>
	<p><hr style="height: 1px; border: none; color: #dddddd; background: #dddddd; margin: 0 0 20px 0;"></p>
	<form class="largeform" id="m_smtp_c_settingsform" name="m_smtp_c_settingsform" action="load.php?id='.$m_smtp_c_thisfile.'" method="post" accept-charset="utf-8">
	
		<INPUT TYPE="hidden" NAME="act" VALUE="addsettings">
		<input id="nonce" name="nonce" type="hidden" value="'.get_nonce('save_mysmtpcontact').'">
		
		<h3>'.$m_smtp_c_admin_plugin_settings.'</h3>		
		<div class="leftsec">';
			echo '
		    <p>
			<label>'.$m_smtp_c_admin_language_file.'</label>';
			$m_smtp_c_array_languages = scandir($MSCDIR.'/'.$m_smtp_c_thisfile.'/lang/'); // scan the directory, get an array
			for ( $i = 0; $i < (is_countable($m_smtp_c_array_languages) ? count($m_smtp_c_array_languages) : 0); $i++ )
			{
			  if ($m_smtp_c_array_languages[$i] == $m_smtp_c_language.'.php') // if matches
			  {
			    $m_smtp_c_tmp_language = $m_smtp_c_array_languages[$i]; // write to variable
                unset($m_smtp_c_array_languages[$i]); // remove from array
			  }
			}
			array_unshift($m_smtp_c_array_languages, $m_smtp_c_tmp_language); // add the first element to the array
			
		    echo '
		    <select class="text" name="m_smtp_c_language">';
            foreach ($m_smtp_c_array_languages as $key => $value) 
			{
			  if (strripos((string) $m_smtp_c_array_languages[$key], '.php') !== false)
			  { 
                echo '<option value="'.$m_smtp_c_array_languages[$key].'">'.$value.'</option>'; // output (the first element)
			  }
            }
		    echo '
            </select>
			</p>';
			
			echo '		
			<p><label>'.$m_smtp_c_admin_email_to.'</label><input class="text" name="m_smtp_c_email_to" type="text" value="'.$m_smtp_c_email_to.'"></p>';
		    
			m_smtp_c_Select($m_smtp_c_admin_standard_or_smtp, 'm_smtp_c_smtp_or_standard', $m_smtp_c_smtp_or_standard, 'standard', 'standard', $m_smtp_c_admin_standard, 'smtp', $m_smtp_c_admin_smtp);
			
			
			echo '
			<h3>Google captcha (required from https://www.google.com/recaptcha/admin/create)</h3>
			<label>Google captcha domain key</label>	
			<input type="text" style="width:95%;padding:5px;" value="'.$m_smtp_c_domainkeygoogle.'" name="domainkeygoogle">
			<br><br>
			<label>Google captcha secret key</label>	
			<input type="text" style="width:95%;padding:5px;" value="'.$m_smtp_c_secretkeygoogle.'" name="secretkeygoogle">
			
			<br><br>';
			
			;
			

			m_smtp_c_Select($m_smtp_c_admin_agree_checkbox, 'm_smtp_c_agree_checkbox', $m_smtp_c_agree_checkbox, 'on', 'on', $m_smtp_c_admin_select_on, 'off', $m_smtp_c_admin_select_off);			

			m_smtp_c_Select($m_smtp_c_admin_verification, 'm_smtp_c_client_server', $m_smtp_c_client_server, 'client_server', 'client_server', $m_smtp_c_admin_verification_client_server, 'server', $m_smtp_c_admin_verification_server);
			
			m_smtp_c_Select($m_smtp_c_admin_window_msg, 'm_smtp_c_window_msg', $m_smtp_c_window_msg, 'on', 'on', $m_smtp_c_admin_modal_on, 'off', $m_smtp_c_admin_modal_off);
			
			m_smtp_c_Select($m_smtp_c_admin_default_css, 'm_smtp_c_default_css', $m_smtp_c_default_css, 'on', 'on', $m_smtp_c_admin_select_on, 'off', $m_smtp_c_admin_select_off);

		echo '
		</div>';
		
		echo '
		<div class="rightsec">';
		
		echo '
            <p><label>'.$m_smtp_c_admin_verification_sender_name.'</label>
			<input class="text" name="m_smtp_c_sender_name" type="text" value="'.$m_smtp_c_sender_name.'">
			</p>
			<p><label>'.$m_smtp_c_admin_verification_subject.'</label>
			<input class="text" name="m_smtp_c_subject" type="text" value="'.$m_smtp_c_subject.'">
			</p>
			<p id="email-smtp"><label>'.$m_smtp_c_admin_smtp.'</label>
			'.$m_smtp_c_admin_email_from.'<input class="text" id="m_smtp_c_email_from" name="m_smtp_c_email_from" type="text" value="'.$m_smtp_c_email_from.'">
			'.$m_smtp_c_admin_email_from_password.'<input class="text" name="m_smtp_c_email_from_password" type="text" value="'.$m_smtp_c_email_from_password.'">
			'.$m_smtp_c_admin_email_from_ssl.'<input class="text" name="m_smtp_c_email_from_ssl" type="text" value="'.$m_smtp_c_email_from_ssl.'">
			'.$m_smtp_c_admin_email_from_port.'<input class="text" name="m_smtp_c_email_from_port" type="text" value="'.$m_smtp_c_email_from_port.'">
			</p>
			<p id="email-standard"><label>'.$m_smtp_c_admin_standard.'</label>
			'.$m_smtp_c_admin_email_from.'<input id="m_smtp_c_standard_email_from" class="text" name="m_smtp_c_standard_email_from" type="text" value="'.$m_smtp_c_standard_email_from.'">
			</p>
			<p class="inline clearfix">
			<input type="checkbox" id="substituting-email-enable" name="m_smtp_c_on_off_substituting_email" value="checked" '.$m_smtp_c_on_off_substituting_email.'>&nbsp;&nbsp;&nbsp;
			<label for="substituting-email-enable">'.$m_smtp_c_admin_on_off_substituting_email.'</label><br>
			<span style="margin: 0px 0 5px 0; font-size: 12px; color: #999;">'.$m_smtp_c_admin_on_off_substituting_email_comment.'</span>
			</p>
			<script>
			function m_smtp_c_checked(){
			 document.getElementById("m_smtp_c_email_from").style.opacity = (document.getElementById("substituting-email-enable").checked)?"0.7":"";
			 document.getElementById("m_smtp_c_standard_email_from").style.opacity = (document.getElementById("substituting-email-enable").checked)?"0.7":"";
			}
			document.getElementById("substituting-email-enable").onclick  = function(){
			 m_smtp_c_checked();
			}
			m_smtp_c_checked();
			
			function m_smtp_c_selected(select) {
             var selectedOption = select.options[select.selectedIndex];
			 if (selectedOption.value == "standard") {  
			  document.querySelector("#email-standard label").style.opacity = "1";
			  document.querySelector("#email-smtp label").style.opacity = "0.7"; 
			 }
			 if (selectedOption.value == "smtp") {  
			  document.querySelector("#email-smtp label").style.opacity = "1";
			  document.querySelector("#email-standard label").style.opacity = "0.7";
			 }
			}
			document.querySelector("select[name=m_smtp_c_smtp_or_standard]").onchange = function() {
			 m_smtp_c_selected(document.querySelector("select[name=m_smtp_c_smtp_or_standard]"));
			}
			m_smtp_c_selected(document.querySelector("select[name=m_smtp_c_smtp_or_standard]"));
			</script>
			';			
			
		echo '
		</div>';
		
		echo '
		<div class="clear"></div>';
		
		echo '
		<hr style="height: 1px; border: none; color: #dddddd; background: #dddddd; margin: 0 0 20px 0;">';
		
		
		
		echo '
		<h3>'.$my_smtp_c_admin_actions_forms.'</h3>
		<div class="leftsec">
		    <p>
			<label>'.$my_smtp_c_admin_аctive_form.'</label>';
			for ( $i = 0; $i < count($my_smtp_c_forms_ids); $i++ )
			{
			  if ($my_smtp_c_forms_ids[$i] == $my_smtp_c_selected_dir) // if matches
			  {
			    $my_smtp_c_tmp_selected_dir = $my_smtp_c_forms_ids[$i]; // write to variable
				$my_smtp_c_tmp_selected_name = $my_smtp_c_forms_names[$i]; 
                unset($my_smtp_c_forms_ids[$i]); // remove from array
				unset($my_smtp_c_forms_names[$i]); 
			  }
			}
			array_unshift($my_smtp_c_forms_ids, $my_smtp_c_tmp_selected_dir); // add the first element to the array
			array_unshift($my_smtp_c_forms_names, $my_smtp_c_tmp_selected_name); 
			
		    echo '
		    <select class="text" name="my_smtp_c_selected_dir" onchange="document.querySelector(\'input[name=my_smtp_c_selected_name]\').value = this.options[selectedIndex].text; this.form.submit();">';
		
            for ( $i = 0; $i < count($my_smtp_c_forms_ids); $i++ )
			{   
                echo '<option value="'.$my_smtp_c_forms_ids[$i].'">'.$my_smtp_c_forms_names[$i].'</option>'; // output (the first element)
            }
		    echo '
            </select>
			<input type="hidden" name="my_smtp_c_selected_name" value="'.$my_smtp_c_forms_names[0].'">
			</p>
		</div>';

		echo '
		<div class="rightsec" style="padding-top: 19px;">
		<p class="edit-nav">
		<a href="javascript:void(0);" onclick="openwindow(\'window\', 360, \'auto\', my_smtp_c_Delete);">'.$my_smtp_c_btn_delete.'</a>
		<a href="javascript:void(0);" onclick="openwindow(\'window\', 360, \'auto\', my_smtp_c_Rename);
				document.querySelector(\'input[name=my_smtp_c_old_id]\').value = document.querySelector(\'select[name=my_smtp_c_selected_dir]\').options[0].value;
				document.querySelector(\'input[name=my_smtp_c_old_name]\').value = document.querySelector(\'select[name=my_smtp_c_selected_dir]\').options[0].text;
				document.querySelector(\'input[name=my_smtp_c_new_name]\').value = document.querySelector(\'select[name=my_smtp_c_selected_dir]\').options[0].text;
				">'.$my_smtp_c_btn_rename.'</a>
		<a href="javascript:void(0);" onclick="openwindow(\'window\', 360, \'auto\', my_smtp_c_New);">'.$my_smtp_c_btn_create.'</a>
		</p>
		</div>
		
		<div class="clear"></div>
		<pre id="my_smtp_c_short_code"><p style="margin:0;font-size:12px;color:#000;font-weight:bold;">'.($my_smtp_c_selected_dir != 'no-forms' ? '<span style="font-weight:normal;">'.$my_smtp_c_admin_short_code.' </span>[#GetMSC:'.$my_smtp_c_selected_dir.'#]<span style="font-weight:normal;"><br>'.$my_smtp_c_admin_php_code.' </span>&lt;?php if (function_exists(\'GetMSC\')) { print GetMSC(\''.$my_smtp_c_selected_dir.'\'); } ?&gt;' : '').'</p></pre>
		<hr style="height: 1px; border: none; color: #dddddd; background: #dddddd; margin: 0 0 20px 0;">';


		
		if ($my_smtp_c_selected_dir != 'no-forms') {
		echo '
		<div class="leftsec">';
			m_smtp_c_Select($m_smtp_c_admin_alternative_fields, 'm_smtp_c_alternative_fields', $m_smtp_c_alternative_fields, 'on', 'on', $m_smtp_c_admin_select_on, 'off', $m_smtp_c_admin_select_off);
		echo '
		</div>';	
			
		echo '
		<div class="edit-nav">
			<a href="#" id="metadata_toggle" accesskey="">'.$m_smtp_c_admin_properties.'</a>
			<div class="clear"></div>
		</div>	
			<!-- metadata toggle screen -->
			<div style="display: none;" id="metadata_window">
			  <div>
				<p class="inline clearfix">';
				 echo '<p>'.$m_smtp_c_admin_qty_fields.' <input class="text" type="number" name="m_smtp_c_qty_fields" value="'.$m_smtp_c_qty_fields.'" style="max-width:53px;" pattern="^\d+$" required min="1" max="1000"> 
					      <button class="button" style="float: right;" type="submit">'.$m_smtp_c_admin_submit.'</button>
					   </p>
					   <p>'.$m_smtp_c_admin_limit_file_size.' <input class="text" type="number" name="m_smtp_c_limit_file_size" value="'.($m_smtp_c_limit_file_size / 1024 / 1024).'" style="max-width:53px;" pattern="^\d+$" required min="1" max="25">
					      '.$m_smtp_c_admin_valid_file_format.' <input class="text" type="text" name="m_smtp_c_valid_file_format" value="'.implode(',', $m_smtp_c_valid_file_format).'" style="max-width:237px;" required>
					   </p>';
				 
				 for ($i = 0; $i < $m_smtp_c_qty_fields; $i++) :
				  if ( empty($m_smtp_c_arr_tags_Name[$i]) ) { $m_smtp_c_arr_tags_Name[$i] = $i; }
					echo ($i+1).' <input placeholder="'.$m_smtp_c_admin_designation.'" class="text" type="text" name="m_smtp_c_arr_fields_Name[]" value="'.@$m_smtp_c_arr_fields_Name[$i].'" style="max-width: 100px;">';
			
					$m_smtp_c_arr_fields_Name_ok = m_smtp_c_alt_fields_Select($m_smtp_c_qty_fields, $m_smtp_c_arr_fields_Name_ok, $i, 'm_smtp_c_arr_fields_Name_ok', $m_smtp_c_admin_yes_or_no_designation, ['ok', '---']);
					
					echo ' <input placeholder="tag \'name\'" class="text" type="hidden" name="m_smtp_c_arr_tags_Name[]" value="'.$m_smtp_c_arr_tags_Name[$i].'" style="max-width: 53px;" pattern="^\d+$">';
					
					$m_smtp_c_arr_fields_Required = m_smtp_c_alt_fields_Select($m_smtp_c_qty_fields, $m_smtp_c_arr_fields_Required, $i, 'm_smtp_c_arr_fields_Required', $m_smtp_c_admin_yes_or_no_required, ['---', 'required']);
					
					$m_smtp_c_arr_fields_Type = m_smtp_c_alt_fields_Select($m_smtp_c_qty_fields, $m_smtp_c_arr_fields_Type, $i, 'm_smtp_c_arr_fields_Type', $m_smtp_c_admin_field_type, [
         '---',
         'button',
         'checkbox',
         'color',
         'date',
         'datetime-local',
         'email',
         'file',
         'hidden',
         'image',
         'month',
         'number',
         'password',
         'radio',
         'range',
         /*'reset',*/
         'search',
         /*'submit',*/
         'tel',
         'text',
         'time',
         'url',
         'week',
     ]);
					
					$m_smtp_c_arr_fields_Maxlength = m_smtp_c_alt_fields_Select($m_smtp_c_qty_fields, $m_smtp_c_arr_fields_Maxlength, $i, 'm_smtp_c_arr_fields_Maxlength', $m_smtp_c_admin_Maxlength, ['---', '5', '10', '25', '50', '100', '200', '300', '500', '1000', '3000', '5000', '10000', '50000', '100000']);
						
					echo '
					<textarea placeholder="'.$m_smtp_c_admin_Code.'" class="text short" type="text" name="m_smtp_c_arr_fields_Code[]" style="margin-top: 2px!important;">'.@$m_smtp_c_arr_fields_Code[$i].'</textarea>
					<p> </p>';
				 endfor;
				 
				echo '
				</p>
			  </div>
			</div>';
		}
		
		echo '
		<div class="clear"></div>
		<p id="submit_line"><span><input class="submit" type="submit" name="" value="'.$m_smtp_c_admin_submit.'"></span> &nbsp;&nbsp;'.$m_smtp_c_admin_or.'&nbsp;&nbsp; <a class="cancel" href="plugins.php">'.$m_smtp_c_admin_backward.'</a></p>
		
	</form>
';

if ($act == 'addsettings') { 

	// check for csrf
	if (!defined('GSNOCSRF') || (GSNOCSRF == FALSE) ) {
		$nonce = $_POST['nonce'];
		if(!check_nonce($nonce, 'save_mysmtpcontact')) {
			echo '<script> if (document.querySelector(\'.error_place\')) { document.querySelector(\'.error_place\').innerHTML = \'<div class="error" style="display: block;"><p>'.$my_smtp_c_admin_error_csrf.'</p></div>\'; } </script>';
			goto _end_addsettings;
		}
	}

if ($my_smtp_c_selected_dir != 'no-forms') {
$m_smtp_c_arr_fields_Name = $_POST['m_smtp_c_arr_fields_Name']; // array - Names
$m_smtp_c_arr_tags_Name = $_POST['m_smtp_c_arr_tags_Name']; // array - Tag Names
$m_smtp_c_arr_fields_Name_ok = $_POST['m_smtp_c_arr_fields_Name_ok']; // array - ok
$m_smtp_c_arr_fields_Required = $_POST['m_smtp_c_arr_fields_Required']; // array - required
$m_smtp_c_arr_fields_Type = $_POST['m_smtp_c_arr_fields_Type']; // array - email
$m_smtp_c_arr_fields_Maxlength = $_POST['m_smtp_c_arr_fields_Maxlength']; // array - maxlength
$m_smtp_c_arr_fields_Code = $_POST['m_smtp_c_arr_fields_Code']; // array - Codes
file_put_contents( $MSCDIR.'/'.$m_smtp_c_thisfile.'/forms/'.$my_smtp_c_selected_dir.'/cfg.php', '<?php
$m_smtp_c_alternative_fields="'.htmlspecialchars((string) $_POST['m_smtp_c_alternative_fields']).'";
$m_smtp_c_qty_fields="'.intval($_POST['m_smtp_c_qty_fields']).'";
$m_smtp_c_limit_file_size="'.(intval($_POST['m_smtp_c_limit_file_size']) * 1024 * 1024).'";
$m_smtp_c_valid_file_format=array("'.str_replace([' ', ','], ['', '","'], mb_strtolower(htmlspecialchars(trim((string) $_POST['m_smtp_c_valid_file_format'], ',')))).'");
'); 
	for ($i = 0; $i < $m_smtp_c_qty_fields; $i++) :
	 if ($m_smtp_c_arr_fields_Name[$i] != '' && $m_smtp_c_arr_fields_Code[$i] != '') // if filled
	 {
	  file_put_contents($MSCDIR.'/'.$m_smtp_c_thisfile.'/forms/'.$my_smtp_c_selected_dir.'/cfg.php', '$m_smtp_c_arr_fields_Name['.$i.']="'.htmlspecialchars((string) $m_smtp_c_arr_fields_Name[$i]).'";', FILE_APPEND);
	  file_put_contents($MSCDIR.'/'.$m_smtp_c_thisfile.'/forms/'.$my_smtp_c_selected_dir.'/cfg.php', '$m_smtp_c_arr_tags_Name['.$i.']="'.intval($m_smtp_c_arr_tags_Name[$i]).'";', FILE_APPEND);	  
	  file_put_contents($MSCDIR.'/'.$m_smtp_c_thisfile.'/forms/'.$my_smtp_c_selected_dir.'/cfg.php', '$m_smtp_c_arr_fields_Name_ok['.$i.']="'.htmlspecialchars((string) $m_smtp_c_arr_fields_Name_ok[$i]).'";', FILE_APPEND);	  
	  file_put_contents($MSCDIR.'/'.$m_smtp_c_thisfile.'/forms/'.$my_smtp_c_selected_dir.'/cfg.php', '$m_smtp_c_arr_fields_Required['.$i.']="'.htmlspecialchars((string) $m_smtp_c_arr_fields_Required[$i]).'";', FILE_APPEND);
	  file_put_contents($MSCDIR.'/'.$m_smtp_c_thisfile.'/forms/'.$my_smtp_c_selected_dir.'/cfg.php', '$m_smtp_c_arr_fields_Type['.$i.']="'.htmlspecialchars((string) $m_smtp_c_arr_fields_Type[$i]).'";', FILE_APPEND);
	  file_put_contents($MSCDIR.'/'.$m_smtp_c_thisfile.'/forms/'.$my_smtp_c_selected_dir.'/cfg.php', '$m_smtp_c_arr_fields_Maxlength['.$i.']="'.htmlspecialchars((string) $m_smtp_c_arr_fields_Maxlength[$i]).'";', FILE_APPEND);
	  file_put_contents($MSCDIR.'/'.$m_smtp_c_thisfile.'/forms/'.$my_smtp_c_selected_dir.'/cfg.php', '$m_smtp_c_arr_fields_Code['.$i.']="'.htmlspecialchars((string) $m_smtp_c_arr_fields_Code[$i]).'";', FILE_APPEND);
	 }
	endfor;
file_put_contents( $MSCDIR.'/'.$m_smtp_c_thisfile.'/forms/'.$my_smtp_c_selected_dir.'/cfg.php', 
'?>', FILE_APPEND);
}

file_put_contents( $MSCDIR.'/'.$m_smtp_c_thisfile.'/cfg.php', '<?php
if (!function_exists("m_smtp_c_Rand")) { function m_smtp_c_Rand($begin, $end) { return function_exists("mt_rand") ? mt_rand($begin, $end) : rand($begin, $end); } } 
$m_smtp_c_language="'.str_replace('.php', '', htmlspecialchars((string) $_POST['m_smtp_c_language'])).'";
$m_smtp_c_email_to="'.str_replace(' ', '', htmlspecialchars(trim((string) $_POST['m_smtp_c_email_to'], ','))).'";
$m_smtp_c_smtp_or_standard="'.htmlspecialchars((string) $_POST['m_smtp_c_smtp_or_standard']).'";
$m_smtp_c_sender_name="'.htmlspecialchars(trim((string) $_POST['m_smtp_c_sender_name'])).'";
$m_smtp_c_subject="'.htmlspecialchars(trim((string) $_POST['m_smtp_c_subject'])).'";
$m_smtp_c_email_from="'.htmlspecialchars(trim((string) $_POST['m_smtp_c_email_from'])).'";
$m_smtp_c_email_from_password="'.htmlspecialchars(trim((string) $_POST['m_smtp_c_email_from_password'])).'";
$m_smtp_c_email_from_ssl="'.htmlspecialchars(trim((string) $_POST['m_smtp_c_email_from_ssl'])).'";
$m_smtp_c_email_from_port="'.htmlspecialchars(trim((string) $_POST['m_smtp_c_email_from_port'])).'";
$m_smtp_c_standard_email_from="'.htmlspecialchars(trim((string) $_POST['m_smtp_c_standard_email_from'])).'";
$m_smtp_c_on_off_substituting_email="'.htmlspecialchars((string) $_POST['m_smtp_c_on_off_substituting_email']).'";
$m_smtp_c_window_msg="'.htmlspecialchars((string) $_POST['m_smtp_c_window_msg']).'";
$m_smtp_c_secretkeygoogle="'.htmlspecialchars((string) $_POST['secretkeygoogle']).'";
$m_smtp_c_domainkeygoogle="'.htmlspecialchars((string) $_POST['domainkeygoogle']).'";
$m_smtp_c_digitSalt="'.htmlspecialchars(trim((string) $_POST['m_smtp_c_digitSalt'])).'";
$m_smtp_c_agree_checkbox="'.htmlspecialchars((string) $_POST['m_smtp_c_agree_checkbox']).'";
$m_smtp_c_client_server="'.htmlspecialchars((string) $_POST['m_smtp_c_client_server']).'";
$m_smtp_c_default_css="'.htmlspecialchars((string) $_POST['m_smtp_c_default_css']).'";
?>');

$my_smtp_c_selected_dir = htmlspecialchars((string) $_POST['my_smtp_c_selected_dir']);
$my_smtp_c_selected_name = htmlspecialchars((string) $_POST['my_smtp_c_selected_name']);
if ($my_smtp_c_selected_dir == 'no-forms') { $my_smtp_c_selected_name = ''; }
file_put_contents( $MSCDIR.'/'.$m_smtp_c_thisfile.'/active_cfg.php', '<?php
$my_smtp_c_selected_dir="'.$my_smtp_c_selected_dir.'";
$my_smtp_c_selected_name="'.$my_smtp_c_selected_name.'";
?>');

require($MSCDIR.'/'.$m_smtp_c_thisfile.'/cfg.php');
require($MSCDIR.'/'.$m_smtp_c_thisfile.'/active_cfg.php');
if ($my_smtp_c_selected_dir != 'no-forms') {
require($MSCDIR.'/'.$m_smtp_c_thisfile.'/forms/'.$my_smtp_c_selected_dir.'/cfg.php');
}
require($MSCDIR.'/'.$m_smtp_c_thisfile.'/lang/'.$m_smtp_c_language.'.php');
echo '<script> if (document.querySelector(\'.main\')) { document.querySelector(\'.main\').innerHTML = \'\'; } </script> <div class="updated" style="display: block;"><p>'.$m_smtp_c_admin_updating_settings.'</p></div>';
_end_addsettings:
?>
<script>
setTimeout('window.location.href = \'load.php?id=<?php echo $m_smtp_c_thisfile; ?>\';', 3000);
</script>
<?php
}

if ($act == 'my_smtp_c_New') {
	$my_smtp_c_new_name = htmlspecialchars((string) $_POST['my_smtp_c_new_name']);
	$my_smtp_c_new_id = uniqid(random_int(10, 99));
	if (mkdir($MSCDIR.'/'.$m_smtp_c_thisfile.'/forms/'.$my_smtp_c_new_id)) {
	 if (copy($MSCDIR.'/'.$m_smtp_c_thisfile.'/forms_cfg.php', $MSCDIR.'/'.$m_smtp_c_thisfile.'/forms/'.$my_smtp_c_new_id.'/cfg.php')) {
	  file_put_contents($MSCDIR.'/'.$m_smtp_c_thisfile.'/forms/ids-names.dat', $my_smtp_c_new_id . '|' . $my_smtp_c_new_name . "\r\n", FILE_APPEND);
	  echo '<script> if (document.querySelector(\'.error_place\')) { document.querySelector(\'.error_place\').innerHTML = \'<div class="updated" style="display: block;"><p>'.$my_smtp_c_admin_msg_created.'</p></div>\'; } </script>';
	 }
	}
	else {
	 echo '<script> if (document.querySelector(\'.error_place\')) { document.querySelector(\'.error_place\').innerHTML = \'<div class="error" style="display: block;"><p>'.$my_smtp_c_admin_error13.'</p></div>\'; } </script>';
	}
	 echo '<script> document.querySelector(\'select[name=my_smtp_c_selected_dir]\').options[0].text = \'\'; document.querySelector(\'#my_smtp_c_short_code\').style.display = \'none\'; </script>';
?>
<script>
setTimeout('window.location.href = \'load.php?id=<?php echo $m_smtp_c_thisfile; ?>\';', 3000);
</script>
<?php
}

if ($act == 'my_smtp_c_Delete') {
		$my_smtp_c_dir_and_name = $my_smtp_c_selected_dir .'|'. $my_smtp_c_selected_name; // dir|name
		
		foreach ( $my_smtp_c_forms_arr as $key => $val ) 
		 {
			if ( str_contains((string) $val, $my_smtp_c_dir_and_name) ) // look for a match
			{   
				$index = $key; 
			}
		 }

        unset($my_smtp_c_forms_arr[$index]); // delete
	
		$str = '';
		foreach ( $my_smtp_c_forms_arr as $key => $val )
		 {
		  $str .= $val;
		 }
		
		if ($my_smtp_c_selected_dir != 'no-forms') {
		 file_put_contents($MSCDIR.'/'.$m_smtp_c_thisfile.'/forms/ids-names.dat', $str); // write to file
		 my_smtp_c_rmRec($MSCDIR.'/'.$m_smtp_c_thisfile.'/forms/'.$my_smtp_c_selected_dir.'');		 
file_put_contents($MSCDIR.'/'.$m_smtp_c_thisfile.'/active_cfg.php', '<?php
$my_smtp_c_selected_dir="no-forms";
$my_smtp_c_selected_name="";
?>');
		 echo '<script> if (document.querySelector(\'.error_place\')) { document.querySelector(\'.error_place\').innerHTML = \'<div class="updated" style="display: block;"><p>'.$my_smtp_c_admin_msg_deleted.'</p></div>\'; } </script>';
		}
		else {
		 echo '<script> if (document.querySelector(\'.error_place\')) { document.querySelector(\'.error_place\').innerHTML = \'<div class="error" style="display: block;"><p>'.$my_smtp_c_admin_error14.'</p></div>\'; } </script>';
		}
		 echo '<script> document.querySelector(\'select[name=my_smtp_c_selected_dir]\').options[0].text = \'\'; document.querySelector(\'#my_smtp_c_short_code\').style.display = \'none\'; </script>';
?>
<script>
setTimeout('window.location.href = \'load.php?id=<?php echo $m_smtp_c_thisfile; ?>\';', 3000);
</script>
<?php
}

if ($act == 'my_smtp_c_Rename') {
	$arr_file = file($MSCDIR.'/'.$m_smtp_c_thisfile.'/forms/ids-names.dat');
    $my_smtp_c_old_id = htmlspecialchars((string) $_POST['my_smtp_c_old_id']);
	$my_smtp_c_old_name = htmlspecialchars((string) $_POST['my_smtp_c_old_name']);
	$my_smtp_c_new_name = htmlspecialchars((string) $_POST['my_smtp_c_new_name']);
	$my_smtp_c_dir_and_name = $my_smtp_c_old_id .'|'. $my_smtp_c_old_name; // dir|name
	
		$str = '';
		foreach($arr_file as $key => $val)
		 {
		  if ($my_smtp_c_dir_and_name == trim((string) $val)) {
		   $val = str_replace($my_smtp_c_old_name, $my_smtp_c_new_name, (string) $val);
		  }
		  $str .= $val;
		 }

	if (file_exists($MSCDIR.'/'.$m_smtp_c_thisfile.'/forms/'.$my_smtp_c_old_id)) {
	 file_put_contents($MSCDIR.'/'.$m_smtp_c_thisfile.'/forms/ids-names.dat', $str); // write to file
	 echo '<script> if (document.querySelector(\'.error_place\')) { document.querySelector(\'.error_place\').innerHTML = \'<div class="updated" style="display: block;"><p>'.$my_smtp_c_admin_msg_renamed.'</p></div>\'; } </script>';
	}
	else {
	 echo '<script> if (document.querySelector(\'.error_place\')) { document.querySelector(\'.error_place\').innerHTML = \'<div class="error" style="display: block;"><p>'.$my_smtp_c_admin_error15.'</p></div>\'; } </script>';
	}
	 echo '<script> document.querySelector(\'select[name=my_smtp_c_selected_dir]\').options[0].text = \'\'; document.querySelector(\'#my_smtp_c_short_code\').style.display = \'none\'; </script>';
?>
<script>
setTimeout('window.location.href = \'load.php?id=<?php echo $m_smtp_c_thisfile; ?>\';', 3000);
</script>
<?php
}

echo '
<script>
	my_smtp_c_CSSLoad("'.$MSCURL.'plugins/'.$m_smtp_c_thisfile.'/windows.css");
	my_smtp_c_JSLoad("'.$MSCURL.'plugins/'.$m_smtp_c_thisfile.'/windows.js");
</script>';

?>
