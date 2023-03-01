<?php
error_log(session_status());
error_log(session_start());
error_log('-----');
if (!isset($_SESSION)) {
    session_set_cookie_params(0, "/", $_SERVER['SERVER_NAME']);
}
?>