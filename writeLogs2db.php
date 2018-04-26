<?php
/**
 * Created by PhpStorm.
 * User: Andi Zhou
 * Date: 2018/1/21
 * Time: 15:15
 */

require "PATH/dbconnect.php"; //path and name for the db connection file

/*
 * got posted data from mouselog.js through $.post(),
 * INSERT the posted data into db.
 */

function insertDB(PDO $dbh, $sql_insert, $data) {
    $stmt = $dbh->prepare($sql_insert);
    $stmt->execute($data);
}

function sanitizePOST($post) {
    $post = trim($post, "'");
    $post = trim($post, '"');
    return $post;
}

$sql_insert = "INSERT INTO searchlogs (pid, tid, query, etype, etarget, edesc, tstamp) VALUES "
            . "(:pid, :tid, :query, :etype, :etarget, :edesc, :tstamp)";

if (isset($_POST['PID'], $_POST['TID'], $_POST['QUERY'],
    $_POST['ETYPE'], $_POST['ETARGET'], $_POST['EDESC'], $_POST['TSTAMP'])) {
    $pid = sanitizePOST($_POST['PID']);
    $tid = sanitizePOST($_POST['TID']);
    $query = sanitizePOST($_POST['QUERY']);
    $etype = $_POST['ETYPE'];
    $etarget = $_POST['ETARGET'];
    $edesc = $_POST['EDESC'];
    $tstamp = $_POST['TSTAMP'];

    $data = array(
        ":pid" => $pid,
        ":tid" => $tid,
        ":query" => $query,
        ":etype" => $etype,
        ":etarget" => $etarget,
        ":edesc" => $edesc,
        ":tstamp" => $tstamp
    );

   insertDB($dbh, $sql_insert, $data);

}

?>