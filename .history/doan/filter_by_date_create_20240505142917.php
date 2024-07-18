<?php
include "includes/con"
function filter($from_date, $to_date, $offset, $total_records_per_page)
{
 $sql = "";
 $stmt = $conn->prepare($sql);
        $query = $stmt->execute();
        $result = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $row;

        }
}
?>