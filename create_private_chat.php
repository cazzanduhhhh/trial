<?php 
session_start();

if (isset($_SESSION['username'])) {
    include 'app/db.conn.php';
    include 'app/helpers/user.php';

    // Getting User data
    $user = getUser($_SESSION['username'], $conn);

    // Check if user is admin
    if ($user['role'] != 'admin') {
        header("Location: home.php");
        exit;
    }

    // Getting all users except the admin
    $users = getAllUsersExcept($user['user_id'], $conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Private Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="img/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="p-2 w-400 rounded shadow">
        <div class="d-flex mb-3 p-3 bg-light justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <img src="uploads/<?=$user['p_p']?>" class="w-25 rounded-circle">
                <h3 class="fs-xs m-2"><?=$user['name']?></h3> 
            </div>
            <a href="logout.php" class="btn btn-dark">Logout</a>
        </div>
        <h3 class="text-center">Create Private Chat</h3>
        <ul class="list-group mvh-50 overflow-auto">
            <?php if (!empty($users)) { ?>
                <?php foreach ($users as $user) { ?>
                    <li class="list-group-item">
                        <a href="start_chat.php?user_id=<?=$user['user_id']?>" class="d-flex justify
                        justify-content-between align-items-center p-2">
                            <div class="d-flex align-items-center">
                                <img src="uploads/<?=$user['p_p']?>" class="w-10 rounded-circle">
                                <h3 class="fs-xs m-2"><?=$user['name']?></h3>                              
                            </div>
                        </a>
                    </li>
                <?php } ?>
            <?php } else { ?>
                <div class="alert alert-info text-center">
                    <i class="fa fa-users d-block fs-big"></i>
                    No users available
                </div>
            <?php } ?>
        </ul>
    </div>
</body>
</html>
<?php
} else {
    header("Location: index.php");
    exit;
}
?>
