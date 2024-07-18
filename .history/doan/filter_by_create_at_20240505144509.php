<?php

function filter($table, $columns, $from_date, $to_date, $offset, $total_records_per_page)
{
    include ('includes/connect.php');
    $columnList = implode(', ', $columns);
    $sql = "SELECT $columnList, nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE($table.ngaytao) as ngaytao, nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, DATE($table.ngaysua) as ngaysua
                FROM $table INNER JOIN nguoidung ON $table.id_nguoitao = nguoidung.id_nguoidung
                LEFT JOIN nguoidung AS nguoidung2 ON $table.id_nguoisua = nguoidung2.id_nguoidung
                WHERE $table.ngaytao BETWEEN '$from_date  00:00:00' AND '$to_date 23:59:59'
                ORDER BY $table.ngaytao DESC
                LIMIT $offset,$total_records_per_page";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    $result = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $row;
    }
    return $result;
}
?>