<?php
ob_start(); 

// ----------------------
// THEMED ERROR FUNCTION
// ----------------------
function themed_error($msg) {
    echo "
    <html>
    <head>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
        <style>
            body { background:#f5f9ff; font-family:'Inter',sans-serif; }
            .box {
                max-width:600px; margin:80px auto; padding:30px;
                background:white; border-radius:12px;
                box-shadow:0 4px 12px rgba(0,0,0,0.1);
                text-align:center;
            }
            h3 { font-family:'Poppins',sans-serif; color:#1a2980; }
        </style>
    </head>
    <body>
        <div class='box'>
            <h3>⚠ Error</h3>
            <p class='mt-2 fs-5 text-secondary'>$msg</p>
            <a href='results.php' class='btn btn-primary mt-3'>Go Back</a>
        </div>
    </body>
    </html>";
    exit;
}

// ----------------------
// INPUTS FROM FORM
// ----------------------
if (!isset($_POST['roll']) || !isset($_POST['class'])) {
    themed_error("Invalid request. Please select class and roll number.");
}

$roll  = trim($_POST['roll']);
$class = intval($_POST['class']);

// ----------------------
// LOAD JSON FILE
// ----------------------
$file = "results_data/class{$class}.json";

if (!file_exists($file)) {
    themed_error("No results found for Class $class.");
}

$data = json_decode(file_get_contents($file), true);

if (!isset($data[$roll])) {
    themed_error("Roll $roll not found in Class $class.");
}

$student = $data[$roll];

// ----------------------
// DOB VALIDATION
// ----------------------
$inputDob  = trim($_POST['dob'] ?? '');
$storedDob = trim($student['DOB'] ?? '');

if ($storedDob === '') themed_error("DOB not available for this student. Contact admin.");
if ($inputDob === '') themed_error("Please enter your DOB.");
if ($inputDob !== $storedDob) themed_error("❌ Incorrect Date of Birth entered.");

// ----------------------
// BASIC DETAILS
// ----------------------
$name      = $student['Name']      ?? '';
$admission = $student['Admission'] ?? '—';
$dob       = $student['DOB']       ?? '—';

// ----------------------
// DETECT SUBJECTS
// ----------------------
$subjects = [];
foreach ($student as $key => $val) {
    if (preg_match('/^(.+?)\s+UT1$/i', $key, $m)) {
        $subjects[] = $m[1];
    }
}

// ----------------------
// START MARKSHEET HTML
// ----------------------
?>
<!DOCTYPE html>
<html>
<head>
    <title>Marksheet - Class <?= $class ?> Roll <?= $roll ?></title>

<style>
body {
    font-family: 'Segoe UI', sans-serif;
    font-size: 13px;
    margin: 30px;
}
h1, h3 { text-align: center; }
.school-name { color: #0d47a1; font-size: 22px; font-weight: bold; }

table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 15px;
}
th, td {
    border: 1px solid #444;
    padding: 6px;
    text-align: center;
}
.noborder td {
    border: none;
    text-align: left;
}
.highlight {
    background: #f3f3f3;
    font-weight: bold;
}

.print-btn {
    margin: 20px auto;
    display: block;
    padding: 10px 20px;
    background: #1a73e8;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
}

@media print {
    .print-btn { display: none; }
    body { margin: 0; }
}
</style>

</head>
<body>

<h1 class="school-name">A.J.M. ENGLISH SCHOOL</h1>
<h3>REPORT CARD</h3>

<table class="noborder">
  <tr>
    <td>Name:</td><td><strong><?= $name ?></strong></td>
    <td>Admission No.</td><td><?= $admission ?></td>
    <td>Roll No:</td><td><strong><?= $roll ?></strong></td>
  </tr>
  <tr>
    <td>Class:</td><td><?= $class ?></td>
    <td>Date of Birth:</td><td><?= $dob ?></td>
    <td>Session:</td><td>2025–2026</td>
  </tr>
</table>

<table>
  <tr class="highlight">
    <th rowspan="2">Subject</th>
    <th colspan="2">A</th>
    <th colspan="2">B</th>
    <th colspan="2">C</th>
    <th colspan="2">D</th>
    <th rowspan="2">Total</th>
  </tr>
  <tr class="highlight">
    <th>1st Term</th><th>20%</th>
    <th>2nd Term</th><th>30%</th>
    <th>3rd Term</th><th>20%</th>
    <th>4th Term</th><th>30%</th>
  </tr>

<?php
$totals = ['UT1'=>0, 'UT2'=>0, 'UT3'=>0, 'UT4'=>0, 'TOTAL'=>0];

$sumA = $sumB = $sumC = $sumD = 0;

foreach ($subjects as $subj) {

    $ut1 = intval($student["$subj UT1"] ?? 0);
    $ut2 = intval($student["$subj UT2"] ?? 0);
    $ut3 = intval($student["$subj UT3"] ?? 0);
    $ut4 = intval($student["$subj UT4"] ?? 0);

    $a = round($ut1 * 0.2, 1);
    $b = round($ut2 * 0.3, 1);
    $c = round($ut3 * 0.2, 1);
    $d = round($ut4 * 0.3, 1);

    $sumA += $a;  
    $sumB += $b;
    $sumC += $c;
    $sumD += $d;

    $total = $ut1 + $ut2 + $ut3 + $ut4;

    $totals['UT1'] += $ut1;
    $totals['UT2'] += $ut2;
    $totals['UT3'] += $ut3;
    $totals['UT4'] += $ut4;
    $totals['TOTAL'] += $total;

    echo "
    <tr>
        <td>$subj</td>
        <td>$ut1</td><td>$a</td>
        <td>$ut2</td><td>$b</td>
        <td>$ut3</td><td>$c</td>
        <td>$ut4</td><td>$d</td>
        <td>$total</td>
    </tr>";
}
?>

<tr class="highlight">
    <td><strong>Marks Obtained</strong></td>

    <td><?= $totals['UT1'] ?></td><td><?= $sumA ?></td>
    <td><?= $totals['UT2'] ?></td><td><?= $sumB ?></td>
    <td><?= $totals['UT3'] ?></td><td><?= $sumC ?></td>
    <td><?= $totals['UT4'] ?></td><td><?= $sumD ?></td>

    <td><strong><?= $totals['TOTAL'] ?></strong></td>
</tr>

<tr class="highlight">
    <td><strong>Rank</strong></td>

    <td colspan="2"><?= $student['Rank1'] ?></td>
    <td colspan="2"><?= $student['Rank2'] ?></td>
    <td colspan="2"><?= $student['Rank3'] ?></td>
    <td colspan="2"><?= $student['Rank4'] ?></td>

    <td><strong><?= $student['RankFinal'] ?></strong></td>
</tr>
</table>
    <table class='footer noborder'>
  <tr><td>Principal:</td><td>___________________</td></tr>
</table>


<button class="print-btn" onclick="window.print();">🖨️ Print / Download PDF</button>

</body>
</html>
