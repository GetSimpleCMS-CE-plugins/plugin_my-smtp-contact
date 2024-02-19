<?php

//
// FIELDS
//
$m_smtp_c_Name = 'Имя';

$m_smtp_c_Email = 'Электронная почта';

$m_smtp_c_Message = 'Сообщение';

$m_smtp_c_Captcha = 'Введите цифры с картинки';

$m_smtp_c_agree = 'Я согласен на обработку персональных данных';

$m_smtp_c_Submit = 'Отправить';


//
// MESSAGES
//

// ( in v1.1.1 - удален HTML)
$m_smtp_c_NameEmailMessage_error = 'Пожалуйста заполните все поля.';

$m_smtp_c_Email_error = 'Неверный адрес электронной почты.';

$m_smtp_c_Captcha_error = 'Цифры c картинки введены неверно.';

$m_smtp_c_StopSpam_error = 'Это спам.';

$m_smtp_c_agree_error = 'Необходимо дать согласие на обработку персональных данных.';

$m_smtp_c_Success = '<span class="m_smtp_c_success">Спасибо, Ваше сообщение отправлено.';

// v1.0.6 
$m_smtp_c_Maxlength_error = 'Введено больше символов, чем разрешено.';

$m_smtp_c_Upload_error = 'Ошибка загрузки файла:';

$m_smtp_c_Maxsize_error = 'Размер файла превышает допустимый.';

$m_smtp_c_Format_error = 'Недопустимый формат файла.';

$m_smtp_c_Move_error = 'Не удалось переместить файл:';

$m_smtp_c_Required_error = 'Поле является обязательным.';


//
// DESCRIPTIONS
//
$m_smtp_c_plugin_name = 'Моя SMTP почта'; // Plugin name
$m_smtp_c_small_description = 'Этот плагин поможет вам настроить контактную форму с капчей и чекбоксом. Плагин может использовать SMTP (Simple Mail Transfer Protocol) для отправки почты.'; // Plugin Description
$m_smtp_c_description = "
<h2>Как установить контактную форму?</h2>
<p>Создайте контактную форму, выберите её и задайте нужную конфигурацию. Можно создавать несколько контактных форм.<br>Для вывода используйте короткий код или PHP код, который создаётся автоматически для каждой новой галереи.</p>
<p>Стандартная функция отправки PHP включена по умолчанию. Капча используют файлы cookies. Плагин может быть переведен на другие языки. Посмотрите /lang/en.php, ru.php ... Сделайте свой перевод и загрузите файл xx.php в директорию - /lang/ - затем выберите свой языковой файл в настройках плагина. Не используйте атрибуты 'id', 'name' для альтернативных полей.</p>
";


//
// PLUGIN SETTINGS
//
$m_smtp_c_admin_donate = 'Пожертвовать:';

$m_smtp_c_admin_plugin_settings = 'Настройки плагина';

$m_smtp_c_admin_language_file = 'Файл языка:';

$m_smtp_c_admin_email_to = 'Электронный адрес для получения почты:';

$m_smtp_c_admin_standard_or_smtp = 'Способ отправки почты:';

$m_smtp_c_admin_standard = 'Стандартная отправка';

$m_smtp_c_admin_smtp = 'Отправка по SMTP';

$m_smtp_c_admin_digital_captcha = 'Капча:';

$m_smtp_c_admin_digitSalt = 'Соль для капчи:';

$m_smtp_c_admin_digitSalt_generate = 'Сгенерировать новую соль';

$m_smtp_c_admin_agree_checkbox = 'Чекбокс:';

$m_smtp_c_admin_email_from = 'Адрес с которого будет отправляться почта:';

$m_smtp_c_admin_email_from_password = 'Пароль:';

$m_smtp_c_admin_email_from_ssl = 'Сервер:';

$m_smtp_c_admin_email_from_port = 'Порт:';

$m_smtp_c_admin_submit = 'Сохранить изменения';

$m_smtp_c_admin_or = 'или';

