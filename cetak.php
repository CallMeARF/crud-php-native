<?php
require_once __DIR__ . '/vendor/autoload.php';
require 'functions.php';

// Ambil data dari tabel
$animes = query("SELECT * FROM anime_list");

// Membuat instance mPDF
$mpdf = new \Mpdf\Mpdf();

// Memulai buffer output
ob_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Anime List</title>
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
    }

    th,
    td {
      border: 1px solid #000;
      padding: 8px;
      text-align: left;
    }

    th {
      background-color: #f2f2f2;
    }

    img {
      width: 50px;
    }
  </style>
</head>

<body>
  <h1 style="text-align: center;">Anime List</h1>

  <?php
  $itemsPerPage = 5; // Jumlah data per halaman
  $totalItems = count($animes); // Total data
  $totalPages = ceil($totalItems / $itemsPerPage); // Total halaman

  for ($page = 1; $page <= $totalPages; $page++) {
    $start = ($page - 1) * $itemsPerPage; // Data mulai
    $end = min($start + $itemsPerPage, $totalItems); // Data akhir

    // Tabel untuk setiap halaman
    echo '<table>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Judul</th>
                  <th>Season</th>
                  <th>Genre</th>
                  <th>Episode</th>
                  <th>Studio</th>
                  <th>Skor</th>
                  <th>Gambar</th>
                </tr>
              </thead>
              <tbody>';

    for ($i = $start; $i < $end; $i++) {
      echo '<tr>
                  <td>' . ($i + 1) . '</td>
                  <td>' . $animes[$i]["judul"] . '</td>
                  <td>' . $animes[$i]["season"] . '</td>
                  <td>' . (is_array(json_decode($animes[$i]["genre"], true)) ? implode(", ", json_decode($animes[$i]["genre"], true)) : $animes[$i]["genre"]) . '</td>
                  <td>' . $animes[$i]["episode"] . '</td>
                  <td>' . $animes[$i]["studio"] . '</td>
                  <td>' . $animes[$i]["skor"] . '</td>
                  <td><img src="img/' . $animes[$i]["gambar"] . '" alt="Gambar"></td>
                </tr>';
    }

    echo '</tbody></table>';

    // Tambahkan pagebreak jika bukan halaman terakhir
    if ($page < $totalPages) {
      echo '<pagebreak />';
    }
  }
  ?>

</body>

</html>

<?php
$html = ob_get_contents(); // Mengambil konten dari buffer
ob_end_clean(); // Menghentikan dan membersihkan buffer

$mpdf->WriteHTML($html); // Menulis HTML ke PDF
$mpdf->Output('Anime_List.pdf', 'I'); // Outputkan PDF dengan nama "Anime_List.pdf"