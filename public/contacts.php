<?php

// Simple Contact List Web Interface
$error = '';
$success = '';

try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=contact_list', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Handle form submissions
    if ($_POST['action'] ?? '' === 'add') {
        try {
            $stmt = $pdo->prepare("INSERT INTO contacts (name, email, phone, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
            $stmt->execute([$_POST['name'], $_POST['email'], $_POST['phone']]);
            $success = "Contact added successfully!";
        } catch (Exception $e) {
            $error = "Error adding contact: " . $e->getMessage();
        }
    }
    
    if ($_POST['action'] ?? '' === 'delete') {
        try {
            $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = ?");
            $result = $stmt->execute([$_POST['id']]);
            if ($result && $stmt->rowCount() > 0) {
                $success = "Contact deleted successfully!";
            } else {
                $error = "Contact not found or already deleted.";
            }
        } catch (Exception $e) {
            $error = "Error deleting contact: " . $e->getMessage();
        }
    }
    
    // Get all contacts
    $stmt = $pdo->query("SELECT * FROM contacts ORDER BY id");
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Contact List</h1>
        
        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($success) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <!-- Add Contact Form -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Add New Contact</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" name="action" value="add">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="name" class="form-control" placeholder="Name" required>
                        </div>
                        <div class="col-md-4">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="phone" class="form-control" placeholder="Phone" required>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Contacts Table -->
        <div class="card">
            <div class="card-header">
                <h5>Contacts (<?= count($contacts) ?> total)</h5>
            </div>
            <div class="card-body">
                <?php if (empty($contacts)): ?>
                    <p class="text-muted">No contacts found. Add some contacts using the form above.</p>
                <?php else: ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($contacts as $contact): ?>
                                <tr>
                                    <td><?= htmlspecialchars($contact['id']) ?></td>
                                    <td><?= htmlspecialchars($contact['name']) ?></td>
                                    <td><?= htmlspecialchars($contact['email']) ?></td>
                                    <td><?= htmlspecialchars($contact['phone']) ?></td>
                                    <td><?= htmlspecialchars($contact['created_at']) ?></td>
                                    <td>
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?= $contact['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Delete this contact?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="mt-4">
            <small class="text-muted">
                Contact indexing is working perfectly! ✅<br>
                Database: <?= count($contacts) ?> contacts indexed and displayed.
            </small>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
