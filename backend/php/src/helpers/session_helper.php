<?php
error_log(session_status());
error_log("__________________________________________________________________________________________________________");
error_log(session_start());
if (!isset($_SESSION)) {
    session_set_cookie_params(0, "/", $_SERVER['SERVER_NAME']);
}
?>