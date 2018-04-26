<!DOCTYPE html>
<html>
    <head>
        <style>
            body {
                font-family: Arial, Verdana, sans-serif;
                color: #333333;
                padding: 5% 20%;
                text-align: center;
            }

            table {
                margin: auto;
                width: 50%;
                padding: 10px;
            }

            tr { height: 4em;}
            button {font-size: 1.2em; height: 2em; width: 10em;}
        </style>
    </head>
    <body>
<?php
/**
 * Created by PhpStorm.
 * User: Andi Zhou
 * Date: 2018/1/18
 * Time: 22:57
 */

if (isset($_GET['pid'])) {
$pid = $_GET['pid'];
echo '<h1>Participant #' . $pid . '</h1>';
?>
        <table>
            <form id="participant" method="GET" action="BingSearch.php">
                <input type="hidden" name="pid" value="<?php echo $pid; ?>">
                <tr>
                    <td>
                        <button form="participant" type="submit" name="tid" value="t1" formtarget="_blank">
                            Task 1
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button form="participant" type="submit" name="tid" value="t2" formtarget="_blank">
                            Task 2
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button form="participant" type="submit" name="tid" value="t3" formtarget="_blank">
                            Task 3
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button form="participant" type="submit" name="tid" value="t4" formtarget="_blank">
                            Task 4
                        </button>
                    </td>
                </tr>
            </form>
        </table>
    </body>
</html>
<?php
}
?>