<?php
if (!function_exists("m_smtp_c_Rand")) { function m_smtp_c_Rand($begin, $end) { return function_exists("mt_rand") ? mt_rand($begin, $end) : rand($begin, $end); } } 
$m_smtp_c_language="pl";
$m_smtp_c_email_to="to1@yandex.ru,to2@yandex.ru";
$m_smtp_c_smtp_or_standard="standard";
$m_smtp_c_sender_name="My-robot";
$m_smtp_c_subject="It is a new message!";
$m_smtp_c_email_from="from@yandex.ru";
$m_smtp_c_email_from_password="password";
$m_smtp_c_email_from_ssl="ssl://smtp.yandex.ru";
$m_smtp_c_email_from_port="465";
$m_smtp_c_standard_email_from="from@site.com";
$m_smtp_c_on_off_substituting_email="";
$m_smtp_c_window_msg="on";
$m_smtp_c_secretkeygoogle="";
$m_smtp_c_domainkeygoogle="";
$m_smtp_c_digitSalt="";
$m_smtp_c_agree_checkbox="on";
$m_smtp_c_client_server="server";
$m_smtp_c_default_css="off";
?>