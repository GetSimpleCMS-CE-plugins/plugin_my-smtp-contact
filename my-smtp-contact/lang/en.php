<?php

//
// FIELDS
//
$m_smtp_c_Name = 'Name';

$m_smtp_c_Email = 'Email';

$m_smtp_c_Message = 'Message';

$m_smtp_c_Captcha = 'Enter the numbers from the image';

$m_smtp_c_agree = 'I agree to the processing of personal data';

$m_smtp_c_Submit = 'Send';


//
// MESSAGES
//

// (deleted HTML in v1.1.1)
$m_smtp_c_NameEmailMessage_error = 'Please, fill all fields.';

$m_smtp_c_Email_error = 'Incorrect email address.';

$m_smtp_c_Captcha_error = 'The numbers in the image are entered incorrectly.';

$m_smtp_c_StopSpam_error = 'Spam protection failed.';

$m_smtp_c_agree_error = 'It is necessary to agree to processing of personal data';

$m_smtp_c_Success = 'Thanks, your message is sent.';

// v1.0.6
$m_smtp_c_Maxlength_error = 'More characters than allowed are entered.';

$m_smtp_c_Upload_error = 'File upload error:';

$m_smtp_c_Maxsize_error = 'The file size exceeds the allowed.';

$m_smtp_c_Format_error = 'The file format is not valid.';

$m_smtp_c_Move_error = 'Failed to move file:';

$m_smtp_c_Required_error = 'The field is required.';


//
// DESCRIPTIONS
//
$m_smtp_c_plugin_name = 'My SMTP Contact'; // Plugin name
$m_smtp_c_small_description = 'This plugin will help you to set up a contact form with captcha and checkbox. Plugin can be used SMTP (Simple Mail Transfer Protocol) to send mail.'; // Plugin Description
$m_smtp_c_description = "
<h2>How to install a contact form?</h2>
<p>Create a contact form, select it and set the desired configuration. You can create multiple contact forms.<br>For output, use a short-code or PHP-code that is automatically generated for each new contact form.</p>
<p>Standard PHP mail sending is enabled by default. Captcha uses cookies. The plugin can be translated into other languages. See /lang/en.php, ru.php ... Make your translation and upload the xx.php file to the directory - /lang/ - then select your language file in the plugin settings. Do not use 'id', 'name' attributes for alternative fields.</p>
";


//
// PLUGIN SETTINGS
//
$m_smtp_c_admin_donate = 'Donate:';

$m_smtp_c_admin_plugin_settings = 'Plugin settings';

$m_smtp_c_admin_language_file = 'Language file:';

$m_smtp_c_admin_email_to = 'E-mail address to receive mail:';

$m_smtp_c_admin_standard_or_smtp = 'Mail sending method:';

$m_smtp_c_admin_standard = 'Standard send';

$m_smtp_c_admin_smtp = 'Send via SMTP';

$m_smtp_c_admin_digital_captcha = 'Captcha:';

$m_smtp_c_admin_digitSalt = 'Captcha salt:';

$m_smtp_c_admin_digitSalt_generate = 'Generate new salt';

$m_smtp_c_admin_agree_checkbox = 'Checkbox:';

$m_smtp_c_admin_email_from = 'Address to send the mail:';

$m_smtp_c_admin_email_from_password = 'Password:';

$m_smtp_c_admin_email_from_ssl = 'Server:';

$m_smtp_c_admin_email_from_port = 'Port:';

$m_smtp_c_admin_submit = 'Save changes';

$m_smtp_c_admin_or = 'or';

$m_smtp_c_admin_backward = 'Go back';

$m_smtp_c_admin_updating_settings = 'Updating settings, please wait...';

// v1.0.6 
$m_smtp_c_admin_verification = 'Verification:';

$m_smtp_c_admin_verification_client_server = 'Client and server';

$m_smtp_c_admin_verification_server = 'Server only';

$m_smtp_c_admin_verification_sender_name = 'Sender name:';

$m_smtp_c_admin_verification_subject = 'Subject:';

$m_smtp_c_admin_alternative_fields = 'Alternative fields:';

$m_smtp_c_admin_select_on = 'On';

$m_smtp_c_admin_select_off = 'Off';

$m_smtp_c_admin_properties = 'Properties';

$m_smtp_c_admin_qty_fields = 'Quantity of fields:';

$m_smtp_c_admin_limit_file_size = 'Max file size (mb):';

$m_smtp_c_admin_valid_file_format = 'Allowed formats (,):';

$m_smtp_c_admin_designation = 'Designation';

$m_smtp_c_admin_yes_or_no_designation = 'Select whether show the field designation on the page or not';

$m_smtp_c_admin_yes_or_no_required = 'Select whether the field should be required';

$m_smtp_c_admin_field_type = 'Select field type';

$m_smtp_c_admin_Maxlength = 'Select the maximum number of characters in the field';

$m_smtp_c_admin_Code = 'Code';

// v1.0.7 ($m_smtp_c_admin_default_js in v1.1.1)
$m_smtp_c_admin_default_css = 'Default CSS customization:';

$m_smtp_c_admin_on_off_substituting_email = 'Substituting the senders email in the "From" field';

$m_smtp_c_admin_on_off_substituting_email_comment = 'Not all hosts and email services support this';

// v1.0.8 (renamed in v1.1.1)
$m_smtp_c_admin_window_msg = 'Plugin notifications:'; 

// v1.1.0
$my_smtp_c_admin_actions_forms = 'Actions with contact forms';

$my_smtp_c_admin_аctive_form = 'Active contact form:';

$my_smtp_c_admin_no_аctive_form = 'Create or select a contact form';

$my_smtp_c_admin_name = 'Contact form name:';

$my_smtp_c_btn_create = 'Create';

$my_smtp_c_btn_rename = 'Rename';

$my_smtp_c_btn_cancel = 'Сancel';

$my_smtp_c_btn_delete = 'Delete';

$my_smtp_c_admin_delete_form_confirm = 'Confirm contact form deletion';

$my_smtp_c_admin_error13 = 'Error creating contact form';

$my_smtp_c_admin_error14 = 'Error deleting contact form';

$my_smtp_c_admin_error15 = 'Error renaming contact form';

$my_smtp_c_admin_error17 = 'Contact form not created or selected';

$my_smtp_c_msg_no_form = 'Contact form does not exist';

$my_smtp_c_admin_msg_created = 'New contact form created';

$my_smtp_c_admin_msg_deleted = 'Contact form deleted';

$my_smtp_c_admin_msg_renamed = 'Contact form renamed';

$my_smtp_c_admin_short_code = 'Short-code:';

$my_smtp_c_admin_php_code = 'PHP-code:';

// v1.1.1
$m_smtp_c_Success_header = 'Success!';

$m_smtp_c_Error_header = 'Attention!';

$m_smtp_c_admin_modal_on = 'In modal window';

$m_smtp_c_admin_modal_off = 'On the page';

// v1.1.2
$my_smtp_c_admin_error_csrf = 'CSRF detected (cross-site request forgery), сhanges are not saved';

?>