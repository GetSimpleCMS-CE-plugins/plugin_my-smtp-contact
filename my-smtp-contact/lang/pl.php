<?php

//
// FIELDS
//
$m_smtp_c_Name = 'Imię i nazwisko';

$m_smtp_c_Email = 'Email';

$m_smtp_c_Message = 'Wiadomość';

$m_smtp_c_Captcha = 'Wprowadź liczby z obrazka';

$m_smtp_c_agree = 'Wyrażam zgodę na przetwarzanie danych osobowych';

$m_smtp_c_Submit = 'Wyślij';


//
// MESSAGES
//

// (deleted HTML in v1.1.1)
$m_smtp_c_NameEmailMessage_error = 'Proszę wypełnić wszystkie pola.';

$m_smtp_c_Email_error = 'Nieprawidłowy adres e-mail.';

$m_smtp_c_Captcha_error = 'Liczby na obrazku są wpisane nieprawidłowo.';

$m_smtp_c_StopSpam_error = 'Ochrona przed spamem nie powiodła się.';

$m_smtp_c_agree_error = 'Niezbędna jest zgoda na przetwarzanie danych osobowych';

$m_smtp_c_Success = 'Dzięki, Twoja wiadomość została wysłana.';

// v1.0.6
$m_smtp_c_Maxlength_error = 'Wprowadzono więcej znaków niż jest to dozwolone.';

$m_smtp_c_Upload_error = 'Błąd przesyłania pliku:';

$m_smtp_c_Maxsize_error = 'Rozmiar pliku przekracza dozwolony.';

$m_smtp_c_Format_error = 'Format pliku jest nieprawidłowy.';

$m_smtp_c_Move_error = 'Nie udało się przenieść pliku:';

$m_smtp_c_Required_error = 'To pole jest wymagane.';


//
// DESCRIPTIONS
//
$m_smtp_c_plugin_name = 'My SMTP Contact'; // Plugin name
$m_smtp_c_small_description = 'Ta wtyczka pomoże Ci skonfigurować formularz kontaktowy z captcha i polem wyboru. Wtyczka może być używana do wysyłania poczty za pomocą protokołu SMTP (Simple Mail Transfer Protocol).'; // Plugin Description
$m_smtp_c_description = "
<h2>Jak zainstalować formularz kontaktowy?</h2>
<p>Utwórz formularz kontaktowy, wybierz go i ustaw żądaną konfigurację. Możesz utworzyć wiele formularzy kontaktowych.<br>W celu uzyskania wyników użyj krótkiego kodu lub kodu PHP, który jest automatycznie generowany dla każdego nowego formularza kontaktowego.</p>
<p>Standardowe wysyłanie poczty PHP jest domyślnie włączone. Captcha używa plików cookie. Wtyczkę można przetłumaczyć na inne języki. Zobacz /lang/en.php, ru.php, pl.php ... Dokonaj tłumaczenia i prześlij plik xx.php do katalogu - /lang/ - następnie wybierz plik językowy w ustawieniach wtyczki. Nie używaj atrybutów 'id', 'name' dla pól alternatywnych.</p>
";


//
// PLUGIN SETTINGS
//
$m_smtp_c_admin_donate = 'Dotacja:';

$m_smtp_c_admin_plugin_settings = 'Ustawienia wtyczki';

$m_smtp_c_admin_language_file = 'Plik językowy:';

$m_smtp_c_admin_email_to = 'Adres e-mail do odbierania poczty:';

$m_smtp_c_admin_standard_or_smtp = 'Metoda wysyłania poczty:';

$m_smtp_c_admin_standard = 'Wysyłanie standardowe';

$m_smtp_c_admin_smtp = 'Wyślij przez SMTP';

$m_smtp_c_admin_digital_captcha = 'Captcha:';

$m_smtp_c_admin_digitSalt = 'Captcha salt:';

$m_smtp_c_admin_digitSalt_generate = 'Generate new salt';

$m_smtp_c_admin_agree_checkbox = 'Pole wyboru:';

$m_smtp_c_admin_email_from = 'Adres do wysłania poczty:';

$m_smtp_c_admin_email_from_password = 'Hasło:';

$m_smtp_c_admin_email_from_ssl = 'Serwer:';

$m_smtp_c_admin_email_from_port = 'Port:';

$m_smtp_c_admin_submit = 'Zapisz zmiany';

$m_smtp_c_admin_or = 'lub';

