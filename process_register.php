<?php
if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Valid email is required");
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if ( ! preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["confirm"]) {
    die("Passwords must match");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/database.php";

$sql = "INSERT INTO user (email, password_hash)
        VALUES (?, ?)";

$stmt = $mysqli->stmt_init();

if (! $stmt->prepare($sql))
{
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("ss",
                  $_POST["email"],
                  $password_hash);

if ($stmt->execute())
{
    header("Location: success_register.html");
    exit;
}
// Error when making duplicate email
// else
// {
//     try
//     {
//         throw new Exception($stmt->execute());
//     }
//     catch (Exception $e)
//     {
//         die("Problem");
//     }
// }