<?php
session_start();

if (isset($_SESSION['username']) && isset($_GET['user_id'])) {
    include 'app/db.conn.php';
    include 'app/helpers/user.php';
    include 'app/helpers/conversations.php';

    // Getting User data
    $user = getUser($_SESSION['username'], $conn);

    // Check if user is admin
    if ($user['role'] != 'admin') {
        header("Location: home.php");
        exit;
    }

    $user_id = $_GET['user_id'];

    // Check if a conversation already exists
    $conversation = getConversationBetweenUsers($user['user_id'], $user_id, $conn);

    if ($conversation == null) {
        // If conversation does not exist, create a new one
        createConversation($user['user_id'], $user_id, $conn);
    }

    header("Location: chat.php?user=$user_id");
    exit;
} else {
    header("Location: home.php");
    exit;
}