$m_smtp_c_admin_backward = 'Wróć';

$m_smtp_c_admin_updating_settings = 'Aktualizuję ustawienia, proszę czekać...';

// v1.0.6 
$m_smtp_c_admin_verification = 'Weryfikacja:';

$m_smtp_c_admin_verification_client_server = 'Klient i serwer';

$m_smtp_c_admin_verification_server = 'Tylko serwer';

$m_smtp_c_admin_verification_sender_name = 'Imię, nazwisko nadawcy:';

$m_smtp_c_admin_verification_subject = 'Temat:';

$m_smtp_c_admin_alternative_fields = 'Pola alternatywne:';

$m_smtp_c_admin_select_on = 'Włączone';

$m_smtp_c_admin_select_off = 'Wyłączone';

$m_smtp_c_admin_properties = 'Ustawienia';

$m_smtp_c_admin_qty_fields = 'Ilość pól:';

$m_smtp_c_admin_limit_file_size = 'Maksymalny rozmiar pliku (mb):';

$m_smtp_c_admin_valid_file_format = 'Dozwolone formaty (,):';

$m_smtp_c_admin_designation = 'Przeznaczenie';

$m_smtp_c_admin_yes_or_no_designation = 'Wybierz, czy wyświetlać oznaczenie pola na stronie, czy nie';

$m_smtp_c_admin_yes_or_no_required = 'Wybierz, czy pole ma być wymagane';

$m_smtp_c_admin_field_type = 'Wybierz typ pola';

$m_smtp_c_admin_Maxlength = 'Wybierz maksymalną liczbę znaków w polu';

$m_smtp_c_admin_Code = 'Kod';

// v1.0.7 ($m_smtp_c_admin_default_js in v1.1.1)
$m_smtp_c_admin_default_css = 'Domyślne dostosowanie CSS:';

$m_smtp_c_admin_on_off_substituting_email = 'Zmiana adresu e-mail nadawców w polu „Od”';

$m_smtp_c_admin_on_off_substituting_email_comment = 'Nie wszystkie hosty i usługi poczty e-mail obsługują to';

// v1.0.8 (renamed in v1.1.1)
$m_smtp_c_admin_window_msg = 'Powiadomienia o wtyczkach:'; 

// v1.1.0
$my_smtp_c_admin_actions_forms = 'Akcje z formularzami kontaktowymi';

$my_smtp_c_admin_аctive_form = 'Aktywny formularz kontaktowy:';

$my_smtp_c_admin_no_аctive_form = 'Utwórz lub wybierz formularz kontaktowy';

$my_smtp_c_admin_name = 'Nazwa formularza kontaktowego:';

$my_smtp_c_btn_create = 'Utwórz';

$my_smtp_c_btn_rename = 'Zmień nazwę';

$my_smtp_c_btn_cancel = 'Anuluj';

$my_smtp_c_btn_delete = 'Usuń';

$my_smtp_c_admin_delete_form_confirm = 'Potwierdź usunięcie formularza kontaktowego';

$my_smtp_c_admin_error13 = 'Błąd podczas tworzenia formularza kontaktowego';

$my_smtp_c_admin_error14 = 'Błąd podczas usuwania formularza kontaktowego';

$my_smtp_c_admin_error15 = 'Błąd podczas zmiany nazwy formularza kontaktowego';

$my_smtp_c_admin_error17 = 'Formularz kontaktowy nie został utworzony lub wybrany';

$my_smtp_c_msg_no_form = 'Formularz kontaktowy nie istnieje';

$my_smtp_c_admin_msg_created = 'Utworzono nowy formularz kontaktowy';

$my_smtp_c_admin_msg_deleted = 'Usunięto formularz kontaktowy';

$my_smtp_c_admin_msg_renamed = 'Zmieniono nazwę formularza kontaktowego';

$my_smtp_c_admin_short_code = 'Short-code:';

$my_smtp_c_admin_php_code = 'PHP-code:';

// v1.1.1
$m_smtp_c_Success_header = 'Powodzenie!';

$m_smtp_c_Error_header = 'Uwaga!';

$m_smtp_c_admin_modal_on = 'W oknie modalnym';

$m_smtp_c_admin_modal_off = 'Na stronie';

// v1.1.2
$my_smtp_c_admin_error_csrf = 'Wykryto CSRF (cross-site request forgery), zmiany nie są zapisywane';

?>