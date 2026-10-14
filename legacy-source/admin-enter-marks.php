<?php
session_start();
if (!isset($_SESSION['admin'])) { header("Location: login.php"); exit(); }

$subjects = [
    "English",
    "Mathematics",
    "Science",
    "MIL",
    "Social Science",
    "Adv.Geography"
];

$class = isset($_REQUEST['class']) ? trim($_REQUEST['class']) : '';
$roll  = isset($_REQUEST['roll']) ? trim($_REQUEST['roll']) : '';
$new   = isset($_REQUEST['new']) && $_REQUEST['new'] == 1;

$data = [];
$jsonFile = $class ? (__DIR__ . "/results_data/class{$class}.json") : '';

if (!$new && $class && file_exists($jsonFile)) {
    $json = json_decode(file_get_contents($jsonFile), true);
    if ($roll && isset($json[$roll])) {
        $data = $json[$roll];
    }
}

function val($k, $d = '') {
    global $data;
    return isset($data[$k]) ? $data[$k] : $d;
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= $new ? 'Add New Student' : "Edit Marks (Class {$class} Roll {$roll})" ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>.mark-input{width:110px}</style>
</head>

<body class="p-4">
<div class="container" style="max-width:980px;">

<h3><?= $new ? '➕ Add New Student' : "✏️ Edit Marks — Class {$class} Roll {$roll}" ?></h3>

<form method="POST" action="save-marks.php">

  <input type="hidden" name="Class" value="<?= htmlspecialchars($class) ?>">
  <input type="hidden" name="New" value="<?= $new ? 1 : 0 ?>">

  <div class="card p-3 mb-3">
    <h5>Basic Details</h5>

    <div class="row g-3">

      <div class="col-md-3">
        <label>Admission</label>
        <input type="text" name="Admission" class="form-control"
               value="<?= htmlspecialchars(val('Admission','')) ?>" required>
      </div>

      <div class="col-md-3">
        <label>Roll</label>
        <input type="text" name="Roll" class="form-control"
               value="<?= htmlspecialchars(val('Roll', $roll)) ?>" required>
      </div>

      <div class="col-md-3">
        <label>Name</label>
        <input type="text" name="Name" class="form-control"
               value="<?= htmlspecialchars(val('Name','')) ?>" required>
      </div>

      <!-- DOB with auto-format -->
      <div class="col-md-3">
        <label>Date of Birth (DD/MM/YYYY)</label>
        <input type="text" id="dob" name="DOB" class="form-control"
               placeholder="DD/MM/YYYY" maxlength="10"
               value="<?= htmlspecialchars(val('DOB','')) ?>" required>
      </div>

    </div>

    <div class="row g-3 mt-2">
      <div class="col-md-3">
        <label>Class</label>
        <select name="ClassVisible" class="form-select" required>
          <?php for ($i=1;$i<=10;$i++): ?>
            <option value="<?= $i ?>" <?= ($class == $i ? 'selected' : '') ?>>
              Class <?= $i ?>
            </option>
          <?php endfor; ?>
        </select>
      </div>
    </div>
  </div>

  <div class="card p-3">
    <h5>Subject Marks (UT1 – UT4)</h5>
    <table class="table table-bordered mt-3">
      <thead>
        <tr><th>Subject</th><th>UT1</th><th>UT2</th><th>UT3</th><th>UT4</th></tr>
      </thead>
      <tbody>
        <?php foreach ($subjects as $sub): ?>
          <tr>
            <td><?= htmlspecialchars($sub) ?></td>
            <?php for ($i=1;$i<=4;$i++):
              $key = "{$sub} UT{$i}";
              $v = val($key, 0);
            ?>
              <td>
                <input class="form-control mark-input" type="number" min="0"
                       name="marks[<?= htmlspecialchars($sub) ?>][UT<?= $i ?>]"
                       value="<?= htmlspecialchars($v) ?>">
              </td>
            <?php endfor; ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="card p-3 mt-3">
    <h5>Totals & Ranks</h5>
    <div class="row g-3">
      <?php for ($i=1;$i<=4;$i++): ?>
        <div class="col-md-3">
          <label>Total <?= $i ?></label>
          <input type="number" name="total<?= $i ?>" class="form-control"
                 value="<?= htmlspecialchars(val("total{$i}",0)) ?>">
        </div>
      <?php endfor; ?>
    </div>

    <div class="row g-3 mt-2">
      <?php for ($i=1;$i<=4;$i++): ?>
        <div class="col-md-2">
          <label>Rank <?= $i ?></label>
          <input type="text" name="Rank<?= $i ?>" class="form-control"
                 value="<?= htmlspecialchars(val("Rank{$i}","")) ?>">
        </div>
      <?php endfor; ?>

      <div class="col-md-4">
        <label>Final Rank</label>
        <input type="text" name="RankFinal" class="form-control"
               value="<?= htmlspecialchars(val("RankFinal","")) ?>">
      </div>
    </div>

    <div class="mt-3">
      <label>Remarks</label>
      <input type="text" name="Remarks" class="form-control"
             value="<?= htmlspecialchars(val("Remarks","")) ?>">
    </div>
  </div>

  <button class="btn btn-success w-100 mt-3">💾 Save Student</button>
</form>

</div>

<script>
// Auto-format DOB: DD-MM-YYYY
document.getElementById("dob").addEventListener("input", function(e) {
    let v = this.value.replace(/\D/g, "");

    if (v.length > 2 && v.length <= 4) {
        this.value = v.slice(0,2) + "/" + v.slice(2);
    } 
    else if (v.length > 4) {
        this.value = v.slice(0,2) + "/" + v.slice(2,4) + "/" + v.slice(4,8);
    } 
    else {
        this.value = v;
    }
});
</script>

</body>
</html>
