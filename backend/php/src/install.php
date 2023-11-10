<?php

	$dbHost = getenv('DB_HOST');
	$dbUsername = getenv('DB_USERNAME');
	$dbPassword = getenv('DB_PASSWORD');
	$dbName = getenv('DB_DATABASE_NAME');

try {
	// Verbindung zur Datenbank herstellen
	$conn = new mysqli($dbHost, $dbUsername, $dbPassword);

	// Überprüfen, ob die Verbindung erfolgreich hergestellt wurde
	if ($conn->connect_error) {
		throw new Exception("Connection failed: " . $conn->connect_error);
	}

	// Überprüfen, ob die Datenbank existiert
	$checkDbExistQuery = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbName'";
	$result = $conn->query($checkDbExistQuery);

	if ($result->num_rows === 0) {
		// Die Datenbank existiert nicht, also erstellen
		$createDbQuery = "CREATE DATABASE $dbName";
		if ($conn->query($createDbQuery) === TRUE) {
			error_log("Database created successfully". PHP_EOL);
		} else {
			throw new Exception("Error creating database: " . $conn->error);
		}
	} else {
		error_log("Database already exists". PHP_EOL);
	}

	// Verbindung zur Datenbank schließen
	$conn->close();

	// Verbindung zur neu erstellten Datenbank herstellen
	$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

	// Pfad zur SQL-Datei
    $sqlFilePath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'mysql' . DIRECTORY_SEPARATOR . 'initscripts' . DIRECTORY_SEPARATOR . '003tabels.sql';
	// SQL-Skript einlesen
	$sqlScript = file_get_contents($sqlFilePath);

	// SQL-Skript ausführen
	if ($conn->multi_query($sqlScript)) {
		while ($conn->more_results() && $conn->next_result()) {
			$conn->store_result();
		}
		error_log("SQL script executed successfully". PHP_EOL);
	} else {
		echo "Error executing SQL script: " . $conn->error;
	}
	$sqlFilePath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'mysql' . DIRECTORY_SEPARATOR . 'initscripts' . DIRECTORY_SEPARATOR . '004datas.sql';
	// SQL-Skript einlesen
	$sqlScript = file_get_contents($sqlFilePath);

	// SQL-Skript ausführen
	if ($conn->multi_query($sqlScript)) {
		while ($conn->more_results() && $conn->next_result()) {
			$conn->store_result();
		}
		error_log("SQL script executed successfully". PHP_EOL);
	} else {
		error_log("Error executing SQL script: " . $conn->error);
	}

	// Verbindung schließen
	$conn->close();
} catch (Exception $e) {
	// Fehlerprotokollierung in die Datei error_log.txt (oder eine andere Datei deiner Wahl)
	error_log("Fatal error: " . $e->getMessage() . PHP_EOL . $e->getTraceAsString());

	// Fehlermeldung für den Benutzer ausgeben
	echo "Fatal error: " . $e->getMessage();
}