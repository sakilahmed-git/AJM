handler: function (response) {
  // Send details to PHP
  const form = document.createElement('form');
  form.method = 'POST';
  form.action = 'receipt.php';

  const fields = {
    payment_id: response.razorpay_payment_id,
    amount: 500, // Or the amount paid
    name: document.getElementById('studentName').value,
    class: document.getElementById('studentClass').value
  };

  for (const key in fields) {
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = key;
    input.value = fields[key];
    form.appendChild(input);
  }

  document.body.appendChild(form);
  form.submit();
}
