<?php
session_start();

// Periksa token CSRF
if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
    die("Akses tidak sah!");
}

// Ambil data dari form
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Validasi sisi server
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Email tidak valid!");
}

// Sanitasi input untuk mencegah XSS
$username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');

// Hash password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "registrasi_db");

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Prepared Statement untuk mencegah SQL Injection
$stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $password_hash);

if ($stmt->execute()) {
    echo "Pendaftaran berhasil!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>