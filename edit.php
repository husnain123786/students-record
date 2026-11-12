<?php
require_once 'config.php';

// =============================================
// FETCH STUDENT BY ID
// =============================================
$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    $_SESSION['error'] = 'Invalid student ID!';
    header('Location: index.php');
    exit;
}

$sql    = "SELECT * FROM students WHERE id = $id LIMIT 1";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    $_SESSION['error'] = 'Student not found!';
    header('Location: index.php');
    exit;
}

$student = $result->fetch_assoc();

// If old session data exists (after failed update), use that
if (isset($_SESSION['old'])) {
    $student = array_merge($student, $_SESSION['old']);
    unset($_SESSION['old']);
}

include 'header.php';
?>

<!-- Page Heading -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 fw-bold text-warning">
            <i class="bi bi-pencil-square me-2"></i>Edit Student
        </h4>
        <small class="text-muted">Editing: <strong><?= htmlspecialchars($student['full_name']) ?></strong></small>
    </div>
    <a href="index.php" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to List
    </a>
</div>

<!-- SESSION ALERTS -->
<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i><?= $_SESSION['error'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<!-- EDIT FORM -->
<div class="card shadow-sm border-0">
    <div class="card-header bg-warning text-dark">
        <h6 class="mb-0"><i class="bi bi-ui-checks me-2"></i>Update Student Information</h6>
    </div>
    <div class="card-body p-4">
        <form action="edit_query.php" method="POST" novalidate>

            <!-- Hidden ID -->
            <input type="hidden" name="id" value="<?= $student['id'] ?>">

            <div class="row g-3">

                <!-- Roll Number -->
                <div class="col-md-6">
                    <label for="roll_no" class="form-label fw-semibold">
                        Roll Number <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-hash"></i></span>
                        <input type="text"
                               id="roll_no"
                               name="roll_no"
                               class="form-control"
                               placeholder="e.g. 2024-001"
                               value="<?= htmlspecialchars($student['roll_no']) ?>"
                               required>
                    </div>
                </div>

                <!-- Full Name -->
                <div class="col-md-6">
                    <label for="full_name" class="form-label fw-semibold">
                        Full Name <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                        <input type="text"
                               id="full_name"
                               name="full_name"
                               class="form-control"
                               placeholder="e.g. Ali Hassan"
                               value="<?= htmlspecialchars($student['full_name']) ?>"
                               required>
                    </div>
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <label for="email" class="form-label fw-semibold">
                        Email Address <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                        <input type="email"
                               id="email"
                               name="email"
                               class="form-control"
                               placeholder="student@example.com"
                               value="<?= htmlspecialchars($student['email']) ?>"
                               required>
                    </div>
                </div>

                <!-- Class (Select) -->
                <div class="col-md-3">
                    <label for="class" class="form-label fw-semibold">
                        Class <span class="text-danger">*</span>
                    </label>
                    <select id="class" name="class" class="form-select" required>
                        <option value="">-- Select Class --</option>
                        <?php
                        $classes = ['9th','10th','11th','12th','BS-1','BS-2','BS-3','BS-4'];
                        foreach ($classes as $c):
                        ?>
                        <option value="<?= $c ?>" <?= $student['class'] === $c ? 'selected' : '' ?>><?= $c ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Gender (Select) -->
                <div class="col-md-3">
                    <label for="gender" class="form-label fw-semibold">
                        Gender <span class="text-danger">*</span>
                    </label>
                    <select id="gender" name="gender" class="form-select" required>
                        <option value="">-- Select Gender --</option>
                        <?php
                        $genders = ['Male','Female','Other'];
                        foreach ($genders as $g):
                        ?>
                        <option value="<?= $g ?>" <?= $student['gender'] === $g ? 'selected' : '' ?>><?= $g ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Active Status (Checkbox) -->
                <div class="col-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input"
                               type="checkbox"
                               role="switch"
                               id="is_active"
                               name="is_active"
                               value="1"
                               <?= $student['is_active'] ? 'checked' : '' ?>>
                        <label class="form-check-label fw-semibold" for="is_active">
                            <i class="bi bi-toggle-on me-1 text-success"></i>
                            Student is <strong>Active</strong>
                        </label>
                    </div>
                    <div class="form-text">Uncheck to mark as Inactive.</div>
                </div>

            </div><!-- /row -->

            <hr class="my-4">

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning px-4">
                    <i class="bi bi-save-fill me-1"></i> Update Student
                </button>
                <a href="index.php" class="btn btn-outline-secondary px-4">
                    <i class="bi bi-x-circle me-1"></i> Cancel
                </a>
            </div>

        </form>
    </div>
</div>

<?php
$conn->close();
?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
