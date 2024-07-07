<?php

function getConversation($user_id, $conn) {
    /**
      Getting all the conversations 
      for current (logged in) user
    **/
    $sql = "SELECT * FROM conversations
            WHERE user_1=? OR user_2=?
            ORDER BY conversation_id DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id, $user_id]);

    if ($stmt->rowCount() > 0) {
        $conversations = $stmt->fetchAll();

        /**
          creating empty array to 
          store the user conversation
        **/
        $user_data = [];
        
        # looping through the conversations
        foreach ($conversations as $conversation) {
            # if conversations user_1 row equal to user_id
            if ($conversation['user_1'] == $user_id) {
                $sql2 = "SELECT * FROM users WHERE user_id=?";
                $stmt2 = $conn->prepare($sql2);
                $stmt2->execute([$conversation['user_2']]);
            } else {
                $sql2 = "SELECT * FROM users WHERE user_id=?";
                $stmt2 = $conn->prepare($sql2);
                $stmt2->execute([$conversation['user_1']]);
            }

            $allConversations = $stmt2->fetchAll();

            # pushing the data into the array 
            array_push($user_data, $allConversations[0]);
        }

        return $user_data;

    } else {
        $conversations = [];
        return $conversations;
    }
}

function getConversationBetweenUsers($user1_id, $user2_id, $conn) {
    $sql = "SELECT * FROM conversations 
            WHERE (user1_id = ? AND user2_id = ?)
            OR (user1_id = ? AND user2_id = ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user1_id, $user2_id, $user2_id, $user1_id]);
    return $stmt->fetch();
}

function createConversation($user1_id, $user2_id, $conn) {
    $sql = "INSERT INTO conversations (user1_id, user2_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user1_id, $user2_id]);
}
