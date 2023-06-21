<?php
require_once("config.php");

// Inisialisasi variabel
$name = "";
$username = "";
$password = "";
$email = "";
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Filter data yang diinputkan
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    // Enkripsi password
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    // Validasi username
    if (strlen($username) !== 8) {
        $errorMessage = "Username harus terdiri dari 8 karakter.";
    }

    // Jika tidak ada kesalahan, simpan data
    if ($errorMessage === "") {
        // Menyiapkan query
        $sql = "INSERT INTO users (name, username, email, password) 
                VALUES (:name, :username, :email, :password)";
        $stmt = $db->prepare($sql);

        // Bind parameter ke query
        $params = array(
            ":name" => $name,
            ":username" => $username,
            ":password" => $password,
            ":email" => $email
        );

        // Eksekusi query untuk menyimpan ke database
        $saved = $stmt->execute($params);

        // Jika query simpan berhasil, alihkan ke halaman login
        if ($saved) {
            header("Location: login.php");
            exit();
        } else {
            $errorMessage = "Gagal menyimpan data. Silakan coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aplikasi Galeri Pengumuman</title>
<!-- Font Icon -->
<link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

<!-- Main css -->
<link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">
<body class="bg-light">
    <div class="main">
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <form method="POST" action="" id="signup-form" class="signup-form">
                        <h2 class="form-title">Create account</h2>
                        
                        <div class="form-group">
                            <input type="text" class="form-input" name="name" id="name" placeholder="Your Name" value="<?php echo $name; ?>"/>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-input" name="username" id="username" placeholder="Username" value="<?php echo $username; ?>"/>
                            <?php if(!empty($errorMessage)): ?>
                            <div class="form-group">
                                <p style="color: red;"><?php echo $errorMessage; ?></p>
                            </div>
                        <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-input" name="email" id="email" placeholder="Your Email" value="<?php echo $email; ?>"/>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-input" name="password" id="password" placeholder="Password"/>
                            <span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password"></span>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
                            <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in  <a href="#" class="term-service">Terms of service</a></label>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="register" id="submit" class="form-submit" value="Daftar"/>
                        </div>
                    </form>
                    <p class="loginhere">
                        Sudah punya akun ? <a href="login.php" class="loginhere-link">Login Disini</a>
                    </p>
                </div>
            </div>
        </section>
    </div>
<!-- JS -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>