<?php 
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize user input
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    // First: Check if the email already exists
    $sql_check = "SELECT * FROM entries WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        // Email already exists, stop execution
        die("Email already exists!");
    }

    // If email doesn't exist, insert the data
    $sql_insert = "INSERT INTO entries (name, email, phone) VALUES (?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("sss", $name, $email, $phone);

    if ($stmt_insert->execute()) {
        echo "<p>Entry added successfully!</p>";
    } else {
        echo "Error: " . $stmt_insert->error;
    }

    // Close statements and connection
    $stmt_check->close();
    $stmt_insert->close();
    $conn->close();
}
?>

     
      ?>
     
<!DOCTYPE html> 
<html lang="en"> 
<head> 
  <meta charset="UTF-8"> 
  <meta name="viewport" content="width=device-width, initial-scale=1"> 
  <title>Form - Your Project Title</title> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    /* Apply ASH background to whole page */
    body {
      background-color: lab(21.92% -8.17 -15.43 / 0.926); 
    }

    .form-container {
      background-color: #e6f7ff61; /* Light blue for the form */
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 0 10px rgb(0, 0, 0);
    }

    .form-control.bg-secondary {
      color: white;
    }
    .btn-secondary{
      background-color:#1a2e40;
      color: #000;
    }
  </style>
</head> 

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark"> 
    <div class="container-fluid"> 
      <a class="navbar-brand" href="#">Library System Management</a> 
      <div> 
        <ul class="navbar-nav"> 
          <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li> 
          <li class="nav-item"><a class="nav-link" href="form.php">Form</a></li> 
          <li class="nav-item"><a class="nav-link" href="about.html">About</a></li> 
          <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li> 
        </ul> 
      </div> 
    </div> 
  </nav> 

  <!-- Form Section -->
  <div class="container mt-5 form-container bg-ligh"> 
    <h2 class="mb-4">Library Entry Form</h2> 
    <form method="POST" action="form.php" onsubmit="return validateForm()"> 
  <div class="mb-3"> 
    <label class="form-label">Name</label> 
    <input type="text" id="name" name="name" class="form-control bg-secondary text-white" placeholder="Enter Name"> 
  </div> 
  <div class="mb-3"> 
    <label class="form-label">Email</label> 
    <input type="email" id="email" name="email" class="form-control bg-secondary text-white" placeholder="Enter Email"> 
  </div> 
  <div class="mb-3"> 
    <label class="form-label">Phone</label> 
    <input type="text" id="phone" name="phone" class="form-control bg-secondary text-white" placeholder="Enter Phone"> 
  </div> 
  <button type="submit" class="btn btn-secondary">Submit</button> 
  <button type="reset" class="btn btn-secondary">Clear Form</button> 
</form> 
  


  <script> 
    function validateForm() { 
      let name = document.getElementById("name").value; 
      let email = document.getElementById("email").value; 
      let phone = document.getElementById("phone").value; 
      
      if (name === "" || email === "" || phone === "") { 
        alert("All fields required!"); 
        return false; 
      } 

      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ 
        die("Invalid email format!");
      } 

      if (phone.length !== 10 || isNaN(phone)) { 
        alert("Phone must be 10 digits!"); 
        return false; 
      } 

        alert("Message submitted successfully!");
        return true;
    }

     
  </script> 
</body> 
</html>