<?php
require '../includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM transactions WHERE user_id = ? AND (type LIKE ? OR description LIKE ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, "%$search%", "%$search%"]);
} else {
    $sql = "SELECT * FROM transactions WHERE user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
}
$transactions = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/AdminLTE/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../assets/AdminLTE/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include 'includes/navbar.php'; ?>
        <?php include 'includes/sidebar.php'; ?>

        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Transactions</h3>
                                    <div class="card-tools">
                                        <form action="index.php" method="GET">
                                            <div class="input-group input-group-sm" style="width: 150px;">
                                                <input type="text" name="search" class="form-control float-right" placeholder="Search" value="<?php echo $search; ?>">
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-default">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Type</th>
                                                <th>Amount</th>
                                                <th>Description</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($transactions as $transaction): ?>
                                            <tr>
                                                <td><?php echo $transaction['id']; ?></td>
                                                <td><?php echo $transaction['type']; ?></td>
                                                <td><?php echo $transaction['amount']; ?></td>
                                                <td><?php echo $transaction['description']; ?></td>
                                                <td><?php echo $transaction['created_at']; ?></td>
                                                <td>
                                                    <a href="edit_transaction.php?id=<?php echo $transaction['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                                    <a href="delete_transaction.php?id=<?php echo $transaction['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script src="../assets/AdminLTE/plugins/jquery/jquery.min.js"></script>
    <script src="../assets/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/AdminLTE/dist/js/adminlte.min.js"></script>
</body>
</html>
