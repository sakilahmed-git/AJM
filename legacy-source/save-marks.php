<?php
session_start();
if (!isset($_SESSION['admin'])) { header("Location: login.php"); exit(); }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: admin-select-student.php'); exit(); }

$class = isset($_POST['Class']) ? trim($_POST['Class']) : '';
if (!$class) { die('Missing class.'); }
$file = __DIR__ . "/results_data/class{$class}.json";

// load existing
$data = file_exists($file) ? (json_decode(file_get_contents($file), true) ?: []) : [];

// gather posted
$roll = isset($_POST['Roll']) ? trim($_POST['Roll']) : '';
if ($roll === '') die('Missing roll.');

$row = $data[$roll] ?? [];

// basic fields
$row['Admission'] = $_POST['Admission'] ?? ($row['Admission'] ?? '');
$row['Roll']      = $roll;
$row['Name']      = $_POST['Name'] ?? ($row['Name'] ?? '');
$row['Remarks']   = $_POST['Remarks'] ?? ($row['Remarks'] ?? '');

// ★★★ SAVE DOB (DD/MM/YYYY and move to end) ★★★
if (isset($_POST['DOB'])) {

    $dob_raw = trim($_POST['DOB']); // Example: 19/11/2006

    // Normalize formats if user types weird input
    $dob = $dob_raw;

    // If someone accidentally enters 2006-11-19 (HTML date conversion)
    if (strpos($dob_raw, "-") !== false) {
        $p = explode("-", $dob_raw);
        if (count($p) === 3) {
            $dob = $p[2] . "/" . $p[1] . "/" . $p[0];
        }
    }

    // Remove old DOB first
    unset($row['DOB']);

    // Append DOB at the END of the array
    $row['DOB'] = $dob;
}

// subjects from posted marks
$marks = $_POST['marks'] ?? [];
$totals = ['total1'=>0,'total2'=>0,'total3'=>0,'total4'=>0];

foreach ($marks as $sub => $uts) {
    for ($i=1;$i<=4;$i++) {
        $key = "{$sub} UT{$i}";
        $val = isset($uts["UT{$i}"]) && $uts["UT{$i}"] !== '' ? intval($uts["UT{$i}"]) : 0;
        $row[$key] = $val;
        $totals["total{$i}"] += $val;
    }
}

// prefer manual totals if typed
for ($i=1;$i<=4;$i++) {
    $tname = "total{$i}";
    if (isset($_POST[$tname]) && $_POST[$tname] !== '') {
        $row[$tname] = is_numeric($_POST[$tname]) ? intval($_POST[$tname]) : $totals[$tname];
    } else {
        $row[$tname] = $totals[$tname];
    }
}

// ranks
for ($i=1;$i<=4;$i++) {
    $rk = "Rank{$i}";
    if (isset($_POST[$rk])) $row[$rk] = $_POST[$rk];
}
if (isset($_POST['RankFinal'])) $row['RankFinal'] = $_POST['RankFinal'];

// store in data and write
$data[$roll] = $row;
$tmp = $file . '.tmp';
if (!is_dir(dirname($file))) mkdir(dirname($file), 0755, true);

if (file_put_contents($tmp, json_encode($data, JSON_PRETTY_PRINT)) !== false) {
    rename($tmp, $file);
    header("Location: admin-select-student.php?class={$class}&status=saved");
    exit();
} else {
    die('Save failed.');
}
?>
