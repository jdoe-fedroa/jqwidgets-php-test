<?php
include ('connect.php');

// connect to sql server
$databaseConn = new mysqli($hostname, $username, $password, $database);

// check the connection
if( $databaseConn->connect_errno )
{
	printf( "Connection failed: %s\n", $databaseConn->connect_error );
	exit();
}

// get data and store in a json array
$databaseQuery = "SELECT * FROM employees LIMIT i,i";
$from = 0;
$to = 200;

$result = $mysqli->prepare($databaseQuery);
$result->bind_param('ii', $from, $to);
$result->execute();

// bind result variables
$result->bind_result($employeeID, $birthDate, $firstName, $lastName, $gender, $hireDate);

// fetch values
while( $result->fetch() )
{
	$employees[] = array(
		'employeeID' => $employeeID,
		'birthDate' => $birthDate,
		'firstName' => $firstName,
		'lastName' => $lastName,
		'gender' => $gender,
		'hireDate' => $hireDate
	);
}

echo json_encode($employees);

// close statement
$result->close();

// close connection
$mysqli->close();
?>
