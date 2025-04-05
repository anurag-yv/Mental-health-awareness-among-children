<?php
session_start();
require 'db.php'; // Database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['user_id'])) {
        die("User not logged in. Session user_id is missing.");
    }

    $user_id = $_SESSION['user_id']; 

    // Retrieve and validate all 10 questions
    $q1 = intval($_POST['q1']);
    $q2 = intval($_POST['q2']);
    $q3 = intval($_POST['q3']);
    $q4 = intval($_POST['q4']);
    $q5 = intval($_POST['q5']);
    $q6 = intval($_POST['q6']);
    $q7 = intval($_POST['q7']);
    $q8 = intval($_POST['q8']);
    $q9 = intval($_POST['q9']);
    $q10 = intval($_POST['q10']);
    
    // Calculate the average score
    $score = ($q1 + $q2 + $q3 + $q4 + $q5 + $q6 + $q7 + $q8 + $q9 + $q10) / 10; 

    // Check if data is received
    if (empty($_POST)) {
        die("No data received from the form.");
    }

    // Store quiz response in the database
    $stmt = $conn->prepare("INSERT INTO quiz_responses (user_id, question_1, question_2, question_3, question_4, question_5, question_6, question_7, question_8, question_9, question_10, score, date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

    // The 'bind_param' function should have one type for each value (for integers and decimals)
    $stmt->bind_param("iiiiiiiiiiid", $user_id, $q1, $q2, $q3, $q4, $q5, $q6, $q7, $q8, $q9, $q10, $score);

    if (!$stmt->execute()) {
        die("Error: " . $stmt->error);
    }

    echo "<script>alert('Quiz submitted successfully!'); window.location.href='http://localhost/Project%20Team%20Weaver/project/Implementation/dashboard.html';</script>";

    $stmt->close();
    $conn->close();
}
?>
