<!-- // app/Views/users/show.php -->
<div class="card">
  <div class="card-header">
    <h1><?= $title ?></h1>
  </div>
  <div class="card-body">
    <dl class="row">
      <dt class="col-sm-3">ID</dt>
      <dd class="col-sm-9"><?= $user['id'] ?></dd>

      <dt class="col-sm-3">Name</dt>
      <dd class="col-sm-9"><?= $user['name'] ?></dd>

      <dt class="col-sm-3">Email</dt>
      <dd class="col-sm-9"><?= $user['email'] ?></dd>

      <dt class="col-sm-3">Created At</dt>
      <dd class="col-sm-9"><?= isset($user['created_at']) ? \App\Core\Helpers::formatDate($user['created_at']) : '-' ?>
      </dd>

      <dt class="col-sm-3">Updated At</dt>
      <dd class="col-sm-9"><?= isset($user['updated_at']) ? \App\Core\Helpers::formatDate($user['updated_at']) : '-' ?>
      </dd>
    </dl>

    <div class="mt-3">
      <a href="/users/<?= $user['id'] ?>/edit" class="btn btn-warning">Edit</a>
      <form action="/users/<?= $user['id'] ?>" method="post" class="d-inline"
        onsubmit="return confirm('Are you sure?')">
        <input type="hidden" name="_method" value="DELETE">
        <button type="submit" class="btn btn-danger">Delete</button>
      </form>
      <a href="/users" class="btn btn-secondary">Back to List</a>
    </div>
  </div>
</div>