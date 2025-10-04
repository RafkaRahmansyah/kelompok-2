<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

require_once '../config/database.php';
require_once '../includes/header.php';
?>

<div class="dashboard-container">
    <div class="dashboard-header">
        <h2>Dashboard <?= ucfirst($_SESSION['role']) ?></h2>
        <div class="user-info">
            <span><i class="fas fa-user"></i> <?= $_SESSION['nama'] ?></span>
            <a href="../logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>

    <div class="dashboard-content">
        <div class="info-card">
            <h3>Informasi Akun</h3>
            <div class="info-item">
                <span>Username:</span>
                <span><?= $_SESSION['role'] === 'guru' ? $_SESSION['nip'] : $_SESSION['nis'] ?></span>
            </div>
            <div class="info-item">
                <span>Role:</span>
                <span><?= ucfirst($_SESSION['role']) ?></span>
            </div>
            <div class="info-item">
                <span>Nama Lengkap:</span>
                <span><?= $_SESSION['nama'] ?></span>
            </div>
        </div>

        <div class="features">
            <h3>Fitur Tersedia</h3>
            <div class="feature-grid">
                <?php if ($_SESSION['role'] === 'guru'): ?>
                    <div class="feature-card">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <h4>Kelola Kelas</h4>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-clipboard-list"></i>
                        <h4>Input Nilai</h4>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-calendar-alt"></i>
                        <h4>Jadwal Mengajar</h4>
                    </div>
                <?php else: ?>
                    <div class="feature-card">
                        <i class="fas fa-book"></i>
                        <h4>Lihat Nilai</h4>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-calendar-check"></i>
                        <h4>Jadwal Pelajaran</h4>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-file-alt"></i>
                        <h4>Materi Pembelajaran</h4>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>