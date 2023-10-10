<?php
header('Content-Type: application/json');

require 'connection.php';

try {
    $data = array();
    $tableName = "tbl_quiz";
    $query = "SELECT * FROM " . $tableName;
    $result = mysqli_query($db_con, $query);

    $quizId = "";
    $question = "";
    $selectionA = "";
    $selectionB = "";
    $selectionC = "";
    $selectionD = "";
    $quizScore = "";
    $quizImg = "";
    $quizTopicRef = "";

    while($row = mysqli_fetch_assoc($result)) {
        $item = array(
        "quizId" => $quizId,
        "question" => $question,
        "selectionA" => $selectionA,
        "selectionB" => $selectionB,
        "selectionC" => $selectionC,
        "selectionD" => $selectionD,
        "score" => $quizScore,
        "quizImg" => $quizImg,
        "quizTopicRef" => $quizTopicRef,
        );
        
        $item["quizId"] = $row['quiz_id'];
        $item["question"] = $row['quiz_question'];
        $item["selectionA"] = $row['quiz_selectionA'];
        $item["selectionB"] = $row['quiz_selectionB'];
        $item["selectionC"] = $row['quiz_selectionC'];
        $item["selectionD"] = $row['quiz_selectionD'];
        $item["quizScore"] = $row['score']
        $item["quizTopicRef"] = $row['topic_id'];

        $aquery = "SELECT * FROM tbl_quiz_image WHERE quiz_id LIKE ?";
        $stmt = mysqli_prepare($db_con, $aquery);
        $param = $row['quiz_id'];
        mysqli_stmt_bind_param($stmt, "s", $param);
        mysqli_stmt_execute($stmt);
        $result2 = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);

        while($row2 = mysqli_fetch_assoc($result2)) {
            $item["quizImg"] = $row2['image_path'];
        }

        $data[] = $item;
    }                           

    $jsonData = json_encode($data);
    echo $jsonData;
} catch (Exception $e) {
    $response = "$e";
    echo json_encode($response);
}
mysqli_close($db_con)
?>
