<?php
require_once 'config.php';
include 'header.php';
?>

<!-- Page Heading -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 fw-bold text-primary">
            <i class="bi bi-person-plus-fill me-2"></i>Add New Student
        </h4>
        <small class="text-muted">Fill in all required fields</small>
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

<!-- ADD STUDENT FORM -->
<div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white">
        <h6 class="mb-0"><i class="bi bi-ui-checks me-2"></i>Student Information</h6>
    </div>
    <div class="card-body p-4">
        <form action="add_query.php" method="POST" novalidate>

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
                               value="<?= htmlspecialchars($_SESSION['old']['roll_no'] ?? '') ?>"
                               required>
                    </div>
                    <div class="form-text">Must be unique for each student.</div>
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
                               value="<?= htmlspecialchars($_SESSION['old']['full_name'] ?? '') ?>"
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
                               value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>"
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
                        $oldClass = $_SESSION['old']['class'] ?? '';
                        foreach ($classes as $c):
                        ?>
                        <option value="<?= $c ?>" <?= $oldClass === $c ? 'selected' : '' ?>><?= $c ?></option>
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
                        $oldGender = $_SESSION['old']['gender'] ?? '';
                        foreach ($genders as $g):
                        ?>
                        <option value="<?= $g ?>" <?= $oldGender === $g ? 'selected' : '' ?>><?= $g ?></option>
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
                               <?= (isset($_SESSION['old']['is_active']) ? ($_SESSION['old']['is_active'] ? 'checked' : '') : 'checked') ?>>
                        <label class="form-check-label fw-semibold" for="is_active">
                            <i class="bi bi-toggle-on me-1 text-success"></i>
                            Mark student as <strong>Active</strong>
                        </label>
                    </div>
                    <div class="form-text">Uncheck to mark as Inactive.</div>
                </div>

            </div><!-- /row -->

            <hr class="my-4">

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save-fill me-1"></i> Save Student
                </button>
                <a href="index.php" class="btn btn-outline-secondary px-4">
                    <i class="bi bi-x-circle me-1"></i> Cancel
                </a>
            </div>

        </form>
    </div>
</div>

<?php
unset($_SESSION['old']);
$conn->close();
?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
