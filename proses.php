<?php
session_start();
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_GET['action'] ?? '';

    if ($action === 'login') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            // Get additional data based on role
            if ($user['role'] === 'guru') {
                $stmt = $pdo->prepare("SELECT * FROM guru WHERE user_id = ?");
                $stmt->execute([$user['id']]);
                $guru = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['nama'] = $guru['nama'];
                $_SESSION['nip'] = $guru['NIP'];
            } else {
                $stmt = $pdo->prepare("SELECT * FROM siswa WHERE user_id = ?");
                $stmt->execute([$user['id']]);
                $siswa = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['nama'] = $siswa['nama'];
                $_SESSION['nis'] = $siswa['NIS'];
            }

            echo json_encode(['status' => 'success', 'message' => 'Login berhasil!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Username atau password salah!']);
        }
    } elseif ($action === 'register') {
        $role = $_POST['role'];
        $nama = $_POST['nama'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Check if username exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            echo json_encode(['status' => 'error', 'message' => 'Username sudah digunakan!']);
            exit();
        }

        try {
            $pdo->beginTransaction();

            // Insert to users table
            $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
            $stmt->execute([$username, $password, $role]);
            $user_id = $pdo->lastInsertId();

            // Insert to role-specific table
            if ($role === 'guru') {
                $nip = $_POST['nip'];
                $stmt = $pdo->prepare("INSERT INTO guru (user_id, nama, NIP) VALUES (?, ?, ?)");
                $stmt->execute([$user_id, $nama, $nip]);
            } else {
                $nis = $_POST['nis'];
                $stmt = $pdo->prepare("INSERT INTO siswa (user_id, nama, NIS) VALUES (?, ?, ?)");
                $stmt->execute([$user_id, $nama, $nis]);
            }

            $pdo->commit();
            echo json_encode(['status' => 'success', 'message' => 'Registrasi berhasil!']);
        } catch (PDOException $e) {
            $pdo->rollBack();
            echo json_encode(['status' => 'error', 'message' => 'Registrasi gagal: ' . $e->getMessage()]);
        }
    }
}
