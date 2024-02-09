<?php
include_once('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assume you have a function to process the submitted answers
    $answered_questions = processAnswers($_POST);
    $reason= $_POST['reason'];



    $exam_id = $_POST['exam_id'];
    $student_id = $_POST['student_id'];

    $result =takeExam($answered_questions,$exam_id,$student_id,$reason);
    // Print the result (you can modify this part based on your logic)
       echo $result;
} else {
    // Handle invalid requests
    echo "Invalid request";
}

// Sample function to process answers (replace this with your logic)
function processAnswers($postData) {
    $submittedAnswers = [];

    foreach ($postData as $key => $value) {
        // Check if the key starts with "mcq" (assuming these are your answer keys)
        if (strpos($key, 'mcq') === 0) {
            $questionId = str_replace('mcq', '', $key);
            $submittedAnswers[$questionId] = $value;
        }
    }

    // Return a response (modify this part based on your logic)
    return $submittedAnswers;
}
?>