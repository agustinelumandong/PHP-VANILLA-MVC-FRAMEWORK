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
  <style>
    body {
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: #ffffff;
      font-family: 'Inter', sans-serif;
      color: #111827;
    }

    .error-container {
      text-align: center;
      padding: 3rem;
      max-width: 32rem;
      opacity: 0;
      animation: fadeIn 0.5s ease-out forwards;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .error-code {
      font-size: 7.5rem;
      font-weight: 700;
      line-height: 1;
      letter-spacing: -0.05em;
      color: #111827;
      margin-bottom: 1.5rem;
    }

    .error-message {
      font-size: 2rem;
      font-weight: 600;
      margin-bottom: 1.5rem;
      color: #111827;
    }

    p {
      font-size: 1.125rem;
      color: #4B5563;
      margin-bottom: 2rem;
      line-height: 1.75;
    }

    .btn {
      display: inline-flex;
      align-items: center;
      background-color: #111827;
      color: #ffffff;
      font-weight: 500;
      padding: 0.875rem 2rem;
      border-radius: 0.5rem;
      transition: all 0.2s ease;
      text-decoration: none;
      border: 2px solid #111827;
    }

    .btn:hover {
      background-color: #ffffff;
      color: #111827;
    }
  </style>
</head>

<body>
  <div class="error-container">
    <div class="error-code">404</div>
    <div class="error-message">Page Not Found</div>
    <p>The page you are looking for doesn't exist or has been moved to a different location.</p>
    <a href="/" class="btn">Return Home</a>
  </div>
</body>

</html>