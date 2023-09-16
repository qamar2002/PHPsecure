<?php
session_start();

if (!isset($_SESSION["authenticated"]) || !$_SESSION["authenticated"]) {
    header("Location: login.php");
    exit;
}

include "mysql_conn.php";
$mysql_obj = new mysql_conn();
$mysql = $mysql_obj->GetConn();
$sql = "SELECT id, name, Box, phonenumber FROM lecturers";
$result = $mysql->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>ניהול מרצים</title>
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

        a {
            font-size: 20px;
            color: #020000;
            text-decoration: none;
            border: 1px solid #020000;
            padding: 5px;
            display: inline-block;
            width: 70%;
            text-align: center;
            margin: 5px auto;
        }
        input[type="submit"] {
            background-color: #f8007e; /* Change the button background color */
            color: #020000; /* Change the button text color */
            padding: 10px 20px;
            font-size: 15px;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        td {
            border: 2px solid #020000;
            text-align: center;
            padding: 10px;
            font-size: 25px;
        }

        th {
            background-color: #f8007e;
            color: #000000;
            border: 2px solid #020000;
            text-align: center;
            padding: 10px;
            font-size: 20px;
        }

        tr:nth-child(even) {
            background-color: #f8007e;
        }

        tr:nth-child(odd) {
            background-color: #f8007e;
        }

        .add_lect {
            width: 15%;
        }

    </style>
</head>

</head>
<form method="POST" action="logout.php" >

    <input type="submit" value="  התנתק  ">
</form>
<center>
<h2>  ניהול </h2>
<a class="add_lect" href="add.php">    הוספת מרצה      </a>
</center>
<table>
    <tr>
        <th> שם   </th>
        <th> מספר תיבת דואר   </th>
        <th> מספר טלפון   </th>
        <th> מחק \ ערוך      </th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["name"]) . "</td>"; //הגנת xss
            echo "<td>" . htmlspecialchars($row["Box"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["phonenumber"]) . "</td>";
            echo "<td><a href='edit.php?id=" . $row["id"] . "'>  ערוך</a>  <br>  <a href='delete.php?id=" . $row["id"] . " '> מחק</a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>   אין מרצים להצגה  </td></tr>";
    }
    ?>
</table>
</body>
</html>

