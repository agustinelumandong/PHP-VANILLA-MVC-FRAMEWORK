<!-- // app/Views/users/edit.php -->
<div class="card">
  <div class="card-header">
    <h1><?= $title ?></h1>
  </div>
  <div class="card-body">
    <form method="post" action="/users/<?= $user['id'] ?>">
      <input type="hidden" name="_method" value="PUT">
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= $user['name'] ?>" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?= $user['email'] ?>" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password (leave blank to keep current)</label>
        <input type="password" class="form-control" id="password" name="password">
      </div>
      <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
      </div>
      <button type="submit" class="btn btn-primary">Update User</button>
      <a href="/users" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</div>