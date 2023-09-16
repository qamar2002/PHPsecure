<?php
session_start();
$max_attempts = 3;
$block_duration = 30;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //  brute force secure
    if (isset($_SESSION['block_start_time']) && time() - $_SESSION['block_start_time'] < $block_duration) {
        $remaining_time = $block_duration - (time() - $_SESSION['block_start_time']);
        $error_message = " אנא נסה שוב בעוד " . $remaining_time . " שניות.";
    } else {
        $password = $_POST["password"];
        $correct_password = "AAA";
        if ($password === $correct_password) {
            unset($_SESSION['login_attempts']);
            unset($_SESSION['block_start_time']);
            $_SESSION["authenticated"] = true;
            header("Location: table.php");
            exit;
        } else {
            if (!isset($_SESSION['login_attempts'])) {
                $_SESSION['login_attempts'] = 1;
            } else {
                $_SESSION['login_attempts']++;
                if ($_SESSION['login_attempts'] >= $max_attempts) {
                    $_SESSION['block_start_time'] = time();
                    $error_message = "אנא נסה שוב בעוד $block_duration שניות.";
                }
            }
            $error_message = "סיסמה שגויה";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>התחברות</title>
    <style>
        body {
            font-family: Arial, sans-serif; /* שינוי סוג הגופן */
            background-color: #f8007e; /* שינוי צבע רקע */
        }

        h2 {
            color: #000000; /* שינוי צבע הכותרת */
            font-size: 30px;
        }
        h1 {
            color: #000000; /* שינוי צבע הכותרת */
            font-size: 30px;

        }


        label {
            font-size: 16px;
            color: #070000; /* שינוי צבע התווית */
            font-weight: bold;
        }

        input[type="password"] {
            width: 20%;
            padding: 10px;
        }

        input[type="submit"] {
            background-color: #f8007e; /* שינוי צבע רקע של הכפתור */
            color: #000000; /* שינוי צבע טקסט של הכפתור */
            padding: 20px ;
            border: 1px solid #020000;
            cursor: pointer;
            font-size: 20px;
        }
        p.error-message {
            color: #000000; /* שינוי צבע ההודעה של שגיאה */
            font-size: 25px;
        }
    </style>
</head>
<body>
<center>
    <h2>התחברות </h2>
    <!--xss secure-->
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="password">Password
            <br><br>
            <input type="password" name="password"  required></label>
        <br><br><br><br>
        <input type="submit" value="  התחבר   ">

    </form>
    <?php
    if (isset($error_message)) {
        echo "<p class='error-message'>$error_message</p>";
    }
    ?>
</center>
</body>
</html>
