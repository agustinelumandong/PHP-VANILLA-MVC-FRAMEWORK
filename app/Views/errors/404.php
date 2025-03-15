<!-- // app/Views/errors/404.php -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404 - Page Not Found</title>
  <link rel="stylesheet" href="<?= \App\Core\Helpers::asset('css/bootstrap.min.css') ?>">
  <style>
    body {
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: #f8f9fa;
    }

    .error-container {
      text-align: center;
      padding: 2rem;
    }

    .error-code {
      font-size: 6rem;
      font-weight: bold;
      color: #dc3545;
    }

    .error-message {
      font-size: 1.5rem;
      margin-bottom: 2rem;
    }
  </style>
</head>

<body>
  <div class="error-container">
    <div class="error-code">404</div>
    <div class="error-message">Page Not Found</div>
    <p>The page you are looking for does not exist or has been moved.</p>
    <a href="/" class="btn btn-primary">Go Home</a>
  </div>
</body>

</html>