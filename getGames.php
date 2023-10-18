<?php
header('Content-Type: application/json');

require 'connection.php';

try {
    $data = array();
    $tableName = "tbl_games";
    $query = "SELECT * FROM " . $tableName;
    $result = mysqli_query($db_con, $query);

    $gameId = "";
    $answer = "";
    $question = "";
    $hint = "";
    $type = "";
    $imagePath1 = "";
    $imagePath2 = "";
    $audioPath = "";

    while($row = mysqli_fetch_assoc($result)) {
        $item = array(
        "gameId" => $gameId,
        "answer" => $answer,
        "question" => $question,
        "hint" => $hint,
        "type" => $type,
        "imagePath1" => $imagePath1,
        "imagePath2" => $imagePath2,
        "audioPath" => $audioPath,
        );
        
        $item["gameId"] = $row['games_id'];
        $item["answer"] = $row['answer'];
        $item["question"] = $row['description'];
        $item["hint"] = $row['hint'];
        $item["type"] = $row['type'];
        $item["imagePath1"] = $row['image_path_1'];
        $item["imagePath2"] = $row['image_path_2'];
        $item["audioPath"] = $row['audio_path'];

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
