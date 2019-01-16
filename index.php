<?php

require_once "includes/Init.php";

$test_task = new Init();
$rows = $test_task->get();

echo "<table border='1' cellspacing='1' cellpadding='10'>";
echo "<thead><tr><th>ID</th><th>Script Name</th><th>Start Time</th><th>End Time</th><th>Result</th></tr></thead>";
echo "<tbody>";
foreach ($rows as $row) {
    $res = sprintf("<tr><td>%d</td><td>%s</td><td>%d</td><td>%d</td><td>%s</td></tr>",
        $row['id'], $row['script_name'], $row['start_time'], $row['end_time'], $row['result']
        );
    echo $res;
}
echo "</tbody>";
echo "</thead>";
echo "</table>";
