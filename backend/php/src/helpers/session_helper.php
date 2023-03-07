<?php
/* Der gesammte Ablauf ist notwendig, da sonst keine bestehenden Sessions fortgesetzt werden sondern immer neu Initialisiert werden
und daher nutzlos wären in ihrer Aufgabe*/

// Überprüfung status Session
error_log(session_status());
// Sessionstart wenn keiner vorhanden oder wiederaufnahme einer Session
error_log(session_start());
// falls gar keine $_Session existiert, wird ein Cookie-Parameter gesetzt, um dies zu initialisieren
if (!isset($_SESSION)) {
    session_set_cookie_params(0, "/", $_SERVER['SERVER_NAME']);
}
?>