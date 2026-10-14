<?php
require 'vendor/autoload.php'; // Load Dompdf

use Dompdf\Dompdf;

// Sanitize input
$name = htmlspecialchars($_POST['name'] ?? 'Student');
$class = htmlspecialchars($_POST['class'] ?? 'N/A');
$amount = htmlspecialchars($_POST['amount'] ?? '0');
$paymentId = htmlspecialchars($_POST['payment_id'] ?? 'Unknown');
$date = date('d M Y, h:i A');

// HTML content
$html = "
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
      font-size: 14px;
    }
    .header {
      text-align: center;
      border-bottom: 2px solid #333;
      margin-bottom: 20px;
    }
    .logo {
      height: 80px;
    }
    .details {
      margin-top: 30px;
    }
    .details p {
      line-height: 1.6;
    }
    .footer {
      text-align: center;
      margin-top: 40px;
      font-style: italic;
      font-size: 12px;
    }
  </style>

  <div class='header'>
    <img src='https://upload.wikimedia.org/wikipedia/commons/thumb/2/28/Graduation_hat.svg/1024px-Graduation_hat.svg.png' class='logo'>
    <h2>AJM English School</h2>
    <h4>Official Fee Payment Receipt</h4>
  </div>

  <div class='details'>
    <p><strong>Student Name:</strong> $name</p>
    <p><strong>Class:</strong> $class</p>
    <p><strong>Amount Paid:</strong> ₹$amount</p>
    <p><strong>Payment ID:</strong> $paymentId</p>
    <p><strong>Date of Payment:</strong> $date</p>
  </div>

  <div class='footer'>
    This is a system-generated receipt. Please keep it safe for future reference.<br>
    &copy; 2025 AJM English School | www.ajmschool.in
  </div>
";

// Generate PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4');
$dompdf->render();

// Output PDF to browser
$dompdf->stream("Receipt_$name.pdf", ["Attachment" => false]);
?>
