<?php 
include 'koneksi.php';
session_start();
if (isset($_SESSION['email'])) {
    header('location: dashboardAdmin.php');
    exit();
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM admin WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['email'] = $row['email'];
        $_SESSION['namaDepan'] = $row['nama_depan'];
        $_SESSION['namaBelakang'] = $row['nama_belakang'];
        $_SESSION['tanggalLahir'] = $row['tanggal_lahir'];
        $_SESSION['jenisKelamin'] = $row['jenis_kelamin'];
        header('location: dashboardAdmin.php'); 
        exit();
    } else {
        echo "<script>alert('Email atau password salah!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Login Page</title>
</head>

<body>
    <div class="h-screen md:flex">
        <div
            class="relative overflow-hidden md:flex w-1/2 bg-gradient-to-tr from-blue-800 to-purple-700 i justify-around items-center hidden">
            <div>
                <h1 class="text-white font-bold text-4xl font-sans">GoDashboard</h1>
                <p class="text-white mt-1">Aplikasi Manajemen data Siswa dan Ekstrakurikuler</p>
            </div>
            <div class="absolute -bottom-32 -left-40 w-80 h-80 border-4 rounded-full border-opacity-30 border-t-8"></div>
            <div class="absolute -bottom-40 -left-20 w-80 h-80 border-4 rounded-full border-opacity-30 border-t-8"></div>
            <div class="absolute -top-40 -right-0 w-80 h-80 border-4 rounded-full border-opacity-30 border-t-8"></div>
            <div class="absolute -top-20 -right-20 w-80 h-80 border-4 rounded-full border-opacity-30 border-t-8"></div>
        </div>
        <div class="flex md:w-1/2 justify-center py-10 items-center bg-white">
            <form class="bg-white" action="" method="POST">
                <h1 class="text-gray-800 font-bold text-2xl mb-1">Hi Admin!</h1>
                <p class="text-sm font-normal text-gray-600 mb-7">Welcome to Login Page!</p>
                <label for="email" class="text-lg font-bold">Email</label>
                <div class="flex items-center border-2 py-2 px-3 rounded-2xl mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                    <input class="pl-2 outline-none border-none" type="email" name="email" id="email" placeholder="Email Address" />
                </div>
                <label for="password" class="text-lg font-bold">Password</label>
                <div class="flex items-center border-2 py-2 px-3 rounded-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <input class="pl-2 outline-none border-none" type="password" name="password" id="password" placeholder="Password" />
                    <svg xmlns="http://www.w3.org/2000/svg" class="cursor-pointer" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="#000" d="M12 9a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3m0 8a5 5 0 0 1-5-5a5 5 0 0 1 5-5a5 5 0 0 1 5 5a5 5 0 0 1-5 5m0-12.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5" />
                    </svg>
                </div>
                <button type="submit" name="submit" id="submit" class="block w-full bg-indigo-600 mt-4 py-2 rounded-2xl text-white font-semibold mb-2 cursor-pointer">Login</button>
            </form>
        </div>
    </div>
</body>

</html>