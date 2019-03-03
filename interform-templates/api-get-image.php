<?php
require_once 'databaseIF.php';

$theId = $_GET['id'];
if (empty($theId)) {
    http_response_code(404);
    exit;
}

/**
 * @param PDO $db
 * @param $theId
 * @return array
 */
function findImage(PDO $db, $theId)
{
    $sQuery = $db->prepare
    ("select l.id as label_id, l.description, l.image_name, im.image, im.image_id from label as l join 
  image as im on im.image_id = l.image_id_fk where l.id = :labelId");
    $sQuery->bindValue(':labelId', $theId);
    $sQuery->execute();
    $aTemplates = $sQuery->fetchAll();

    return $aTemplates;
}

/**
 * @param PDO $db
 * @param $theId
 * @return array
 */
function findDescription(PDO $db, $theId) {
    $sQuery = $db->prepare
    ("select l.id as label_id, l.description, l.image_name from label as l where l.id = :labelId");
    $sQuery->bindValue(':labelId', $theId);
    $sQuery->execute();
    $aTemplates = $sQuery->fetchAll();

    return $aTemplates;
}

try {
    $aTemplates = findImage($db, $theId);
    if (count($aTemplates) > 0) {
        $arr = array('description' => $aTemplates[0]['description'], 'title' => $aTemplates[0]['image_name'],
            'image' => base64_encode($aTemplates[0]['image']));
        echo  json_encode($arr);
    }
    else {
        $aTemplates = findDescription($db, $theId);
        if (count($aTemplates) > 0) {
            $arr = array('description' => $aTemplates[0]['description'], 'title' => $aTemplates[0]['image_name']);
            echo  json_encode($arr);
        }
        else {
            http_response_code(404);
        }
    }


} catch (PDOException $exc) {
    echo "Sorry, system is updating ...";
}

