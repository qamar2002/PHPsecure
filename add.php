<?php
session_start();
if (!isset($_SESSION["authenticated"]) || !$_SESSION["authenticated"]) {
    header("Location: login.php");
    exit;
}
//csrf secure
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = uniqid("", true);
}

include "mysql_conn.php";
$mysql_obj = new mysql_conn();
$mysql = $mysql_obj->GetConn();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF Token Validation Failed");
    }
    //sql injection addslashes secure
    $name = addslashes($_POST["name"]);
    $Box = addslashes($_POST["Box"]);
    $phonenumber = addslashes($_POST["phonenumber"]);

    $sql = "INSERT INTO lecturers (name, Box, phonenumber)
            VALUES ('$name', '$Box', '$phonenumber')";
    if ($mysql->query($sql) === TRUE) {
        header("Location: table.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $mysql->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>הוספת מרצה חדש</title>
</head>
<body>
<style>
    body {
        font-family: 'Helvetica', sans-serif;
        background-color: #f8007e;
        margin: 0;
        padding: 0;
    }

    h2 {
        font-size: 28px;
    }

    button {
        background-color: #f8007e;
        color: #0c0000;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
    }


    input[type="submit"] {
        background-color: #f8007e; /* Change the button background color */
        color: #020000; /* Change the button text color */
        padding: 10px 20px;
        font-size: 15px;
        cursor: pointer;
    }

    h2 {
        color: #000000;
        font-size: 35px;
        font-weight: bold;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    input {
        font-size: 20px;
        font-weight: bold;
        background-color: #f8007e;
        color: #150000; /* Change the link color */
        border: 2px solid;
        padding: 10px;
        margin: 10px auto;
        display: inline-block;
        width: 30%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    label {
        font-size: 20px;
        font-weight: bold;
        margin: 10px auto;
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
    }
</style>
<h2>הוספת מרצה חדש</h2>
<!--xss secure-->
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <label>שם מרצה<input type="text" name="name" required><br></label>
    <label> מספר תיבת דואר<input type="number" name="Box" required><br></label>
    <label>מספר טלפון<input type="text" name="phonenumber" required><br></label><br><br>
    <input type="submit" value="  הוסף מרצה">
</form>
</body>
</html>
