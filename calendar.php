<?php
function buildHTMLTable($left, $center, $right, $arr) {
    $width = 300;
    $html = "<table border=1 width=".$width.">";
    $title =
           "<table border=0 width=".$width.">".
           "<tr>".
           "<td>".
           $left.
           "</td><td>".
           $center.
           "</td><td>".
           $right.
           "</td>".
           "</tr>".
           "</table>";
    $html = $html."<caption>".$title."</caption>";
    foreach($arr as $i) {
        $html = $html."<tr>";
        foreach($i as $j) {
            $html = $html."<td>".$j."</td>";
        }
        $html = $html."</tr>";
    }
    $html = $html."</table>";
    
    return $html;
}

$current_time = time();

$year = $_GET['y'];
$curr_year = date('Y', $current_time);
if(empty($year)) {
    $year = $curr_year;
}

$month = $_GET['m'];
$curr_month = date('n');
if(empty($month)) {
    $month = $curr_month;
}
$month_name = date('F', mktime(0, 0, 0, $month, 10));

$show_curr_day = ($month == $curr_month) && ($year == $curr_year);
$curr_day = date('d', $current_time);

$cal = array(array("S","M","T","W","T","F","S"));
$cols = 5;
$rows = 7;
$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
$day_shift = date('w', strtotime("$year-$month-01"));
$n = 1;
for($i=1; $i<=$cols; $i++) {
    $row = array();
    for($j=1; $j<=$rows; $j++) {
        $insert = $n - $day_shift;
        if($insert > 0 && $insert <= $days_in_month) {
            if($show_curr_day &&
               $insert == $curr_day) {
                array_push($row, "<b>".$insert."</b>");
            } else {
                array_push($row, strval($insert));
            }
        } else {
            array_push($row, "");
        }
        
        $n++;
    }
    array_push($cal, $row);
}

$url = $_SERVER['REQUEST_URI'];
$url = strtok($url, '?');
$arg_last_year = $year;
$arg_last_month = $month-1;
$arg_next_year = $year;
$arg_next_month = $month+1;
if($month == 1) {
    $arg_last_month = 12;
    $arg_last_year--;
}
if($month == 12) {
    $arg_next_month = 1;
    $arg_next_year++;
}
$arg_last = $url."?y=".$arg_last_year."&m=".$arg_last_month;
$arg_next = $url."?y=".$arg_next_year."&m=".$arg_next_month;
$link_last = "<a href=".$arg_last.">&lt;Last&lt;</a>";
$link_next = "<a href=".$arg_next.">&gt;Next&gt;</a>";

$title = "<b>".$month_name." ".$year."</b>";

echo buildHTMLTable($link_last, $title, $link_next, $cal);

echo "<br><b><font color=\"blue\">c0de by 3nt1ty </font></b>";
?>
