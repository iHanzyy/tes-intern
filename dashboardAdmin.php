<?php
include 'koneksi.php';
session_start();


if (!isset($_SESSION['email'])) {
  header('location: index.php');
  exit();
}


$querySiswa = "SELECT * FROM siswa";
$resultSiswa = mysqli_query($conn, $querySiswa);


$queryEkstrakurikuler = "SELECT * FROM ekstrakurikuler";
$resultEkstrakurikuler = mysqli_query($conn, $queryEkstrakurikuler);


$querySiswaEkstrakurikuler = "SELECT se.id, s.nama_depan, s.nama_belakang, e.nama as ekskul_nama, se.tahun_mulai 
                             FROM siswa_ekstrakurikuler se
                             JOIN siswa s ON se.siswa_id = s.id
                             JOIN ekstrakurikuler e ON se.ekstrakurikuler_id = e.id";
$resultSiswaEkstrakurikuler = mysqli_query($conn, $querySiswaEkstrakurikuler);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>GoDashboard</title>

  <link
    rel="stylesheet"
    href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" />
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal mt-12">
  <header>
    <!--Nav-->
    <nav
      aria-label="menu nav"
      class="bg-gray-800 pt-2 md:pt-1 pb-1 px-1 mt-0 h-auto fixed w-full z-20 top-0">
      <div class="flex flex-wrap items-center">
        <div
          class="flex flex-shrink md:w-1/3 justify-center md:justify-start text-white">
          <a href="#" aria-label="Home" class="flex items-center">
            <span class="text-xl pl-2 font-bold">GoDashboard</span>
          </a>
        </div>

        <div
          class="flex w-full pt-2 content-center justify-end md:w-2/3 md:justify-end">
          <ul
            class="list-reset flex justify-end flex-1 md:flex-none items-center">
            <li class="flex-1 md:flex-none md:mr-3">
              <div class="relative inline-block">
                <button
                  onclick="toggleDD('myDropdown')"
                  class="drop-button text-white py-2 px-2 flex items-center">
                  <i class="fas fa-user mr-2"></i> Hi, <?php echo isset($_SESSION['namaDepan']) ? htmlspecialchars($_SESSION['namaDepan']) : 'Admin'; ?>
                  <svg
                    class="h-3 fill-current inline ml-1"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20">
                    <path
                      d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                  </svg>
                </button>
                <div
                  id="myDropdown"
                  class="dropdownlist absolute bg-gray-800 text-white right-0 mt-3 p-3 overflow-auto z-30 invisible">
                  <a

                    id="openProfileModal"
                    class="p-2 hover:bg-gray-700 text-white text-sm no-underline hover:no-underline block"><i class="fa fa-user fa-fw mr-1"></i> Profile</a>
                  <div class="border border-gray-700 my-2"></div>
                  <a
                    href="logoutProses.php"
                    class="p-2 hover:bg-gray-700 text-white text-sm no-underline hover:no-underline block"><i class="fas fa-sign-out-alt fa-fw mr-1"></i> Log Out</a>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <main>
    <div class="flex flex-col md:flex-row">
      <nav
        aria-label="alternative nav"
        class="bg-gray-800 shadow-xl h-20 fixed bottom-0 mt-12 md:relative md:h-screen z-10 w-full md:w-48 md:flex-shrink-0">
        <div
          class="md:mt-12 md:w-48 md:fixed md:left-0 md:top-0 content-center md:content-start text-left justify-between">
          <ul
            class="list-reset flex flex-row md:flex-col py-0 md:py-3 px-1 md:px-2 text-center md:text-left">
            <li class="mr-3 flex-1">
              <a
                href="#"
                class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-blue-600">
                <i class="fas fa-home pr-0 md:pr-3 text-blue-600"></i><span
                  class="pb-1 md:pb-0 text-xs md:text-base text-white md:text-white block md:inline-block">Dashboard</span>
              </a>
            </li>
          </ul>
        </div>
      </nav>

      <section class="w-full md:ml-0">
        <div
          id="main"
          class="main-content flex-1 bg-gray-100 mt-12 md:mt-2 pb-24 md:pb-5 overflow-x-hidden">
          <div class="bg-gray-800 pt-3">
            <div
              class="rounded-tl-3xl bg-gradient-to-r from-blue-900 to-gray-800 p-4 shadow text-2xl text-white">
              <h1 class="font-bold pl-2">Dashboard Pengolah Data Siswa</h1>
            </div>
          </div>

          <div class="flex flex-col flex-wrap mt-4 mx-4">
            <!-- Siswa Card -->
            <div id="siswa" class="w-full mb-6">
              <div class="bg-white border-transparent rounded-lg shadow-xl">
                <div
                  class="bg-gradient-to-b from-gray-300 to-gray-100 uppercase text-gray-800 border-b-2 border-gray-300 rounded-tl-lg rounded-tr-lg p-2 flex justify-between items-center">
                  <h2 class="font-bold uppercase text-gray-600">
                    Data Siswa
                  </h2>
                  <a href="createSiswa.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded inline-block">Tambah Data</a>
                </div>
                <div class="p-5 overflow-x-auto">
                  <table class="w-full p-5 text-gray-700">
                    <thead>
                      <tr>
                        <th class="text-left text-blue-900 p-2 border-b-2">
                          Nama Depan
                        </th>
                        <th class="text-left text-blue-900 p-2 border-b-2">
                          Nama Belakang
                        </th>
                        <th class="text-left text-blue-900 p-2 border-b-2">
                          Nomor HP
                        </th>
                        <th class="text-left text-blue-900 p-2 border-b-2">
                          NIS
                        </th>
                        <th class="text-left text-blue-900 p-2 border-b-2">
                          Alamat
                        </th>
                        <th class="text-left text-blue-900 p-2 border-b-2">
                          Jenis Kelamin
                        </th>
                        <th class="text-left text-blue-900 p-2 border-b-2">
                          Image
                        <th class="text-left text-blue-900 p-2 border-b-2">
                          Aksi
                        </th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php if (mysqli_num_rows($resultSiswa) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($resultSiswa)): ?>
                          <tr class="hover:bg-gray-100">
                            <td class="p-2"><?php echo htmlspecialchars($row['nama_depan']); ?></td>
                            <td class="p-2"><?php echo htmlspecialchars($row['nama_belakang']); ?></td>
                            <td class="p-2"><?php echo htmlspecialchars($row['nomor_hp']); ?></td>
                            <td class="p-2"><?php echo htmlspecialchars($row['nis']); ?></td>
                            <td class="p-2"><?php echo htmlspecialchars($row['alamat']); ?></td>
                            <td class="p-2"><?php echo htmlspecialchars($row['jenis_kelamin']); ?></td>
                            <td class="p-2">
                              <?php if (!empty($row['foto']) && file_exists($row['foto'])): ?>
                                <img src="<?php echo htmlspecialchars($row['foto']); ?>" alt="Foto" class="w-16 h-16 rounded-full">
                              <?php else: ?>
                                <p class="text-gray-500">No image available</p>
                              <?php endif; ?>
                            </td>
                            <td class="p-2">
                              <a href="editSiswa.php?id=<?php echo $row['id']; ?>"
                                class="bg-yellow-500 hover:bg-yellow-700 text-white py-1 px-2 rounded mr-1 inline-block">
                                <i class="fas fa-edit"></i>
                              </a>
                              <a href="deleteSiswa.php?id=<?php echo $row['id']; ?>"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"
                                class="bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded inline-block">
                                <i class="fas fa-trash"></i>
                              </a>
                            </td>
                          </tr>
                        <?php endwhile; ?>
                      <?php else: ?>
                        <tr>
                          <td colspan="7" class="p-2 text-center">Tidak ada data siswa</td>
                        </tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <!-- Eskul Card -->
            <div id="ekstrakurikuler" class="w-full mb-6">
              <div class="bg-white border-transparent rounded-lg shadow-xl">
                <div
                  class="bg-gradient-to-b from-gray-300 to-gray-100 uppercase text-gray-800 border-b-2 border-gray-300 rounded-tl-lg rounded-tr-lg p-2 flex justify-between items-center">
                  <h2 class="font-bold uppercase text-gray-600">
                    Data Ekstrakurikuler
                  </h2>
                  <a href="createEkskul.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded inline-block">Tambah Data</a>
                </div>
                <div class="p-5 overflow-x-auto">
                  <table class="w-full p-5 text-gray-700">
                    <thead>
                      <tr>
                        <th class="text-left text-blue-900 p-2 border-b-2">
                          Nama Ekstrakurikuler
                        </th>
                        <th class="text-left text-blue-900 p-2 border-b-2">
                          Nama PJ Ekstrakurikuler
                        </th>
                        <th class="text-left text-blue-900 p-2 border-b-2">
                          Status Ekstrakurikuler
                        </th>
                        <th class="text-left text-blue-900 p-2 border-b-2">
                          Aksi
                        </th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php if (mysqli_num_rows($resultEkstrakurikuler) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($resultEkstrakurikuler)): ?>
                          <tr class="hover:bg-gray-100">
                            <td class="p-2"><?php echo htmlspecialchars($row['nama']); ?></td>
                            <td class="p-2"><?php echo htmlspecialchars($row['penanggung_jawab']); ?></td>
                            <td class="p-2">
                              <span class="<?php echo $row['status'] === 'Aktif' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800'; ?> py-1 px-2 rounded-full text-sm">
                                <?php echo htmlspecialchars($row['status']); ?>
                              </span>
                            </td>
                            <td class="p-2">
                              <a href="editEkskul.php?id=<?php echo $row['id']; ?>"
                                class="bg-yellow-500 hover:bg-yellow-700 text-white py-1 px-2 rounded mr-1 inline-block">
                                <i class="fas fa-edit"></i>
                              </a>
                              <a href="deleteEkskul.php?id=<?php echo $row['id']; ?>"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"
                                class="bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded inline-block">
                                <i class="fas fa-trash"></i>
                              </a>
                            </td>
                          </tr>
                        <?php endwhile; ?>
                      <?php else: ?>
                        <tr>
                          <td colspan="4" class="p-2 text-center">Tidak ada data ekstrakurikuler</td>
                        </tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <!-- Siswa dengan Eskul Card -->
            <div class="w-full mb-6">
              <div class="bg-white border-transparent rounded-lg shadow-xl">
                <div
                  class="bg-gradient-to-b from-gray-300 to-gray-100 uppercase text-gray-800 border-b-2 border-gray-300 rounded-tl-lg rounded-tr-lg p-2 flex justify-between items-center">
                  <h2 class="font-bold uppercase text-gray-600">
                    Data Siswa dengan Ekstrakurikuler
                  </h2>
                  <a href="createSiswaEkskul.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded inline-block">Tambah Data</a>
                </div>
                <div class="p-5 overflow-x-auto">
                  <table class="w-full p-5 text-gray-700">
                    <thead>
                      <tr>
                        <th class="text-left text-blue-900 p-2 border-b-2">
                          Nama
                        </th>
                        <th class="text-left text-blue-900 p-2 border-b-2">
                          Ekstrakurikuler
                        </th>
                        <th class="text-left text-blue-900 p-2 border-b-2">
                          Tahun Mulai
                        </th>
                        <th class="text-left text-blue-900 p-2 border-b-2">
                          Aksi
                        </th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php if (mysqli_num_rows($resultSiswaEkstrakurikuler) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($resultSiswaEkstrakurikuler)): ?>
                          <tr class="hover:bg-gray-100">
                            <td class="p-2"><?php echo htmlspecialchars($row['nama_depan'] . ' ' . $row['nama_belakang']); ?></td>
                            <td class="p-2"><?php echo htmlspecialchars($row['ekskul_nama']); ?></td>
                            <td class="p-2"><?php echo htmlspecialchars($row['tahun_mulai']); ?></td>
                            <td class="p-2">
                              <a href="editSiswaEkskul.php?id=<?php echo $row['id']; ?>"
                                class="bg-yellow-500 hover:bg-yellow-700 text-white py-1 px-2 rounded mr-1 inline-block">
                                <i class="fas fa-edit"></i>
                              </a>
                              <a href="deleteSiswaEkskul.php?id=<?php echo $row['id']; ?>"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"
                                class="bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded inline-block">
                                <i class="fas fa-trash"></i>
                              </a>
                            </td>
                          </tr>
                        <?php endwhile; ?>
                      <?php else: ?>
                        <tr>
                          <td colspan="4" class="p-2 text-center">Tidak ada data siswa dengan ekstrakurikuler</td>
                        </tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </main>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      
      function toggleDD(myDropdown) {
        document.getElementById(myDropdown).classList.toggle("invisible");
      }

      
      window.toggleDD = toggleDD;

      
      window.onclick = function(event) {
        if (
          !event.target.matches(".drop-button") &&
          !event.target.matches(".drop-button *")
        ) {
          var dropdowns = document.getElementsByClassName("dropdownlist");
          for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (!openDropdown.classList.contains("invisible")) {
              openDropdown.classList.add("invisible");
            }
          }
        }

        
        if (profileModal && event.target === profileModal) {
          profileModal.classList.add("hidden");
        }
      };

      
      const profileModal = document.getElementById('profileModal');
      const openProfileModalBtn = document.getElementById('openProfileModal');
      const closeModalBtn = document.getElementById('closeModalBtn');

      if (openProfileModalBtn) {
        openProfileModalBtn.addEventListener('click', function(event) {
          event.preventDefault();
          profileModal.classList.remove('hidden');
        });
      }

      if (closeModalBtn) {
        closeModalBtn.addEventListener('click', function() {
          profileModal.classList.add('hidden');
        });
      }
    });
  </script>

  <!-- Profile Modal -->
  <div id="profileModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 lg:w-1/3 shadow-lg rounded-md bg-white">
      <div class="flex justify-between items-center pb-3">
        <h3 class="text-xl font-bold">Edit Profile</h3>
        <button id="closeModalBtn" class="text-black close-modal cursor-pointer">
          <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
            <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
          </svg>
        </button>
      </div>

      <form id="profileForm" method="POST" action="updateProfile.php" class="mt-4">
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="updateNamaDepan">
            Nama Depan
          </label>
          <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="updateNamaDepan" name="namaDepan" type="text" value="<?php echo isset($_SESSION['namaDepan']) ? htmlspecialchars($_SESSION['namaDepan']) : ''; ?>">
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="updateNamaBelakang">
            Nama Belakang
          </label>
          <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="updateNamaBelakang" name="namaBelakang" type="text" value="<?php echo isset($_SESSION['namaBelakang']) ? htmlspecialchars($_SESSION['namaBelakang']) : ''; ?>">
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="updateJenisKelamin">
            Jenis Kelamin
          </label>
          <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="updateJenisKelamin" name="jenisKelamin">
            <option value="Laki-Laki" <?php echo (isset($_SESSION['jenisKelamin']) && $_SESSION['jenisKelamin'] == 'Laki-Laki') ? 'selected' : ''; ?>>Laki-Laki</option>
            <option value="Perempuan" <?php echo (isset($_SESSION['jenisKelamin']) && $_SESSION['jenisKelamin'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
          </select>
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="updateTanggalLahir">
            Tanggal Lahir
          </label>
          <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="updateTanggalLahir" name="tanggalLahir" type="date" value="<?php echo isset($_SESSION['tanggalLahir']) ? htmlspecialchars($_SESSION['tanggalLahir']) : ''; ?>">
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="updateEmail">
            Email
          </label>
          <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="updateEmail" name="email" type="email" value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>">
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="updatePassword">
            Password Baru (Kosongkan jika tidak ingin mengubah)
          </label>
          <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="updatePassword" name="password" type="password" placeholder="Masukkan password baru">
        </div>

        <div class="flex items-center justify-between mt-6">
          <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
            type="submit">
            Simpan Perubahan
          </button>
        </div>
      </form>
    </div>
  </div>
</body>

</html>