$m_smtp_c_admin_backward = 'Вернуться назад';

$m_smtp_c_admin_updating_settings = 'Обновление настроек, пожалуйста подождите...';

// v1.0.6 
$m_smtp_c_admin_verification = 'Проверка:';

$m_smtp_c_admin_verification_client_server = 'Клиент и сервер';

$m_smtp_c_admin_verification_server = 'Только сервер';

$m_smtp_c_admin_verification_sender_name = 'Имя отправителя:';

$m_smtp_c_admin_verification_subject = 'Тема:';

$m_smtp_c_admin_alternative_fields = 'Альтернативные поля:';

$m_smtp_c_admin_select_on = 'Вкл.';

$m_smtp_c_admin_select_off = 'Выкл.';

$m_smtp_c_admin_properties = 'Свойства';

$m_smtp_c_admin_qty_fields = 'Количество полей:';

$m_smtp_c_admin_limit_file_size = 'Макс. размер файла (мб):';

$m_smtp_c_admin_valid_file_format = 'Разрешенные форматы (,):';

$m_smtp_c_admin_designation = 'Обозначение';

$m_smtp_c_admin_yes_or_no_designation = 'Выберите, показывать обозначение поля на странице или нет';

$m_smtp_c_admin_yes_or_no_required = 'Выберите, должно ли поле быть обязательным';

$m_smtp_c_admin_field_type = 'Выберите тип поля';

$m_smtp_c_admin_Maxlength = 'Выберите максимальное количество символов в поле';

$m_smtp_c_admin_Code = 'Код';

// v1.0.7  (удалено $m_smtp_c_admin_default_js в v1.1.1)
$m_smtp_c_admin_default_css = 'Кастомизация CSS по умолчанию:';

$m_smtp_c_admin_on_off_substituting_email = 'Подстановка почты отправителей в поле "Oт"';

$m_smtp_c_admin_on_off_substituting_email_comment = 'Не все хостинги и почтовые сервисы поддерживают это';

// v1.0.8 (переименовано в v1.1.1)
$m_smtp_c_admin_window_msg = 'Уведомления плагина:';

// v1.1.0
$my_smtp_c_admin_actions_forms = 'Действия с контактными формами';

$my_smtp_c_admin_аctive_form = 'Активная контактная форма:';

$my_smtp_c_admin_no_аctive_form = 'Создайте или выберите контактную форму';

$my_smtp_c_admin_name = 'Название контактной формы:';

$my_smtp_c_btn_create = 'Создать';

$my_smtp_c_btn_rename = 'Переименовать';

$my_smtp_c_btn_cancel = 'Закрыть';

$my_smtp_c_btn_delete = 'Удалить';

$my_smtp_c_admin_delete_form_confirm = 'Подтвердите удаление контактной формы';

$my_smtp_c_admin_error13 = 'Ошибка при создании контактной формы';

$my_smtp_c_admin_error14 = 'Ошибка при удалении контактной формы';

$my_smtp_c_admin_error15 = 'Ошибка при переименовании контактной формы';

$my_smtp_c_admin_error17 = 'Контактная форма или не выбрана';

$my_smtp_c_msg_no_form = 'Контактная форма не существует';

$my_smtp_c_admin_msg_created = 'Новая контактная форма создана';

$my_smtp_c_admin_msg_deleted = 'Контактная форма удалена';

$my_smtp_c_admin_msg_renamed = 'Контактная форма переименована';

$my_smtp_c_admin_short_code = 'Короткий код:';

$my_smtp_c_admin_php_code = 'PHP код:';

// v1.1.1
$m_smtp_c_Success_header = 'Успех!';

$m_smtp_c_Error_header = 'Внимание!';

$m_smtp_c_admin_modal_on = 'В модальном окне';

$m_smtp_c_admin_modal_off = 'На странице';

// v1.1.2
$my_smtp_c_admin_error_csrf = 'Обнаружена CSRF (межсайтовая подделка запроса), изменения не сохранены';

?>