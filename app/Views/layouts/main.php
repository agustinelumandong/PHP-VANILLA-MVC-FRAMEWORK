<!-- // app/Views/layouts/main.php -->
<?php include __DIR__ . '/header.php'; ?>

<body>

  <?php include __DIR__ . '../include/navbar.php'; ?>

  <div class="container mt-4">
    <?php if (isset($_SESSION['success'])): ?>
      <div class="alert alert-success">
        <?= $_SESSION['success'] ?>
        <?php unset($_SESSION['success']) ?>
      </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
      <div class="alert alert-danger">
        <?= $_SESSION['error'] ?>
        <?php unset($_SESSION['error']) ?>
      </div>
    <?php endif; ?>

    <!-- This is content -->
    <?= $content ?>

  </div>

  <?php include __DIR__ . '/footer.php'; ?>