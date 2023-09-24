<?php
header('Content-Type: application/json');

require 'connection.php';

try {
    $data = array();
    $query = "SELECT * FROM tbl_lesson";
    $result = mysqli_query($db_con, $query);

    $aquery = "SELECT CAST(SUBSTRING(lesson_id, 5) AS UNSIGNED) AS topic_reference FROM tbl_lesson WHERE lesson_id LIKE ?;";
    $stmt = mysqli_prepare($db_con, $aquery);
    $param = "LSN%";
    mysqli_stmt_bind_param($stmt, "s", $param);
    mysqli_stmt_execute($stmt);
    $result2 = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);    

    while (($row = mysqli_fetch_assoc($result)) && ($row2 = mysqli_fetch_assoc($result2))) {
        $subjectId = $row['lesson_id'];
        $subject = $row['lesson_name'];
        $topicRef = $row2['topic_reference'];
        
        $cleanedLsnId= str_replace("LSN", "", $topicRef);

        $bquery = "SELECT * FROM tbl_topic WHERE topic_id LIKE ?";
        $stmt = mysqli_prepare($db_con, $bquery);
        $param = "%TPC-ID" . $cleanedLsnId . "%";
        mysqli_stmt_bind_param($stmt, "s", $param);
        mysqli_stmt_execute($stmt);
        $result3 = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        
        while (($row3 = mysqli_fetch_assoc($result3))) {
            $topicId = $row3['topic_id'];
            $topic = $row3['topic_title'];
            $imageId = $row3['image_id'];
            $audioId = $row3['audio_id'];
            $videoId = $row3['video_id'];
    
            $kTopic = "";
            $fTopic = "";
            $eTopic = "";

            $item = array(
                "subjectId" => $subjectId,
                "subject" => $subject,
                "topicId" => $topicId,
                "topic" => $topic,
                "kTopic" => $kTopic,
                "fTopic" => $fTopic,
                "eTopic" => $eTopic,
                "imagePath" => $imageId,
                "videoPath" => $videoId,
            );

            $fquery = "SELECT * FROM tbl_language WHERE topic_id LIKE ?;";
            $stmt = mysqli_prepare($db_con, $fquery);
            $param = "%" . $topicId . "%";
            mysqli_stmt_bind_param($stmt, "s", $param);
            mysqli_stmt_execute($stmt);
            $result7 = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);

            while($row7 = mysqli_fetch_assoc($result7)) {
                $item["kTopic"] = $row7['kalagan'];
                $item["fTopic"] = $row7['filipino'];
                $item["eTopic"] = $row7['english'];
            }
    
            if ($imageId != null) {
                $cquery = "SELECT * FROM tbl_image WHERE image_id LIKE ?;";
                $stmt = mysqli_prepare($db_con, $cquery);
                $param = "%" . $imageId . "%";
                mysqli_stmt_bind_param($stmt, "s", $param);
                mysqli_stmt_execute($stmt);
                $result4 = mysqli_stmt_get_result($stmt);
                mysqli_stmt_close($stmt);
    
                while ($row4 = mysqli_fetch_assoc($result4)) {
                    $item["imagePath"] = $row4['image_name'];
                }
            }
    
            if ($videoId != null) {
                $equery = "SELECT * FROM tbl_video WHERE video_id LIKE ?;";
                $stmt = mysqli_prepare($db_con, $equery);
                $param = "%" . $videoId . "%";
                mysqli_stmt_bind_param($stmt, "s", $param);
                mysqli_stmt_execute($stmt);
                $result6 = mysqli_stmt_get_result($stmt);
                mysqli_stmt_close($stmt);
    
                while ($row6 = mysqli_fetch_assoc($result6)) {
                    $item["videoPath"] = $row6['video_path'];
                }
            }
    
            $data[] = $item;
        }    
        if($row3 = mysqli_fetch_assoc($result3) == null) {
            $topicId = "";
            $topic = "";
            $kTopic = "";
            $fTopic = "";
            $eTopic = "";
            $imagePath = "";
            $videoPath = "";
            $item = array(
                "subjectId" => $subjectId,
                "subject" => $subject,
                "topicId" => $topicId,
                "topic" => $topic,
                "kTopic" => $kTopic,
                "fTopic" => $fTopic,
                "eTopic" => $eTopic,
                "imagePath" => $imagePath,
                "videoPath" => $videoPath,
            );
            $data[] = $item;
        }
        
        

    }

    $jsonData = json_encode($data);
    echo $jsonData;
} catch (Exception $e) {
    $response = "Failed to retrieve data";
    echo json_encode($response);
}
mysqli_close($db_con)
?>