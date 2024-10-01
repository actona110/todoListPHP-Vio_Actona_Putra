<?php
session_start(); // Memulai session untuk menyimpan data sementara

// Memeriksa apakah indeks tugas ada dalam list
if (!isset($_GET['index']) || !isset($_SESSION['todos'][$_GET['index']])) {
    header("Location: index.php"); // Mengalihkan jika indeks tidak valid
    exit;
}

$index = $_GET['index']; // Mengambil indeks tugas yang akan diedit

// Memproses pengiriman form jika metode request adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task = htmlspecialchars(trim($_POST['task'])); // Mengambil dan memangkas input tugas
    $priority = htmlspecialchars(trim($_POST['priority'])); // Mengambil prioritas tugas
    $description = htmlspecialchars(trim($_POST['description'])); // Mengambil deskripsi tugas
    $task_date = htmlspecialchars(trim($_POST['task_date'])); // Mengambil tanggal tugas
    $deadline_date = htmlspecialchars(trim($_POST['deadline_date'])); // Mengambil tanggal deadline

    // Validasi panjang karakter saat menginput data
    if (strlen($task) > 255 || strlen($description) > 500) {
        $_SESSION['error_message'] = "Karakter terlalu panjang!";
    } else {
        // Memperbarui tugas dalam daftar
        $_SESSION['todos'][$index] = [
            'task' => $task,
            'priority' => $priority,
            'description' => $description,
            'task_date' => $task_date, // Memperbarui tanggal tugas
            'deadline_date' => $deadline_date, // Memperbarui tanggal deadline 
            'status' => $_SESSION['todos'][$index]['status'] // Mempertahankan status tugas sesuai di dalam daftar || Status hanya berubah saat pilih tandai selesai
        ];
        $_SESSION['success_message'] = "Tugas berhasil diubah!"; // Memunculkan notifikasi pesan tugas berhasil diubah dari daftar
        header("Location: index.php"); // Mengalihkan kembali ke halaman index
        exit;
    }
}

// Mengambil detail tugas saat ini
$current_task = $_SESSION['todos'][$index];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tugas</title>
    <link rel="stylesheet" href="/dist/css/edit.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-slate-300">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Edit Tugas</h1>
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['error_message']); unset($_SESSION['error_message']); ?></div> <!-- Menampilkan pesan error -->
        <?php endif; ?>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="task" class="form-label">Nama Tugas</label>
                <input type="text" name="task" id="task" class="form-control" value="<?php echo htmlspecialchars($current_task['task']); ?>" required> <!-- Input untuk nama tugas -->
            </div>
            <div class="mb-3">
                <label for="priority" class="form-label">Prioritas</label>
                <select name="priority" id="priority" class="form-select" required> <!-- Pilihan untuk prioritas tugas -->
                    <option value="Rendah" <?php echo $current_task['priority'] === 'Rendah' ? 'selected' : ''; ?>>Rendah</option>
                    <option value="Sedang" <?php echo $current_task['priority'] === 'Sedang' ? 'selected' : ''; ?>>Sedang</option>
                    <option value="Tinggi" <?php echo $current_task['priority'] === 'Tinggi' ? 'selected' : ''; ?>>Tinggi</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Keterangan Tugas</label>
                <textarea name="description" id="description" class="form-control" rows="3" required><?php echo htmlspecialchars($current_task['description']); ?></textarea> <!-- Input untuk keterangan tugas -->
            </div>
            <div class="mb-3">
                <label for="task_date" class="form-label">Tanggal Tugas</label>
                <input type="datetime-local" name="task_date" id="task_date" class="form-control" value="<?php echo htmlspecialchars($current_task['task_date']); ?>" required> <!-- Input untuk tanggal tugas -->
            </div>
            <div class="mb-3">
                <label for="deadline_date" class="form-label">Tanggal Deadline</label>
                <input type="datetime-local" name="deadline_date" id="deadline_date" class="form-control" value="<?php echo htmlspecialchars($current_task['deadline_date']); ?>" required> <!-- Input untuk tanggal deadline -->
            </div>
            <button type="submit" class="btn-utama">Simpan Perubahan</button> <!-- Tombol untuk menyimpan perubahan -->
            <a href="index.php" class="btn-kedua ml-2">Batal</a> <!-- Tombol untuk membatalkan dan kembali -->
        </form>
    </div>
    <!-- JS Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
