<?php
require_once 'databaseIF.php';

$theId = $_GET['id'];
if (empty($theId)) {
    http_response_code(404);
    exit;
}

try {
    $sQuery = $db->prepare
    ("select l.id as label_id, l.description, l.image_name, im.image, im.image_id from label as l join 
  image as im on im.image_id = l.image_id_fk where l.id = :labelId");
    $sQuery->bindValue(':labelId', $_GET['id']);
    $sQuery->execute();
    $aTemplates = $sQuery->fetchAll();

    if ($sQuery->rowCount() != 1) {
        http_response_code(404);
        exit;
    }

    $arr = array('description' => $aTemplates[0]['description'], 'title' => $aTemplates[0]['image_name'],
        'image' => base64_encode($aTemplates[0]['image']));
    echo  json_encode($arr);

} catch (PDOException $exc) {
    echo "Sorry, system is updating ...";
}

