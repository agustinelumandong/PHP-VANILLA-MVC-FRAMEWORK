<nav class="navbar navbar-expand-lg bg-white border-bottom py-3">
  <div class="container">
    <a class="navbar-brand fw-bold" href="/"><?= \App\Core\Helpers::env('APP_NAME', 'MVC Framework') ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="/">Home</a>
        </li>
        <?php if (App\Core\Auth::check()): ?>
          <li class="nav-item">
            <a class="nav-link" href="/contact">Contact</a>
          </li>
          <?php if (App\Core\Auth::isAdmin()): ?>
            <li class="nav-item">
              <a class="nav-link" href="/users">Users</a>
            </li>
          <?php endif; ?>
          <li class="nav-item">
            <a class="nav-link" href="/logout">logout</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="/login">LogIn</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/register">Register</a>
          </li>
        <?php endif; ?>

      </ul>
    </div>
  </div>
</nav>