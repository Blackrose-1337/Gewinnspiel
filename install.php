<?php
// Gibt den Benutzernamen aus, unter dem der PHP/HTTPD-Prozess läuft
// (auf einem System in dem das Programm "whoami" im Ausführungspfad liegt)

$php_version = phpversion();
print_r("\n" . $php_version . "\n");
fopen('test.txt', 'w');
echo "Stephan";
phpinfo();
$output = shell_exec('whoami');
// exec('sudo apt update', $output, $retval);
// print_r($output);
//echo "Rückgabe mit Status $retval und Ausgabe:\n";
// print_r('Apache');$
// exec('sudo apt install apache2', $output, $retval);
// echo "Rückgabe mit Status Apache $retval und Ausgabe:\n";

// print_r($output);

// $output = shell_exec('ls -a');
// echo "<pre>$output</pre>";


// exec('curl -fsSl https://deb.nodesource.com/setup_16.x', $output, $retval);
// echo "Rückgabe mit Status $retval und Ausgabe:\n";
// print_r($output);
// exec('apt-get install nodejs', $output, $retval);
// echo "Rückgabe mit TEST $retval und Ausgabe:\n";
// print_r($output);
// fopen('test.sh', 'w');
// exec('npm install', $output, $retval);
// echo "Rückgabe mit Poppel $retval und Ausgabe:\n";
// print_r($output);

?>