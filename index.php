<?php include 'config.php';
$stmt = $pdo->query("SELECT * FROM users ORDER BY id DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>User CRUD App</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f4f4f4; }
        .msg { padding: 10px; margin: 10px 0; border-radius: 4px; }
        .success { background: #d4edda; color: #155724; }
    </style>
</head>
<body>
    <h1>User List</h1>
    <?php if (isset($_GET['msg'])): ?>
        <div class="msg success">Record <?php echo $_GET['msg']; ?> successfully!</div>
    <?php endif; ?>
    <a href="create.php">➕ Add New User</a><br><br>
    <table>
        <tr><th>ID</th><th>Name</th><th>Email</th><th>Created</th><th>Actions</th></tr>
        <?php if (empty($users)): ?>
            <tr><td colspan="5">No users found. Add your first user!</td></tr>
        <?php else: ?>
            <?php foreach ($users as $u): ?>
            <tr>
                <td><?= $u['id'] ?></td>
                <td><?= htmlspecialchars($u['name']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td><?= $u['created_at'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $u['id'] ?>">Edit</a> |
                    <a href="delete.php?id=<?= $u['id'] ?>" onclick="return confirm('Delete this user?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</body>
</html>