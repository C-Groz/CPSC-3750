<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CPSC 3750 Website</title>
</head>
<body>
  <script>
    fetch("navbar.html")
      .then(response => response.text())
      .then(data => document.body.insertAdjacentHTML("afterbegin", data));
  </script>  

<?php 
    echo 'Hello World'; 
?>

</body>
</html>
