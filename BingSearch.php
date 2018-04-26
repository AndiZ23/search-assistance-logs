<?php

require "./getSearchResult.php";

function getAssistType ($pid, $tid) {
    /*
     * Tell the page what type of assistant tool should be shown.
     * Decided by participant id and task id.
     */
    $tasklist = array(
        "p1-4" => array(
            "t1" => "L",
            "t2" => "L",
            "t3" => "D",
            "t4" => "D"
        ),
        "p5-8" => array(
            "t1" => "D",
            "t2" => "D",
            "t3" => "L",
            "t4" => "L"
        )
    );

    $atype = "-";
    if (in_array($pid,array('1','2','3','4'))) { $atype = $tasklist["p1-4"][$tid]; }
    else if (in_array($pid, array('5','6','7','8'))) { $atype = $tasklist["p5-8"][$tid];}

    return $atype;
}

function getTask($pid, $tid){
    $taskOrders = array(
        '1' => array(
            't1'=>'c1',
            't2'=>'e1',
            't3'=>'c2',
            't4'=>'e2'),
        '2' => array(
            't1'=>'c2',
            't2'=>'e2',
            't3'=>'e1',
            't4'=>'c1',
        ),
        '3' => array(
            't1'=>'e2',
            't2'=>'c2',
            't3'=>'c1',
            't4'=>'e1',
        ),
        '4' => array(
            't1'=>'e1',
            't2'=>'c1',
            't3'=>'e2',
            't4'=>'c2',
        ),
        '5' => array(
            't1'=>'c1',
            't2'=>'e2',
            't3'=>'c2',
            't4'=>'e1',
        ),
        '6' => array(
            't1'=>'c2',
            't2'=>'e1',
            't3'=>'e2',
            't4'=>'c1',
        ),
        '7' => array(
            't1'=>'e1',
            't2'=>'c2',
            't3'=>'c1',
            't4'=>'e2',
        ),
        '8' => array(
            't1'=>'e2',
            't2'=>'c1',
            't3'=>'e1',
            't4'=>'c2',
        )
    );
    $taskID = 'task_'.$taskOrders[$pid][$tid];
    return $taskID;
}

if (isset($_GET['pid']) && isset($_GET['tid'])) {
    $pid = $_GET['pid']; $tid = $_GET['tid'];
    // the search box only shows if pid and tid are set.
?>
<html>
    <head>
        <link rel="stylesheet" href="./style.css">
    </head>
    <body>
        <header class="searchbox">
            <h3>Search from Bing </h3>
            <form id='searchform' method='GET' action='BingSearch.php'>
                <input type="hidden" name="pid" value="<?php echo $pid;?>">
                <input type="hidden" name="tid" value="<?php echo $tid;?>">
                <input type='text' name='query' placeholder="Put your query here.">
                <input type='submit' value='Search'>
            </form>
        </header>

        <div id="main">
            <div class="search-results">
<?php
}

if(isset($_GET['query'])) {
    $term = $_GET['query'];

    if (strlen($accessKey) == 32) {

    echo "<span>Searching the Web for: <b>" . $term . "</b></span>";

    list($headers, $json) = BingWebSearch($endpoint, $accessKey, $term);
    $result = json_decode($json, true);

    echo '<ul class="result-list">';
    $rid = 0;
    foreach ($result['webPages']['value'] as $webPage) {
        $rid++;
        $title = $webPage['name'];
        $url = $webPage['url'];
        $snippet = $webPage['snippet'];
        ?>
        <li id="<?php echo $rid; ?>" class="result-item">
            <h3 class="title"><a href="<?php echo $url; ?>">
                    <?php echo $title; ?>
                </a></h3>
            <span class="link"><?php echo $url; ?></span>
            <p class="snippet"><?php echo $snippet; ?></p>
        </li>
<?php
    }
    echo '</ul>';
?>
            </div>
<?php
    /*
     * Assist-type will be decided by pid and tid.
     * "D": show .dimension assistant (will be post by ajax to .dimension div)
     * "L", show .link-suggest assistant
     */

    $asType = getAssistType($pid, $tid);  // "D" or "L"

    $taskID = getTask($pid, $tid);
?>
            <div class="assistant"> <!-- "dimension" will be given by a php $variable -->
                <div id="search-assistant">
                    <?php
                      include "Assistance.php";
                    ?>
                </div>
                <div class="assistant-cover">
                    <p>You may find something's <b><i>helpful</i></b> here.</p>
                </div>

                <div id="showlogs" style="display: none;">
                    <h4>*logs to be recorded*</h4>
                    <small></small>
                </div>
            </div>
        </div>
<?php
    }
}
?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    </script>
    <script>
        q = $("span b").text();
        $("input[name='query']").val(q);
    </script>
    <script src="./mouselog.js"></script>
    </body>
</html>