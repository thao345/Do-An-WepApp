<?php

function filter($tab$from_date, $to_date, $offset, $total_records_per_page)
{
    include ('includes/connect.php');
    $sql = "";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    $result = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $row;
    }
    return $result;
}
?>