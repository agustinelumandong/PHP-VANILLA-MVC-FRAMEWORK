<footer class="bg-black text-white py-4 mt-5 fixed-bottom ">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6 text-center text-md-start">
        <p class="mb-0 fs-6 fw-light">&copy; <?= date('Y') ?>
          <?= \App\Core\Helpers::env('APP_NAME', 'MVC Framework') ?>. All rights reserved.
        </p>
      </div>
      <!-- <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
        <a href="/" class="text-white text-decoration-none me-3">Home</a>
        <a href="/about" class="text-white text-decoration-none me-3">About</a>
        <a href="/contact" class="text-white text-decoration-none">Contact</a>
      </div> -->
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="<?= \App\Core\Helpers::asset('js/script.js') ?>"></script>
</body>

</html>