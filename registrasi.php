<?php
session_start();
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran</title>
    <script>
        function validateForm() {
            var username = document.getElementById('username').value;
            var email = document.getElementById('email').value;
            var password = document.getElementById('password').value;
            
            if (username == "") {
                alert("Username harus diisi");
                return false;
            }
            
            if (email == "") {
                alert("Email harus diisi");
                return false;
            } else if (!/\S+@\S+\.\S+/.test(email)) {
                alert("Email tidak valid");
                return false;
            }
            
            if (password.length < 6) {
                alert("Password minimal 6 karakter");
                return false;
            }
            
            return true;
        }
    </script>
</head>
<body>
    <h2>Form Pendaftaran</h2>
    <form action="proses_registrasi.php" method="POST" onsubmit="return validateForm()">
        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <button type="submit">Daftar</button>
    </form>
</body>
</html>