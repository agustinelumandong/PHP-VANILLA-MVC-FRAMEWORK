<footer class="bg-black text-white py-4 mt-5 fixed-bottom ">
  <div class="container">
    <div class="row align-items-center">
      <div class="d-flex flex-row align-items-center justify-content-center col-md-6 mb-3 mb-md-0">
        <p class="p-2 mb-0 fs-6 fw-light">&copy; <?= date('Y') ?>
          <?= \App\Core\Helpers::env('APP_NAME', 'MVC Framework') ?>. All rights reserved.
        </p>
        <p class="p-2">Created: <a class="text-white fs-8" href="https://github.com/agustinelumandong">Sean Agustine
            Esparagoza</a>
        </p>
      </div>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="<?= \App\Core\Helpers::asset('js/script.js') ?>"></script>
</body>

</html>