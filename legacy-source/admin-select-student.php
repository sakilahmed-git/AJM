<?php
session_start();
if (!isset($_SESSION['admin'])) { header("Location: login.php"); exit(); }

function get_class_file($class) {
    return __DIR__ . "/results_data/class{$class}.json";
}

$classes = range(1, 10);
$selectedClass = $_GET['class'] ?? '';
$students = [];

if ($selectedClass && is_numeric($selectedClass)) {
    $file = get_class_file(intval($selectedClass));
    if (file_exists($file)) {
        $json = json_decode(file_get_contents($file), true);
        if (is_array($json)) {
            foreach ($json as $roll => $row) {
                $name = $row['Name'] ?? $row['name'] ?? 'Unknown';
                $students[$roll] = "{$roll} - {$name}";
            }
        }
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Select Student — Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body { background:#f5f9ff; }
    .box {
        background:white;
        padding:25px;
        border-radius:12px;
        box-shadow:0 3px 12px rgba(0,0,0,0.12);
    }
    h3 { font-weight:600; }
  </style>
</head>

<body class="p-2 p-md-4">

<div class="container" style="max-width:820px;">

    <div class="box">

        <h3 class="mb-3 text-center text-md-start">📘 Select Class & Student</h3>

        <form method="GET" class="row g-3">

            <!-- Select Class -->
            <div class="col-12 col-md-4">
                <label class="form-label">Class</label>
                <select name="class" class="form-select" onchange="this.form.submit()">
                    <option value="">Select Class</option>
                    <?php foreach ($classes as $c): ?>
                        <option value="<?= $c ?>" <?= ($selectedClass == $c ? 'selected' : '') ?>>
                            Class <?= $c ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Select Student Roll -->
            <div class="col-12 col-md-5">
                <label class="form-label">Student (Roll)</label>
                <select name="roll" class="form-select" <?= empty($students) ? 'disabled' : '' ?> required>
                    <option value="">
                        <?= empty($students) ? 'No students — add first' : 'Select Roll' ?>
                    </option>
                    <?php foreach ($students as $roll => $label): ?>
                        <option value="<?= htmlspecialchars($roll) ?>"><?= htmlspecialchars($label) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Button -->
            <div class="col-12 col-md-3 d-grid">
                <button formaction="admin-enter-marks.php"
                        class="btn btn-primary"
                        <?= empty($students) ? 'disabled' : '' ?>>
                    Edit Marks
                </button>
            </div>

        </form>

        <div class="mt-3 d-grid d-md-block">
            <a href="admin-enter-marks.php?new=1&class=<?= htmlspecialchars($selectedClass ?: '') ?>"
               class="btn btn-success w-100 w-md-auto">
                ➕ Add New Student
            </a>
        </div>

        <?php if ($selectedClass && empty($students)): ?>
            <div class="alert alert-warning mt-3">
                No students found in Class <?= htmlspecialchars($selectedClass) ?>.
                Click <strong>Add New Student</strong> to create the first entry.
            </div>
        <?php endif; ?>

        <hr class="my-4">

        <p class="text-muted small text-center">
            JSON files stored in <code>results_data/</code><br>
            Example: <code>class1.json</code>, <code>class5.json</code>
        </p>

    </div>

</div>

</body>
</html>
