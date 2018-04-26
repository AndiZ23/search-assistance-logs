<?php
include "AssistanceData.php";

function displayLinks($taskarray){
    $html='<ul>';
    foreach($taskarray as $item){
        $link = $item['link'];
        $title = $item['title'];
        $abstract = $item['abstract'];
        $html .= '<li class="suggest-links"><b><a href='. $link.'>'.$title.'</a></b>'
            . '<p class="snippet">'.$abstract.'</p></li>';
    }
    $html .= '</ul>';
    return $html;
}

function display4LinkAssist($task_items){
    $html = displayLinks($task_items);
    $html = '<h5>People find these are helpful: </h5>'.$html;
    return $html;
}

function printMeDis($medis){
    $html = '<ol>';
    foreach($medis as $medi){
        $html .= '<li><a href="#">'.$medi.'</a></li>';
    }
    $html .= '</ol>';
    return $html;
}

function display4DimensionAssist($taskID){
    $html = '<div class="suggested-methods"><h5>We found different types/methods of the topic:  </h5>';
    $html .= printMeDis($taskID['methods']);
    $html .= '</div><div class="suggested-dimensions"><h5>You may consider the effectiveness in terms of: </h5>';
    $html .= printMeDis($taskID['dimensions']);
    $html .= '</div><div class="suggested-links-D"><h5>You might also find these helpful:</h5>';
    $html .= displayLinks($taskID['items']);
    $html .= '</div>';
    return $html;
}

if($asType ==='D'){
    echo display4DimensionAssist(${$taskID});
} else if($asType ==='L'){
    echo display4LinkAssist(${$taskID}['items']);
} else {
    echo 'No assistance data';
}

?>

