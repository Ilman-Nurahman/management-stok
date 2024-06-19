<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <link rel="stylesheet" href="./css/login.css" />
  <title>Login - Management Stok</title>
</head>

<body>
  <?php
  require_once('config/connection.php');
  require_once('config/helper.php');
  require_once('config/services.php');

  $errorMessage = '';

  // Function to generate a random token
  function generateToken()
  {
    return bin2hex(random_bytes(16));
  }

  // Fetch email and password from form submission
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Authenticate user
    if ($email && $password) {
      $isValidLogin = authenticateUser($email, $password);

      if ($isValidLogin) {
        // Generate token
        $token = generateToken();

        // // Save token in the database

        $query = "UPDATE user SET token = ? WHERE email = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ss', $token, $email);
        mysqli_stmt_execute($stmt);

        // Set token in a cookie
        setcookie("auth_token", $token, time() + (86400 * 30), "/"); // 86400 = 1 day

        // Redirect to dashboard or show a success message
        header('Location: dashboard.php');
        exit;
      } else {
        // Show an error message
        $errorMessage = "Invalid email or password.";
      }
    } else {
      // Show an error message if email or password is not provided
      $errorMessage = "Please enter your email and password.";
    }
  }
  ?>
  <!-- UI CODE -->
  <div class="page-header">
    <!-- background-stok -->
    <div class="d-flex justify-content-end mx-5" style="margin-top: 5%">
      <img src="./assets/background-stok.png" style="position: absolute" alt="background-stok" width="50%" class="img-zoom" />
    </div>
    <div class="container">
      <div class="h-100" style="margin-top: 7%">
        <div class="col-xl-4 col-lg-5 col-md-7 my-auto">
          <div class="card">
            <div class="card-header pt-4">
              <h4 class="mt-6 text-center">
                Selamat Datang di
                <br />Aplikasi Management Stok
              </h4>
              <p class="mb-4 text-lead text-black text-center">
                Login untuk masuk ke dalam aplikasi
              </p>
              <?php
              if ($errorMessage) {
                echo '<div class="alert alert-danger" role="alert">' . $errorMessage . '</div>';
              }
              ?>
              <form action="login.php" method="post" id="loginForm">
                <div class="mb-3">
                  <label for="inputEmail" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email" placeholder="Masukkan Email" name="email" required />
                </div>
                <div class="mb-3">
                  <label for="inputPassword" class="form-label">Password</label>
                  <input type="password" class="form-control" id="pw" placeholder="Masukkan Password" name="password" required />
                </div>
                <div class="d-flex text-center">
                  <button type="submit" class="btn btn-primary w-100 my-4 mb-2">Login</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous" />
  <script>
  </script>
</body>

</html>