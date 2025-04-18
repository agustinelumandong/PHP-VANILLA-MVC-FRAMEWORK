<!-- // app/Views/layouts/main.php -->
<?php include __DIR__ . '/header.php'; ?>

<body>

  <?php include __DIR__ . '../include/navbar.php'; ?>

  <div class="container mt-4">
    <!-- This is content -->
    <?= $content ?>
  </div>

  <!-- Toast Container for Session Messages -->
  <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <!-- Success Toast -->
    <div id="successToast" class="toast border-dark success hide" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header bg-white">
        <i class="bi bi-check-circle-fill text-success me-2"></i>
        <strong class="me-auto">Success</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
        <?php if (isset($_SESSION['success'])): ?>
          <?= $_SESSION['success'] ?>
          <?php unset($_SESSION['success']) ?>
        <?php endif; ?>
      </div>
    </div>

    <!-- Error Toast -->
    <div id="errorToast" class="toast border-dark danger hide" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header bg-white">
        <i class="bi bi-exclamation-circle-fill text-danger me-2"></i>
        <strong class="me-auto">Error</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
        <?php if (isset($_SESSION['error'])): ?>
          <?= $_SESSION['error'] ?>
          <?php unset($_SESSION['error']) ?>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <?php include __DIR__ . '/footer.php'; ?>