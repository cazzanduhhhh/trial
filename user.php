<?php  

function getAllUsersExcept($user_id, $conn) {
        $sql = "SELECT * FROM users WHERE user_id != ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    }

    function getUser($username, $conn) {
        $sql = "SELECT * FROM users WHERE username=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username]);
    
        if ($stmt->rowCount() === 1) {
            return $stmt->fetch();
        } else {
            return null;
        }
    }
    
    function getUserById($user_id, $conn) {
        $sql = "SELECT * FROM users WHERE user_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$user_id]);
    
        if ($stmt->rowCount() === 1) {
            return $stmt->fetch();
        } else {
            return null;
        }
    }
