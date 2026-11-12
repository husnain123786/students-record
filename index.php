<?php
require_once 'config.php';

// =============================================
// FETCH ALL STUDENTS
// =============================================
$sql    = "SELECT * FROM students ORDER BY created_at DESC";
$result = $conn->query($sql);
$students = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
}

include 'header.php';
?>

<!-- Page Heading -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 fw-bold text-primary">
            <i class="bi bi-people-fill me-2"></i>All Students
        </h4>
        <small class="text-muted">Total: <?= count($students) ?> record(s)</small>
    </div>
    <a href="add.php" class="btn btn-primary">
        <i class="bi bi-plus-circle-fill me-1"></i> Add New Student
    </a>
</div>

<!-- =============================================
     SESSION ALERTS
============================================= -->
<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i><?= $_SESSION['success'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i><?= $_SESSION['error'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<!-- =============================================
     STUDENTS TABLE
============================================= -->
<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom">
        <h6 class="mb-0 text-secondary"><i class="bi bi-table me-2"></i>Students Records</h6>
    </div>
    <div class="card-body p-0">
        <?php if (empty($students)): ?>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox display-4 d-block mb-2"></i>
                <p>No students found. <a href="add.php">Add one now</a></p>
            </div>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0 align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Roll No</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Class</th>
                        <th>Gender</th>
                        <th class="text-center">Status</th>
                        <th>Added On</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $i => $s): ?>
                    <tr>
                        <td class="text-muted"><?= $i + 1 ?></td>
                        <td><span class="badge bg-secondary"><?= htmlspecialchars($s['roll_no']) ?></span></td>
                        <td class="fw-semibold"><?= htmlspecialchars($s['full_name']) ?></td>
                        <td class="text-muted"><?= htmlspecialchars($s['email']) ?></td>
                        <td><?= htmlspecialchars($s['class']) ?></td>
                        <td>
                            <?php if ($s['gender'] === 'Male'): ?>
                                <span class="badge bg-info text-dark"><i class="bi bi-gender-male me-1"></i>Male</span>
                            <?php elseif ($s['gender'] === 'Female'): ?>
                                <span class="badge bg-pink text-white" style="background-color:#e83e8c!important"><i class="bi bi-gender-female me-1"></i>Female</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Other</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if ($s['is_active']): ?>
                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Active</span>
                            <?php else: ?>
                                <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-muted small"><?= date('d M Y', strtotime($s['created_at'])) ?></td>
                        <td class="text-center">
                            <a href="edit.php?id=<?= $s['id'] ?>" class="btn btn-sm btn-outline-warning me-1" title="Edit">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <a href="delete.php?id=<?= $s['id'] ?>" 
                               class="btn btn-sm btn-outline-danger"
                               title="Delete"
                               onclick="return confirm('Are you sure you want to delete <?= htmlspecialchars(addslashes($s['full_name'])) ?>?')">
                                <i class="bi bi-trash-fill"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php
$conn->close();
?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
