<?php
header('Content-Type: application/json');

require 'connection.php';

try {
    $data = array();
    $query = "SELECT * FROM tbl_lesson";
    $result = mysqli_query($db_con, $query);

    $subjectId = "";
    $subject = "";

    $item = array(
        "subjectId" => $subjectId,
        "subject" => $subject,
    );

    while (($row = mysqli_fetch_assoc($result))) {
        $item["subjectId"] = $row['lesson_id'];
        $item["subject"] = $row['lesson_name'];
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
