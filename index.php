<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: pages/dashboard.php');
    exit();
}
require_once 'includes/header.php';
?>

<div class="auth-container">
    <div class="auth-box">
        <div class="auth-header">
            <h2>Selamat Datang</h2>
            <p>Silakan login atau daftar akun</p>
        </div>

        <div class="auth-tabs">
            <button class="tab-btn active" data-tab="login">Login</button>
            <button class="tab-btn" data-tab="register">Register</button>
        </div>

        <div class="auth-content">
            <!-- Login Form -->
            <div id="login" class="auth-form active">
                <form action="proses.php?action=login" method="POST">
                    <div class="form-group">
                        <label for="login-username">Username</label>
                        <input type="text" id="login-username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="login-password">Password</label>
                        <input type="password" id="login-password" name="password" required>
                    </div>
                    <button type="submit" class="btn">Login</button>
                </form>
            </div>

            <!-- Register Form -->
            <div id="register" class="auth-form">
                <form action="proses.php?action=register" method="POST">
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
                    <button type="submit" class="btn">Register</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="notification" id="notification"></div>

<?php require_once 'includes/footer.php'; ?>