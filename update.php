<?php include 'config.php';

$id = $_GET['id'] ?? 0;

// Get existing user
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) { die("User not found."); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    if ($username) {
        if (!empty($password)) {
            // Update with new hashed password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET username = :username, password = :password WHERE id = :id");
            $stmt->execute([
                'username' => $username,
                'password' => $hashedPassword,
                'id' => $id
            ]);
        } else {
            // Update username only, keep existing password
            $stmt = $pdo->prepare("UPDATE users SET username = :username WHERE id = :id");
            $stmt->execute([
                'username' => $username,
                'id' => $id
            ]);
        }
        header("Location: index.php?msg=updated");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
</head>
<body>
    <h1>Edit User</h1>
    <a href="index1.php">← Back to List</a>
    <br><br>

    <form method="post">
        <label>Username:</label><br>
        <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required maxlength="50"><br><br>
        
        <label>New Password (leave blank to keep current):</label><br>
        <input type="password" name="password"><br><br>
        
        <input type="submit" value="Update User">
    </form>
</body>
</html>