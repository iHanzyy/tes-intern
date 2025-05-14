<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: index.php'); exit;
}
if (!isset($_GET['id'])) {
    header('Location: dashboardAdmin.php'); exit;
}
$id = intval($_GET['id']);

$stmt = $conn->prepare("DELETE FROM siswa_ekstrakurikuler WHERE id=?");
$stmt->bind_param('i', $id);
$stmt->execute();
header('Location: dashboardAdmin.php'); exit;
?>
