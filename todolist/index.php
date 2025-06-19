<?php
session_start();
include 'functions.php';

if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

$tasks = $_SESSION['tasks'];

// Tambah tugas baru
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['judul'])) {
    $judul = trim($_POST['judul']);
    if (!empty($judul)) {
        $tasks[] = ['judul' => $judul, 'status' => 'belum'];
    }
}

// Toggle status
if (isset($_POST['toggle_index'])) {
    $i = (int) $_POST['toggle_index'];
    if (isset($tasks[$i])) {
        $tasks[$i]['status'] = $tasks[$i]['status'] === 'selesai' ? 'belum' : 'selesai';
    }
}

// Hapus
if (isset($_POST['hapus_index'])) {
    $i = (int) $_POST['hapus_index'];
    if (isset($tasks[$i])) {
        unset($tasks[$i]);
        $tasks = array_values($tasks);
    }
}

// Simpan hasil edit
if (isset($_POST['save_edit_index'], $_POST['edited_judul'])) {
    $i = (int) $_POST['save_edit_index'];
    $edited = trim($_POST['edited_judul']);
    if (isset($tasks[$i]) && $edited !== '') {
        $tasks[$i]['judul'] = $edited;
    }
}

$_SESSION['tasks'] = $tasks;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>ToDoList</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            
            background: linear-gradient(to bottom, #e3f2fd 0%, #1976d2 100%);
            background-attachment: fixed;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .table td, .table th {
            vertical-align: middle;
        }
        
        .badge-selesai {
            background-color: #28a745;
        }
        
        .badge-belum {
            background-color: #ffc107;
            color: black;
        }

        .text-primary {
            color: #1976d2 !important;
        }

        .btn-primary {
            background-color: #1976d2;
            border-color: #1976d2;
        }

        .btn-primary:hover {
            background-color: #1565c0;
            border-color: #1565c0;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="text-primary fw-bold">ToDoList</h1>
        <p class="text-muted">Catat, Kelola, Selesaikan</p>
    </div>

    <!-- Form Tambah -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="post" class="d-flex flex-column flex-md-row gap-3">
                <input type="text" name="judul" class="form-control" placeholder="Tugas baru..." required>
                <button type="submit" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah</button>
            </form>
        </div>
    </div>

    <!-- Tabel Tugas -->
    <?php tampilkanDaftar($tasks); ?>
</div>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</body>
</html>
