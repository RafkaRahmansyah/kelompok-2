<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}
require_once '../config/database.php';
require_once '../includes/header.php';
?>

<div class="auth-container">
    <div class="auth-box">
        <div class="auth-header">
            <h2>Registrasi Akun Baru</h2>
            <p>Silakan lengkapi data diri Anda</p>
            <div class="back-link">
                <a href="../index.php"><i class="fas fa-arrow-left"></i> Kembali ke Login</a>
            </div>
        </div>

        <div class="auth-content">
            <form action="../proses.php?action=register" method="POST" id="register-form">
                <div class="form-group">
                    <label for="register-role">Pilih Role</label>
                    <select id="register-role" name="role" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="guru">Guru</option>
                        <option value="siswa">Siswa</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="register-nama">Nama Lengkap</label>
                    <input type="text" id="register-nama" name="nama" required>
                </div>

                <div class="form-group">
                    <label for="register-username">Username</label>
                    <input type="text" id="register-username" name="username" required>
                </div>

                <div class="form-group">
                    <label for="register-password">Password</label>
                    <input type="password" id="register-password" name="password" required>
                </div>

                <div class="form-group" id="nip-group" style="display: none;">
                    <label for="register-nip">NIP</label>
                    <input type="text" id="register-nip" name="nip">
                </div>

                <div class="form-group" id="nis-group" style="display: none;">
                    <label for="register-nis">NIS</label>
                    <input type="text" id="register-nis" name="nis">
                </div>

                <div class="form-group">
                    <label for="confirm-password">Konfirmasi Password</label>
                    <input type="password" id="confirm-password" name="confirm_password" required>
                </div>

                <button type="submit" class="btn">Register</button>
            </form>
        </div>
    </div>
</div>

<div class="notification" id="notification"></div>

<?php require_once '../includes/footer.php'; ?>