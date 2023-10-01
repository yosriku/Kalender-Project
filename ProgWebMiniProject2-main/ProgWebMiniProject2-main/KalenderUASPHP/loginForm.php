<?php
session_start();

$host = 'localhost';
$database = 'mini_project2';
$username = 'root';
$password = '';

// Membuat koneksi ke database
$conn = new mysqli($host, $username, $password, $database);

// Memeriksa koneksi ke database
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $name = $_POST['nameLogin'];
    $password = $_POST['passLogin'];

    // Melakukan query untuk memeriksa apakah username dan password cocok
    $sql = "SELECT * FROM user WHERE name='" . $name . "' AND password='" . $password . "'";
    $result = mysqli_query($conn, $sql);
    
    // Memeriksa apakah query menghasilkan baris data
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['loged_in'] = true;
        $_SESSION['id'] = $row['id'];
        header('location: index.php');
        setcookie("username", $row['name'], time() + 3600);
        exit();
    } else {
        echo "<script>window.alert('Username atau password salah')</script>";
    }
}

// Menutup koneksi ke database
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Plis</title>
    <link rel="stylesheet" href="styleLogin.css" >
</head>
<body style="display:flex; align-items:center; justify-content:center;"> 
    <div class="login-page">
        <div class="form">
        <form class="login-form" action="loginForm.php" method="post">
        <h2><i class="fas fa-lock"></i> Login</h2>
        <table>
            <tr>
                <td>
                    Username: 
                </td>
                <td>
                    <input id="nameLogin" name="nameLogin" type="text" required />
                </td>
            </tr>
            <tr>
                <td>
                    Password: 
                </td>
                <td>
                    <input name="passLogin" id="passLogin" type="password" required />
                </td>
            </tr>
            <td colspan="2">
                <button type="submit" name="submit">login</button>
            </td>
        </table> 
        </form>
        <p class="message"></p>
        </div>
    </div>   
    <script>
        <?php
        if (isset($_POST['submit'])) {
            echo "window.alert('Username atau password salah')";
        }
        ?>
    </script>
</body>
</html>