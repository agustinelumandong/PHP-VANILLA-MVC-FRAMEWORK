<!-- // app/Views/errors/404.php -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404 - Page Not Found</title>
  <link rel="stylesheet" href="<?= \App\Core\Helpers::asset('css/bootstrap.min.css') ?>">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= \App\Core\Helpers::asset('css/style.css') ?>">
</head>

<body>
  <div class="error-page">
    <div class="error-code">404</div>
    <div class="error-message">Page Not Found</div>
    <p class="lead mb-4">The page you are looking for doesn't exist or has been moved to a different location.</p>
    <a href="/" class="btn btn-dark error-button">Return Home</a>
  </div>
</body>

</html>