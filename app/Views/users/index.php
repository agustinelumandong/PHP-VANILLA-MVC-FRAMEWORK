<!-- // app/Views/users/index.php -->
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1><?= $title ?></h1>
  <a href="/users/create" class="btn btn-primary">Create New User</a>
</div>

<?php if (empty($users)): ?>
  <div class="alert alert-info">No users found.</div>
<?php else: ?>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Created At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $user): ?>
          <tr>
            <td><?= $user['id'] ?></td>
            <td><?= $user['name'] ?></td>
            <td><?= $user['email'] ?></td>
            <td><?= isset($user['created_at']) ? \App\Core\Helpers::formatDate($user['created_at']) : '-' ?></td>
            <td>
              <a href="/users/<?= $user['id'] ?>" class="btn btn-sm btn-info">View</a>
              <a href="/users/<?= $user['id'] ?>/edit" class="btn btn-sm btn-warning">Edit</a>
              <form action="/users/<?= $user['id'] ?>" method="post" class="d-inline"
                onsubmit="return confirm('Are you sure?')">
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>