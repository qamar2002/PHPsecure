<?php
session_start();
if (!isset($_SESSION["authenticated"]) || !$_SESSION["authenticated"]) {
    header("Location: login.php");
    exit;
}
include "mysql_conn.php";
$mysql_obj = new mysql_conn();
$mysql = $mysql_obj->GetConn();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = addslashes($_POST["id"]);
    $name = addslashes($_POST["name"]);
    $Box = addslashes($_POST["Box"]);
    $phonenumber = addslashes($_POST["phonenumber"]);
    $sql = "UPDATE lecturers SET name = '$name', Box = '$Box', phonenumber = '$phonenumber' WHERE id = $id";
    if ($mysql->query($sql) === TRUE) {
        header("Location: table.php");
        exit;
    } else {
        echo "Error updating record: " . $mysql->error;
    }
}
$id = addslashes($_GET["id"]);
$sql = "SELECT id, name, Box, phonenumber FROM lecturers WHERE id = $id";
$result = $mysql->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
} else {
    echo "מרצה לא נמצא";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>עריכת מרצה</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            font-family: 'Helvetica', sans-serif;
            background-color: #f8007e;
            margin: 0;
            padding: 0;
        }


        h2 {
            color: #000000; /* Change the header color */
            font-size: 35px;
            font-weight: bold;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        form {

            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            width: 25%;
        }

        input[type="text"],
        input[type="number"] {
            background-color: #f8007e;
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #000000;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            font-size: 20px;
        }  input[type="submit"] {
               background-color: #f8007e;
               width: 100%;
               padding: 10px;
               margin-bottom: 10px;
               border: 1px solid #000000;
               display: flex;
               flex-direction: column;
               justify-content: center;
               align-items: center;
               text-align: center;
               font-size: 20px;
           }



        label{
            font-size: 20px;
            font-weight: bold;
            margin: 10px auto;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
    </style>
</head>
<body>
<h2>    עריכה </h2>
<!--xss secure-->
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
    <label>עריכת שם<input type="text" name="name"  value="<?php echo $row["name"]; ?>" required> </label> <br>
    <label>עריכת תיבת דואר <input type="number" name="Box"  value="<?php echo $row["Box"]; ?>" required></label> <br>
    <label>עריכת מספר טלפון <input type="text" name="phonenumber" " value="<?php echo $row["phonenumber"]; ?>"></label> <br><br><br>
    <input type="submit" value=" ערוך      ">
</form>
</body>
</html>
