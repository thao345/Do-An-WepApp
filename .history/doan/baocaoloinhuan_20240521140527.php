<?php
session_start();
include ('includes/header.php');
include ('includes/navbar.php');

include_once ('includes/connect.php');



// DATE_FORMAT(NOW(), '%Y-%m-01') = 2024-05-01
// DATE_FORMAT(NOW() + INTERVAL 1 MONTH, '%Y-%m-01') = 2024-06-01


// lợi nhuận theo các khách hàng
$sql = "SELECT donhang.id_donhang, donhang.booking, donhang.id_khachhang, tuyenvantai.ten AS tentuyenvantai,
dieuhanh.id_thauphu AS machuxe,xe.bienso,taixe.ten AS tentaixe,donhang.ngaydongcontainer AS ngaydongtra,
phieudonhienlieu.soluongnhienlieu,sums1.soluongnhienlieu_sum,phieudonhienlieu.thanhtien AS tiennhienlieu,sums1.tiennhienlieu_sum,
chitietdonhangtamung.tiencuocvo,sums2.tiencuocvo_sum,chitietdonhangtamung.tienhaiquan,sums2.tienhaiquan_sum,chitietdonhangtamung.tiennangha,
sums2.tiennangha_sum,chitietdonhangtamung.tienkhac,sums2.tienkhac_sum,chiphivantai.phicauduong,sums3.phicauduong_sum,
chiphivantai.tienanca,sums3.tienanca_sum,chiphivantai.luongchuyen,sums3.luongchuyen_sum,chiphivantai.luongchunhat,sums3.luongchunhat_sum,
chiphivantai.tienthuexengoai,sums3.tienthuexengoai_sum,donhang.thuthutuc,donhang.thukhac,sums.thuthutuc_sum,sums.thukhac_sum,
chiphivantai.tongchiphi AS giacuocvantai,sums3.giacuocvantai_sum,

(donhang.thuthutuc + donhang.thukhac + chiphivantai.tongchiphi) AS tongdoanhthu,
sums.tongdoanhthu_sum,

( phieudonhienlieu.thanhtien + chitietdonhangtamung.tiencuocvo + chitietdonhangtamung.tienhaiquan + chitietdonhangtamung.tiennangha + chitietdonhangtamung.tienkhac + chiphivantai.phicauduong + chiphivantai.tienanca + chiphivantai.luongchuyen + chiphivantai.luongchunhat +chiphivantai.tienthuexengoai ) AS tongchi,
sums.tongchi_sum AS tongchi_sum,

((donhang.thuthutuc + donhang.thukhac + chiphivantai.tongchiphi) - phieudonhienlieu.thanhtien - chitietdonhangtamung.tiencuocvo - chitietdonhangtamung.tienhaiquan - chitietdonhangtamung.tiennangha - chitietdonhangtamung.tienkhac - chiphivantai.phicauduong - chiphivantai.tienanca - chiphivantai.luongchuyen - chiphivantai.luongchunhat -chiphivantai.tienthuexengoai) AS loinhuan,
(sums.loinhuan_sum ) as  loinhuan_sum,

 ((1.3/100) * ((donhang.thuthutuc + donhang.thukhac + chiphivantai.tongchiphi) - phieudonhienlieu.thanhtien - chitietdonhangtamung.tiencuocvo - chitietdonhangtamung.tienhaiquan - chitietdonhangtamung.tiennangha - chitietdonhangtamung.tienkhac - chiphivantai.phicauduong - chiphivantai.tienanca - chiphivantai.luongchuyen - chiphivantai.luongchunhat - chiphivantai.tienthuexengoai)) AS '1.3% lợi nhuận',
  sums.1_3_loinhuan_sum,
 
(((donhang.thuthutuc + donhang.thukhac + chiphivantai.tongchiphi) - phieudonhienlieu.thanhtien - chitietdonhangtamung.tiencuocvo - chitietdonhangtamung.tienhaiquan - chitietdonhangtamung.tiennangha - chitietdonhangtamung.tienkhac - chiphivantai.phicauduong - chiphivantai.tienanca - chiphivantai.luongchuyen - chiphivantai.luongchunhat -chiphivantai.tienthuexengoai)-((1.3/100) * ((donhang.thuthutuc + donhang.thukhac + chiphivantai.tongchiphi) - phieudonhienlieu.thanhtien - chitietdonhangtamung.tiencuocvo - chitietdonhangtamung.tienhaiquan - chitietdonhangtamung.tiennangha - chitietdonhangtamung.tienkhac - chiphivantai.phicauduong - chiphivantai.tienanca - chiphivantai.luongchuyen - chiphivantai.luongchunhat - chiphivantai.tienthuexengoai))) as loinhuanthuc,
sums.loinhuanthuc_sum,
donhang.ghichu
FROM
donhang
INNER JOIN khachhang ON donhang.id_khachhang = khachhang.id_khachhang
INNER JOIN chiphivantai ON chiphivantai.id_donhang = donhang.id_donhang
INNER JOIN tuyenvantai ON tuyenvantai.id_tuyenvantai = donhang.id_tuyenvantai
INNER JOIN dieuhanh ON dieuhanh.id_donhang = donhang.id_donhang
INNER JOIN phieudonhienlieu ON phieudonhienlieu.id_donhang = donhang.id_donhang
INNER JOIN chitietdonhangtamung ON chitietdonhangtamung.id_donhang = donhang.id_donhang
INNER JOIN xe ON dieuhanh.id_xe = xe.id_xe
INNER JOIN taixe ON dieuhanh.id_taixe = taixe.id_taixe
CROSS JOIN (
    SELECT
        SUM(donhang.thuthutuc) AS thuthutuc_sum,
        SUM(donhang.thukhac) AS thukhac_sum,
        SUM(donhang.thuthutuc + donhang.thukhac + chiphivantai.tongchiphi) AS tongdoanhthu_sum,
        SUM( phieudonhienlieu.thanhtien + chitietdonhangtamung.tiencuocvo + chitietdonhangtamung.tienhaiquan + chitietdonhangtamung.tiennangha + chitietdonhangtamung.tienkhac + chiphivantai.phicauduong + chiphivantai.tienanca + chiphivantai.luongchuyen + chiphivantai.luongchunhat +chiphivantai.tienthuexengoai ) AS tongchi_sum,
        SUM((donhang.thuthutuc + donhang.thukhac + chiphivantai.tongchiphi) - phieudonhienlieu.thanhtien - chitietdonhangtamung.tiencuocvo - chitietdonhangtamung.tienhaiquan - chitietdonhangtamung.tiennangha - chitietdonhangtamung.tienkhac - chiphivantai.phicauduong - chiphivantai.tienanca - chiphivantai.luongchuyen - chiphivantai.luongchunhat -chiphivantai.tienthuexengoai) AS loinhuan_sum,
        SUM((1.3/100) * ((donhang.thuthutuc + donhang.thukhac + chiphivantai.tongchiphi) - phieudonhienlieu.thanhtien - chitietdonhangtamung.tiencuocvo - chitietdonhangtamung.tienhaiquan - chitietdonhangtamung.tiennangha - chitietdonhangtamung.tienkhac - chiphivantai.phicauduong - chiphivantai.tienanca - chiphivantai.luongchuyen - chiphivantai.luongchunhat - chiphivantai.tienthuexengoai)) AS 1_3_loinhuan_sum,
        SUM(((donhang.thuthutuc + donhang.thukhac + chiphivantai.tongchiphi) - phieudonhienlieu.thanhtien - chitietdonhangtamung.tiencuocvo - chitietdonhangtamung.tienhaiquan - chitietdonhangtamung.tiennangha - chitietdonhangtamung.tienkhac - chiphivantai.phicauduong - chiphivantai.tienanca - chiphivantai.luongchuyen - chiphivantai.luongchunhat -chiphivantai.tienthuexengoai)-((1.3/100) * ((donhang.thuthutuc + donhang.thukhac + chiphivantai.tongchiphi) - phieudonhienlieu.thanhtien - chitietdonhangtamung.tiencuocvo - chitietdonhangtamung.tienhaiquan - chitietdonhangtamung.tiennangha - chitietdonhangtamung.tienkhac - chiphivantai.phicauduong - chiphivantai.tienanca - chiphivantai.luongchuyen - chiphivantai.luongchunhat - chiphivantai.tienthuexengoai))) as loinhuanthuc_sum
    FROM
        donhang
    INNER JOIN chiphivantai on chiphivantai.id_donhang = donhang.id_donhang
    INNER JOIN phieudonhienlieu ON phieudonhienlieu.id_donhang = donhang.id_donhang
    INNER JOIN chitietdonhangtamung ON chitietdonhangtamung.id_donhang = donhang.id_donhang
    WHERE
        donhang.trangthai = 'Hoàn thành'
        AND donhang.ngaytao >= DATE_FORMAT(NOW(), '%Y-%m-01')
        AND donhang.ngaytao < DATE_FORMAT(NOW() + INTERVAL 1 MONTH, '%Y-%m-01')
) AS sums

CROSS JOIN (
    SELECT
        SUM(phieudonhienlieu.soluongnhienlieu) AS soluongnhienlieu_sum,
        SUM(phieudonhienlieu.thanhtien) AS tiennhienlieu_sum
    FROM
       phieudonhienlieu
) AS sums1
CROSS JOIN (
    SELECT
        SUM(chitietdonhangtamung.tiencuocvo) AS tiencuocvo_sum,
        SUM(chitietdonhangtamung.tienhaiquan) AS tienhaiquan_sum,
        SUM(chitietdonhangtamung.tiennangha) AS tiennangha_sum,
        SUM(chitietdonhangtamung.tienkhac) AS tienkhac_sum
    FROM
        chitietdonhangtamung
) AS sums2
CROSS JOIN (
    SELECT
        SUM(chiphivantai.phicauduong) AS phicauduong_sum,
        SUM(chiphivantai.tienanca) AS tienanca_sum,
        SUM(chiphivantai.luongchuyen) AS luongchuyen_sum,
        SUM(chiphivantai.luongchunhat) AS luongchunhat_sum,
        SUM(chiphivantai.tienthuexengoai)  AS tienthuexengoai_sum,
        SUM(chiphivantai.tongchiphi)  AS giacuocvantai_sum
    FROM
        chiphivantai
        INNER JOIN donhang on chiphivantai.id_donhang = donhang.id_donhang
       
        WHERE
            donhang.trangthai = 'Hoàn thành'
            AND donhang.ngaytao >=  DATE_FORMAT(NOW(), '%Y-%m-01')
            AND donhang.ngaytao <= DATE_FORMAT(NOW() + INTERVAL 1 MONTH, '%Y-%m-01')
) AS sums3   

WHERE
donhang.ngaytao >= DATE_FORMAT(NOW(), '%Y-%m-01')
AND donhang.ngaytao < DATE_FORMAT(NOW() + INTERVAL 1 MONTH, '%Y-%m-01')
ORDER BY
donhang.ngaytao ASC";

$stmt = $conn->prepare($sql);
$query = $stmt->execute();
$result = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $result[] = $row;
}




// lợi nhuận theo từng khách hàng
$sql1 = "SELECT  donhang.id_khachhang,sums1.soluongnhienlieu_sum,sums1.tiennhienlieu_sum,sums2.tiencuocvo_sum,sums2.tienhaiquan_sum,sums2.tiennangha_sum,sums2.tienkhac_sum,sums3.phicauduong_sum,sums3.tienanca_sum,sums3.luongchuyen_sum,sums3.luongchunhat_sum,sums3.tienthuexengoai_sum,sums.thuthutuc_sum,sums.thukhac_sum,sums3.giacuocvantai_sum,
sums.tongdoanhthu_sum,
sums.tongchi_sum AS tongchi_sum,
(sums.loinhuan_sum ) as  loinhuan_sum,
sums.1_3_loinhuan_sum,
sums.loinhuanthuc_sum

FROM
donhang
INNER JOIN khachhang ON donhang.id_khachhang = khachhang.id_khachhang
INNER JOIN chiphivantai ON chiphivantai.id_donhang = donhang.id_donhang
INNER JOIN tuyenvantai ON tuyenvantai.id_tuyenvantai = donhang.id_tuyenvantai
INNER JOIN dieuhanh ON dieuhanh.id_donhang = donhang.id_donhang
INNER JOIN phieudonhienlieu ON phieudonhienlieu.id_donhang = donhang.id_donhang
INNER JOIN chitietdonhangtamung ON chitietdonhangtamung.id_donhang = donhang.id_donhang
INNER JOIN xe ON dieuhanh.id_xe = xe.id_xe
INNER JOIN taixe ON dieuhanh.id_taixe = taixe.id_taixe
INNER JOIN (
    SELECT
    	donhang.id_khachhang,
        SUM(donhang.thuthutuc) AS thuthutuc_sum,
        SUM(donhang.thukhac) AS thukhac_sum,
        SUM(donhang.thuthutuc + donhang.thukhac + chiphivantai.tongchiphi) AS tongdoanhthu_sum,
        SUM( phieudonhienlieu.thanhtien + chitietdonhangtamung.tiencuocvo + chitietdonhangtamung.tienhaiquan + chitietdonhangtamung.tiennangha + chitietdonhangtamung.tienkhac + chiphivantai.phicauduong + chiphivantai.tienanca + chiphivantai.luongchuyen + chiphivantai.luongchunhat +chiphivantai.tienthuexengoai ) AS tongchi_sum,
        SUM((donhang.thuthutuc + donhang.thukhac + chiphivantai.tongchiphi) - phieudonhienlieu.thanhtien - chitietdonhangtamung.tiencuocvo - chitietdonhangtamung.tienhaiquan - chitietdonhangtamung.tiennangha - chitietdonhangtamung.tienkhac - chiphivantai.phicauduong - chiphivantai.tienanca - chiphivantai.luongchuyen - chiphivantai.luongchunhat -chiphivantai.tienthuexengoai) AS loinhuan_sum,
        SUM((1.3/100) * ((donhang.thuthutuc + donhang.thukhac + chiphivantai.tongchiphi) - phieudonhienlieu.thanhtien - chitietdonhangtamung.tiencuocvo - chitietdonhangtamung.tienhaiquan - chitietdonhangtamung.tiennangha - chitietdonhangtamung.tienkhac - chiphivantai.phicauduong - chiphivantai.tienanca - chiphivantai.luongchuyen - chiphivantai.luongchunhat - chiphivantai.tienthuexengoai)) AS 1_3_loinhuan_sum,
        SUM(((donhang.thuthutuc + donhang.thukhac + chiphivantai.tongchiphi) - phieudonhienlieu.thanhtien - chitietdonhangtamung.tiencuocvo - chitietdonhangtamung.tienhaiquan - chitietdonhangtamung.tiennangha - chitietdonhangtamung.tienkhac - chiphivantai.phicauduong - chiphivantai.tienanca - chiphivantai.luongchuyen - chiphivantai.luongchunhat -chiphivantai.tienthuexengoai)-((1.3/100) * ((donhang.thuthutuc + donhang.thukhac + chiphivantai.tongchiphi) - phieudonhienlieu.thanhtien - chitietdonhangtamung.tiencuocvo - chitietdonhangtamung.tienhaiquan - chitietdonhangtamung.tiennangha - chitietdonhangtamung.tienkhac - chiphivantai.phicauduong - chiphivantai.tienanca - chiphivantai.luongchuyen - chiphivantai.luongchunhat - chiphivantai.tienthuexengoai))) as loinhuanthuc_sum
    FROM
        donhang
    INNER JOIN chiphivantai on chiphivantai.id_donhang = donhang.id_donhang
    INNER JOIN khachhang on donhang.id_khachhang = khachhang.id_khachhang
    INNER JOIN phieudonhienlieu ON phieudonhienlieu.id_donhang = donhang.id_donhang
    INNER JOIN chitietdonhangtamung ON chitietdonhangtamung.id_donhang = donhang.id_donhang
    WHERE
        donhang.trangthai = 'Hoàn thành'
        AND donhang.ngaytao >= DATE_FORMAT(NOW(), '%Y-%m-01')
        AND donhang.ngaytao < DATE_FORMAT(NOW() + INTERVAL 1 MONTH, '%Y-%m-01')
     GROUP BY id_khachhang
) AS sums ON donhang.id_khachhang = sums.id_khachhang 

INNER JOIN (
    SELECT
    	donhang.id_khachhang,
        SUM(phieudonhienlieu.soluongnhienlieu) AS soluongnhienlieu_sum,
        SUM(phieudonhienlieu.thanhtien) AS tiennhienlieu_sum
    FROM
       phieudonhienlieu 
   INNER JOIN donhang ON donhang.id_donhang = phieudonhienlieu.id_donhang
INNER JOIN khachhang ON khachhang.id_khachhang = donhang.id_khachhang
     WHERE
        donhang.trangthai = 'Hoàn thành'
        AND donhang.ngaytao >= DATE_FORMAT(NOW(), '%Y-%m-01')
        AND donhang.ngaytao < DATE_FORMAT(NOW() + INTERVAL 1 MONTH, '%Y-%m-01')
     GROUP BY id_khachhang
) AS sums1  ON donhang.id_khachhang = sums1.id_khachhang
INNER JOIN (
    SELECT
   		 donhang.id_khachhang,
        SUM(chitietdonhangtamung.tiencuocvo) AS tiencuocvo_sum,
        SUM(chitietdonhangtamung.tienhaiquan) AS tienhaiquan_sum,
        SUM(chitietdonhangtamung.tiennangha) AS tiennangha_sum,
        SUM(chitietdonhangtamung.tienkhac) AS tienkhac_sum
    FROM
        chitietdonhangtamung
    INNER JOIN donhang ON donhang.id_donhang = chitietdonhangtamung.id_donhang
INNER JOIN khachhang ON khachhang.id_khachhang = donhang.id_khachhang
     WHERE
        donhang.trangthai = 'Hoàn thành'
        AND donhang.ngaytao >= DATE_FORMAT(NOW(), '%Y-%m-01')
        AND donhang.ngaytao < DATE_FORMAT(NOW() + INTERVAL 1 MONTH, '%Y-%m-01')
     GROUP BY id_khachhang
) AS sums2 ON donhang.id_khachhang = sums2.id_khachhang
INNER JOIN (
    SELECT
   		 donhang.id_khachhang,
        SUM(chiphivantai.phicauduong) AS phicauduong_sum,
        SUM(chiphivantai.tienanca) AS tienanca_sum,
        SUM(chiphivantai.luongchuyen) AS luongchuyen_sum,
        SUM(chiphivantai.luongchunhat) AS luongchunhat_sum,
        SUM(chiphivantai.tienthuexengoai)  AS tienthuexengoai_sum,
        SUM(chiphivantai.tongchiphi)  AS giacuocvantai_sum
    FROM
        chiphivantai
    INNER JOIN donhang ON donhang.id_donhang = chiphivantai.id_donhang
INNER JOIN khachhang ON khachhang.id_khachhang = donhang.id_khachhang
     WHERE
        donhang.trangthai = 'Hoàn thành'
        AND donhang.ngaytao >= DATE_FORMAT(NOW(), '%Y-%m-01')
        AND donhang.ngaytao < DATE_FORMAT(NOW() + INTERVAL 1 MONTH, '%Y-%m-01')
     GROUP BY id_khachhang
) AS sums3 ON donhang.id_khachhang = sums3.id_khachhang   

WHERE
donhang.ngaytao >= DATE_FORMAT(NOW(), '%Y-%m-01')
AND donhang.ngaytao < DATE_FORMAT(NOW() + INTERVAL 1 MONTH, '%Y-%m-01')
GROUP BY donhang.id_khachhang 
ORDER BY
donhang.ngaytao ASC";

$stmt1 = $conn->prepare($sql1);
$query = $stmt1->execute();
$resultLoiNhuanUnique = array();
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $resultLoiNhuanUnique[] = $row;
}


$sqlSC = "SELECT xe.bienso, suachua.tongtien as tongtiensuachua ,sums.tongtiensuachua_sum
FROM suachua
INNER JOIN xe ON suachua.id_xe = xe.id_xe
CROSS JOIN (
SELECT SUM(tongtien) AS tongtiensuachua_sum
FROM suachua
WHERE suachua.ngaysuachua >= DATE_FORMAT(NOW(), '%Y-%m-01') AND suachua.ngaysuachua < DATE_FORMAT(NOW() + INTERVAL 1 MONTH, '%Y-%m-01')
) AS sums
WHERE suachua.ngaysuachua >= DATE_FORMAT(NOW(), '%Y-%m-01') AND suachua.ngaysuachua < DATE_FORMAT(NOW() + INTERVAL 1 MONTH, '%Y-%m-01')
ORDER BY suachua.ngaysuachua ASC";
$stmtSC = $conn->prepare($sqlSC);
$query = $stmtSC->execute();
$resultSC = array();
while ($row = $stmtSC->fetch(PDO::FETCH_ASSOC)) {
    $resultSC[] = $row;
}


if (isset($_GET['filter']) && isset($_GET['from_date']) && isset($_GET['to_date'])) {


    $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : '';
    $to_date = isset($_GET['to_date']) ? $_GET['to_date'] . ' 23:59:59' : '';

    // lợi nhuận theo các khách hàng
    $sql = "SELECT donhang.id_donhang, donhang.booking, donhang.id_khachhang, tuyenvantai.ten AS tentuyenvantai,
    dieuhanh.id_thauphu AS machuxe,xe.bienso,taixe.ten AS tentaixe,donhang.ngaydongcontainer AS ngaydongtra,
    phieudonhienlieu.soluongnhienlieu,sums1.soluongnhienlieu_sum,phieudonhienlieu.thanhtien AS tiennhienlieu,sums1.tiennhienlieu_sum,
    chitietdonhangtamung.tiencuocvo,sums2.tiencuocvo_sum,chitietdonhangtamung.tienhaiquan,sums2.tienhaiquan_sum,chitietdonhangtamung.tiennangha,
    sums2.tiennangha_sum,chitietdonhangtamung.tienkhac,sums2.tienkhac_sum,chiphivantai.phicauduong,sums3.phicauduong_sum,
    chiphivantai.tienanca,sums3.tienanca_sum,chiphivantai.luongchuyen,sums3.luongchuyen_sum,chiphivantai.luongchunhat,sums3.luongchunhat_sum,
    chiphivantai.tienthuexengoai,sums3.tienthuexengoai_sum,donhang.thuthutuc,donhang.thukhac,sums.thuthutuc_sum,sums.thukhac_sum,
    chiphivantai.tongchiphi AS giacuocvantai,sums3.giacuocvantai_sum,
    
    (donhang.thuthutuc + donhang.thukhac + chiphivantai.tongchiphi) AS tongdoanhthu,
    sums.tongdoanhthu_sum,
    
    ( phieudonhienlieu.thanhtien + chitietdonhangtamung.tiencuocvo + chitietdonhangtamung.tienhaiquan + chitietdonhangtamung.tiennangha + chitietdonhangtamung.tienkhac + chiphivantai.phicauduong + chiphivantai.tienanca + chiphivantai.luongchuyen + chiphivantai.luongchunhat +chiphivantai.tienthuexengoai ) AS tongchi,
    sums.tongchi_sum AS tongchi_sum,
    
    ((donhang.thuthutuc + donhang.thukhac + chiphivantai.tongchiphi) - phieudonhienlieu.thanhtien - chitietdonhangtamung.tiencuocvo - chitietdonhangtamung.tienhaiquan - chitietdonhangtamung.tiennangha - chitietdonhangtamung.tienkhac - chiphivantai.phicauduong - chiphivantai.tienanca - chiphivantai.luongchuyen - chiphivantai.luongchunhat -chiphivantai.tienthuexengoai) AS loinhuan,
    (sums.loinhuan_sum ) as  loinhuan_sum,
    
     ((1.3/100) * ((donhang.thuthutuc + donhang.thukhac + chiphivantai.tongchiphi) - phieudonhienlieu.thanhtien - chitietdonhangtamung.tiencuocvo - chitietdonhangtamung.tienhaiquan - chitietdonhangtamung.tiennangha - chitietdonhangtamung.tienkhac - chiphivantai.phicauduong - chiphivantai.tienanca - chiphivantai.luongchuyen - chiphivantai.luongchunhat - chiphivantai.tienthuexengoai)) AS '1.3% lợi nhuận',
      sums.1_3_loinhuan_sum,
     
    (((donhang.thuthutuc + donhang.thukhac + chiphivantai.tongchiphi) - phieudonhienlieu.thanhtien - chitietdonhangtamung.tiencuocvo - chitietdonhangtamung.tienhaiquan - chitietdonhangtamung.tiennangha - chitietdonhangtamung.tienkhac - chiphivantai.phicauduong - chiphivantai.tienanca - chiphivantai.luongchuyen - chiphivantai.luongchunhat -chiphivantai.tienthuexengoai)-((1.3/100) * ((donhang.thuthutuc + donhang.thukhac + chiphivantai.tongchiphi) - phieudonhienlieu.thanhtien - chitietdonhangtamung.tiencuocvo - chitietdonhangtamung.tienhaiquan - chitietdonhangtamung.tiennangha - chitietdonhangtamung.tienkhac - chiphivantai.phicauduong - chiphivantai.tienanca - chiphivantai.luongchuyen - chiphivantai.luongchunhat - chiphivantai.tienthuexengoai))) as loinhuanthuc,
    sums.loinhuanthuc_sum,
    donhang.ghichu
    FROM
    donhang
    INNER JOIN khachhang ON donhang.id_khachhang = khachhang.id_khachhang
    INNER JOIN chiphivantai ON chiphivantai.id_donhang = donhang.id_donhang
    INNER JOIN tuyenvantai ON tuyenvantai.id_tuyenvantai = donhang.id_tuyenvantai
    INNER JOIN dieuhanh ON dieuhanh.id_donhang = donhang.id_donhang
    INNER JOIN phieudonhienlieu ON phieudonhienlieu.id_donhang = donhang.id_donhang
    INNER JOIN chitietdonhangtamung ON chitietdonhangtamung.id_donhang = donhang.id_donhang
    INNER JOIN xe ON dieuhanh.id_xe = xe.id_xe
    INNER JOIN taixe ON dieuhanh.id_taixe = taixe.id_taixe
    CROSS JOIN (
        SELECT
            SUM(donhang.thuthutuc) AS thuthutuc_sum,
            SUM(donhang.thukhac) AS thukhac_sum,
            SUM(donhang.thuthutuc + donhang.thukhac + chiphivantai.tongchiphi) AS tongdoanhthu_sum,
            SUM( phieudonhienlieu.thanhtien + chitietdonhangtamung.tiencuocvo + chitietdonhangtamung.tienhaiquan + chitietdonhangtamung.tiennangha + chitietdonhangtamung.tienkhac + chiphivantai.phicauduong + chiphivantai.tienanca + chiphivantai.luongchuyen + chiphivantai.luongchunhat +chiphivantai.tienthuexengoai ) AS tongchi_sum,
            SUM((donhang.thuthutuc + donhang.thukhac + chiphivantai.tongchiphi) - phieudonhienlieu.thanhtien - chitietdonhangtamung.tiencuocvo - chitietdonhangtamung.tienhaiquan - chitietdonhangtamung.tiennangha - chitietdonhangtamung.tienkhac - chiphivantai.phicauduong - chiphivantai.tienanca - chiphivantai.luongchuyen - chiphivantai.luongchunhat -chiphivantai.tienthuexengoai) AS loinhuan_sum,
            SUM((1.3/100) * ((donhang.thuthutuc + donhang.thukhac + chiphivantai.tongchiphi) - phieudonhienlieu.thanhtien - chitietdonhangtamung.tiencuocvo - chitietdonhangtamung.tienhaiquan - chitietdonhangtamung.tiennangha - chitietdonhangtamung.tienkhac - chiphivantai.phicauduong - chiphivantai.tienanca - chiphivantai.luongchuyen - chiphivantai.luongchunhat - chiphivantai.tienthuexengoai)) AS 1_3_loinhuan_sum,
            SUM(((donhang.thuthutuc + donhang.thukhac + chiphivantai.tongchiphi) - phieudonhienlieu.thanhtien - chitietdonhangtamung.tiencuocvo - chitietdonhangtamung.tienhaiquan - chitietdonhangtamung.tiennangha - chitietdonhangtamung.tienkhac - chiphivantai.phicauduong - chiphivantai.tienanca - chiphivantai.luongchuyen - chiphivantai.luongchunhat -chiphivantai.tienthuexengoai)-((1.3/100) * ((donhang.thuthutuc + donhang.thukhac + chiphivantai.tongchiphi) - phieudonhienlieu.thanhtien - chitietdonhangtamung.tiencuocvo - chitietdonhangtamung.tienhaiquan - chitietdonhangtamung.tiennangha - chitietdonhangtamung.tienkhac - chiphivantai.phicauduong - chiphivantai.tienanca - chiphivantai.luongchuyen - chiphivantai.luongchunhat - chiphivantai.tienthuexengoai))) as loinhuanthuc_sum
        FROM
            donhang
        INNER JOIN chiphivantai on chiphivantai.id_donhang = donhang.id_donhang
        INNER JOIN phieudonhienlieu ON phieudonhienlieu.id_donhang = donhang.id_donhang
        INNER JOIN chitietdonhangtamung ON chitietdonhangtamung.id_donhang = donhang.id_donhang
        WHERE
            donhang.trangthai = 'Hoàn thành'
            AND donhang.ngaytao >= :from_date
            AND donhang.ngaytao <= :to_date 
    ) AS sums
    
    CROSS JOIN (
        SELECT
            SUM(phieudonhienlieu.soluongnhienlieu) AS soluongnhienlieu_sum,
            SUM(phieudonhienlieu.thanhtien) AS tiennhienlieu_sum
        FROM
           phieudonhienlieu
    ) AS sums1
    CROSS JOIN (
        SELECT
            SUM(chitietdonhangtamung.tiencuocvo) AS tiencuocvo_sum,
            SUM(chitietdonhangtamung.tienhaiquan) AS tienhaiquan_sum,
            SUM(chitietdonhangtamung.tiennangha) AS tiennangha_sum,
            SUM(chitietdonhangtamung.tienkhac) AS tienkhac_sum
        FROM
            chitietdonhangtamung
    ) AS sums2
    CROSS JOIN (
        SELECT
            SUM(chiphivantai.phicauduong) AS phicauduong_sum,
            SUM(chiphivantai.tienanca) AS tienanca_sum,
            SUM(chiphivantai.luongchuyen) AS luongchuyen_sum,
            SUM(chiphivantai.luongchunhat) AS luongchunhat_sum,
            SUM(chiphivantai.tienthuexengoai)  AS tienthuexengoai_sum,
            SUM(chiphivantai.tongchiphi)  AS giacuocvantai_sum
        FROM
            chiphivantai
            INNER JOIN donhang on chiphivantai.id_donhang = donhang.id_donhang
       
        WHERE
            donhang.trangthai = 'Hoàn thành'
            AND donhang.ngaytao >= :from_date
            AND donhang.ngaytao <= :to_date 
    ) AS sums3   
    
    WHERE
    donhang.ngaytao >= :from_date
    AND donhang.ngaytao < :to_date
    ORDER BY
    donhang.ngaytao ASC";

    // lợi nhuận theo từng khách hàng
    $sql1 = "SELECT  donhang.id_khachhang,sums1.soluongnhienlieu_sum,sums1.tiennhienlieu_sum,sums2.tiencuocvo_sum,sums2.tienhaiquan_sum,sums2.tiennangha_sum,sums2.tienkhac_sum,sums3.phicauduong_sum,sums3.tienanca_sum,sums3.luongchuyen_sum,sums3.luongchunhat_sum,sums3.tienthuexengoai_sum,sums.thuthutuc_sum,sums.thukhac_sum,sums3.giacuocvantai_sum,
    sums.tongdoanhthu_sum,
    sums.tongchi_sum AS tongchi_sum,
    (sums.loinhuan_sum ) as  loinhuan_sum,
    sums.1_3_loinhuan_sum,
    sums.loinhuanthuc_sum
    
    FROM
    donhang
    INNER JOIN khachhang ON donhang.id_khachhang = khachhang.id_khachhang
    INNER JOIN chiphivantai ON chiphivantai.id_donhang = donhang.id_donhang
    INNER JOIN tuyenvantai ON tuyenvantai.id_tuyenvantai = donhang.id_tuyenvantai
    INNER JOIN dieuhanh ON dieuhanh.id_donhang = donhang.id_donhang
    INNER JOIN phieudonhienlieu ON phieudonhienlieu.id_donhang = donhang.id_donhang
    INNER JOIN chitietdonhangtamung ON chitietdonhangtamung.id_donhang = donhang.id_donhang
    INNER JOIN xe ON dieuhanh.id_xe = xe.id_xe
    INNER JOIN taixe ON dieuhanh.id_taixe = taixe.id_taixe
    INNER JOIN (
        SELECT
            donhang.id_khachhang,
            SUM(donhang.thuthutuc) AS thuthutuc_sum,
            SUM(donhang.thukhac) AS thukhac_sum,
            SUM(donhang.thuthutuc + donhang.thukhac + chiphivantai.tongchiphi) AS tongdoanhthu_sum,
            SUM( phieudonhienlieu.thanhtien + chitietdonhangtamung.tiencuocvo + chitietdonhangtamung.tienhaiquan + chitietdonhangtamung.tiennangha + chitietdonhangtamung.tienkhac + chiphivantai.phicauduong + chiphivantai.tienanca + chiphivantai.luongchuyen + chiphivantai.luongchunhat +chiphivantai.tienthuexengoai ) AS tongchi_sum,
            SUM((donhang.thuthutuc + donhang.thukhac + chiphivantai.tongchiphi) - phieudonhienlieu.thanhtien - chitietdonhangtamung.tiencuocvo - chitietdonhangtamung.tienhaiquan - chitietdonhangtamung.tiennangha - chitietdonhangtamung.tienkhac - chiphivantai.phicauduong - chiphivantai.tienanca - chiphivantai.luongchuyen - chiphivantai.luongchunhat -chiphivantai.tienthuexengoai) AS loinhuan_sum,
            SUM((1.3/100) * ((donhang.thuthutuc + donhang.thukhac + chiphivantai.tongchiphi) - phieudonhienlieu.thanhtien - chitietdonhangtamung.tiencuocvo - chitietdonhangtamung.tienhaiquan - chitietdonhangtamung.tiennangha - chitietdonhangtamung.tienkhac - chiphivantai.phicauduong - chiphivantai.tienanca - chiphivantai.luongchuyen - chiphivantai.luongchunhat - chiphivantai.tienthuexengoai)) AS 1_3_loinhuan_sum,
            SUM(((donhang.thuthutuc + donhang.thukhac + chiphivantai.tongchiphi) - phieudonhienlieu.thanhtien - chitietdonhangtamung.tiencuocvo - chitietdonhangtamung.tienhaiquan - chitietdonhangtamung.tiennangha - chitietdonhangtamung.tienkhac - chiphivantai.phicauduong - chiphivantai.tienanca - chiphivantai.luongchuyen - chiphivantai.luongchunhat -chiphivantai.tienthuexengoai)-((1.3/100) * ((donhang.thuthutuc + donhang.thukhac + chiphivantai.tongchiphi) - phieudonhienlieu.thanhtien - chitietdonhangtamung.tiencuocvo - chitietdonhangtamung.tienhaiquan - chitietdonhangtamung.tiennangha - chitietdonhangtamung.tienkhac - chiphivantai.phicauduong - chiphivantai.tienanca - chiphivantai.luongchuyen - chiphivantai.luongchunhat - chiphivantai.tienthuexengoai))) as loinhuanthuc_sum
        FROM
            donhang
        INNER JOIN chiphivantai on chiphivantai.id_donhang = donhang.id_donhang
        INNER JOIN khachhang on donhang.id_khachhang = khachhang.id_khachhang
        INNER JOIN phieudonhienlieu ON phieudonhienlieu.id_donhang = donhang.id_donhang
        INNER JOIN chitietdonhangtamung ON chitietdonhangtamung.id_donhang = donhang.id_donhang
        WHERE
            donhang.trangthai = 'Hoàn thành'
            AND donhang.ngaytao >= :from_date
            AND donhang.ngaytao < :to_date
         GROUP BY id_khachhang
    ) AS sums ON donhang.id_khachhang = sums.id_khachhang 
    
    INNER JOIN (
        SELECT
            donhang.id_khachhang,
            SUM(phieudonhienlieu.soluongnhienlieu) AS soluongnhienlieu_sum,
            SUM(phieudonhienlieu.thanhtien) AS tiennhienlieu_sum
        FROM
           phieudonhienlieu 
       INNER JOIN donhang ON donhang.id_donhang = phieudonhienlieu.id_donhang
    INNER JOIN khachhang ON khachhang.id_khachhang = donhang.id_khachhang
         WHERE
            donhang.trangthai = 'Hoàn thành'
            AND donhang.ngaytao >=  :from_date
            AND donhang.ngaytao < :to_date
         GROUP BY id_khachhang
    ) AS sums1  ON donhang.id_khachhang = sums1.id_khachhang
    INNER JOIN (
        SELECT
                donhang.id_khachhang,
            SUM(chitietdonhangtamung.tiencuocvo) AS tiencuocvo_sum,
            SUM(chitietdonhangtamung.tienhaiquan) AS tienhaiquan_sum,
            SUM(chitietdonhangtamung.tiennangha) AS tiennangha_sum,
            SUM(chitietdonhangtamung.tienkhac) AS tienkhac_sum
        FROM
            chitietdonhangtamung
        INNER JOIN donhang ON donhang.id_donhang = chitietdonhangtamung.id_donhang
    INNER JOIN khachhang ON khachhang.id_khachhang = donhang.id_khachhang
         WHERE
            donhang.trangthai = 'Hoàn thành'
            AND donhang.ngaytao >= :from_date
            AND donhang.ngaytao < :to_date 
         GROUP BY id_khachhang
    ) AS sums2 ON donhang.id_khachhang = sums2.id_khachhang
    INNER JOIN (
        SELECT
                donhang.id_khachhang,
            SUM(chiphivantai.phicauduong) AS phicauduong_sum,
            SUM(chiphivantai.tienanca) AS tienanca_sum,
            SUM(chiphivantai.luongchuyen) AS luongchuyen_sum,
            SUM(chiphivantai.luongchunhat) AS luongchunhat_sum,
            SUM(chiphivantai.tienthuexengoai)  AS tienthuexengoai_sum,
            SUM(chiphivantai.tongchiphi)  AS giacuocvantai_sum
        FROM
            chiphivantai
        INNER JOIN donhang ON donhang.id_donhang = chiphivantai.id_donhang
    INNER JOIN khachhang ON khachhang.id_khachhang = donhang.id_khachhang
         WHERE
            donhang.trangthai = 'Hoàn thành'
            AND donhang.ngaytao >= :from_date
            AND donhang.ngaytao < :to_date 
         GROUP BY id_khachhang
    ) AS sums3 ON donhang.id_khachhang = sums3.id_khachhang   
    
    WHERE
    donhang.ngaytao >= :from_date
    AND donhang.ngaytao < :to_date 
    GROUP BY donhang.id_khachhang 
    ORDER BY
    donhang.ngaytao ASC";

    $sqlSC = "SELECT xe.bienso, suachua.tongtien as tongtiensuachua ,sums.tongtiensuachua_sum
FROM suachua
INNER JOIN xe ON suachua.id_xe = xe.id_xe
CROSS JOIN (
SELECT SUM(tongtien) AS tongtiensuachua_sum
FROM suachua
WHERE suachua.ngaysuachua >= :from_date AND suachua.ngaysuachua <= :to_date 
) AS sums
WHERE suachua.ngaysuachua >= :from_date AND suachua.ngaysuachua <= :to_date 
ORDER BY suachua.ngaysuachua ASC";




    $stmt = $conn->prepare($sql);
    $stmt1 = $conn->prepare($sql1);
    $stmt2 = $conn->prepare($sqlSC);

    // if (!empty($id_khachhang)) {
    //     $stmt->bindParam(':id_khachhang', $id_khachhang);
    // }

    if (!empty($from_date)) {
        $stmt->bindParam(':from_date', $from_date);
        $stmt1->bindParam(':from_date', $from_date);
        $stmt2->bindParam(':from_date', $from_date);
    }

    if (!empty($to_date)) {
        $stmt->bindParam(':to_date', $to_date);
        $stmt1->bindParam(':to_date', $to_date);
        $stmt2->bindParam(':to_date', $to_date);
    }

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt1->execute();
    $resultLoiNhuanUnique = $stmt1->fetchAll(PDO::FETCH_ASSOC);
    $stmt2->execute();
    $resultSC = $stmt2->fetchAll(PDO::FETCH_ASSOC);


}


?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
        <div > 
            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo "Tên đăng nhập: ".$tendangnhap; ?></span>
            <br>
            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo "Thời gian đăng nhập: ".$thoigiandangnhap; ?></span>
        </div>
            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>


            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">
                <button id="fullscreenButton">
                    <i class="fas fa-expand"></i>
                </button>
                <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                <li class="nav-item dropdown no-arrow d-sm-none">
                    <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-search fa-fw"></i>
                    </a>
                    <!-- Dropdown - Messages -->
                    <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                        aria-labelledby="searchDropdown">
                        <form class="form-inline mr-auto w-100 navbar-search">
                            <div class="input-group">
                                <input type="text" class="form-control bg-light border-0 small"
                                    placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>



                <div class="topbar-divider d-none d-sm-block"></div>

                <!-- Nav Item - User Information -->
                <?php
                include 'includes/userInformation.php';
                ?>

            </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800  text-center header-crud">Báo cáo lợi nhuận </h1>
            <!-- Topbar Search -->
            <div class="d-flex">

                <!-- filter ngày -->
                <form class="form-inline ml-auto mr-4 border p-3 rounded filterBCLN" method="GET">

                    <div class="form-group">
                        <input class="form-check-input checkbox-to" type="checkbox" name="filter_date" id="filter_date"
                            value="1" <?php echo isset($_GET['filter_date']) && $_GET['filter_date'] == '1' ? 'checked' : ''; ?>>
                        <div class="input-group ml-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon3">Từ ngày</span>
                            </div>
                            <input disabled type="date" class="form-control" name="from_date"
                                value="<?php echo isset($_GET['from_date']) ? $_GET['from_date'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group ml-3">
                        <div class="input-group ml-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon3">Đến ngày</span>
                            </div>
                            <input disabled type="date" class="form-control" name="to_date"
                                value="<?php echo isset($_GET['to_date']) ? $_GET['to_date'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group ml-3">
                        <button type="submit" name="filter" class="btn btn-primary mr-2">Filter</button>
                        <a href="baocaoloinhuan.php" class="btn btn-danger">Reset</a>
                    </div>
                </form>
            </div>
            <!-- // phần này để khi chọn checkbox rồi khi filter reload trang sẽ ko bị mất checkbox đã checked -->
            <script>
                const form = document.getElementById('filterForm');
                // const filterkhachhang = document.getElementById('filter_khachhang');
                // const khachhangSelect = document.getElementById('exampleFormControlSelect1');
                const filterDate = document.getElementById('filter_date');
                const fromDateInput = document.getElementsByName('from_date')[0];
                const toDateInput = document.getElementsByName('to_date')[0];

                // Function to enable/disable inputs based on checkbox state
                function toggleInputDisabledState() {
                    // khachhangSelect.disabled = !filterkhachhang.checked;
                    fromDateInput.disabled = !filterDate.checked;
                    toDateInput.disabled = !filterDate.checked;
                }

                // Initial state on page load
                toggleInputDisabledState();

                // filterkhachhang.addEventListener('change', toggleInputDisabledState);
                filterDate.addEventListener('change', toggleInputDisabledState);
                if (form) {
                    form.addEventListener('submit', function (e) {
                        // if (filterkhachhang.checked && khachhangSelect.disabled) {
                        //     e.preventDefault();
                        // }

                        if (filterDate.checked && (fromDateInput.disabled || toDateInput.disabled)) {
                            e.preventDefault();
                        }
                    });
                }
            </script>
            <!-- search input -->
            <div class="d-flex mt-3 mb-3 float-right">
                <a href="#" onclick="exportTableToExcel('myTable')" id="excelButton" class="btn btn-success mr-2"
                    style="min-width: 90px;"><i class="fas fa-download mr-2"></i>Excel</a>

                <form class="form-inline mr-3 ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control border-1 small search-input" placeholder="Tìm kiếm..."
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>



            <div class="card-body">
                <div class="table-responsive">

                    <table class=" table  table-bordered table-hover " id="myTable" width="100%" cellspacing="0">
                        <thead style=" white-space: nowrap;" class="thead-dark">
                            <tr>
                                <th class="text-center" style="vertical-align: middle;" rowspan="2">STT</th>
                                <th class="text-center bg-header-ttdh" colspan="8">Thông tin đơn hàng và vận chuyển</th>
                                <th class="text-center bg-header-tienchi" colspan="11">Tiền chi</th>
                                <th class="text-center bg-header-doanhthukhac" colspan="2">Doanh thu khác</th>
                                <th class="text-center bg-header-doanhthutong" colspan="2">Doanh thu tổng</th>
                                <th class="text-center bg-header-tongchiphi" colspan="3">Tổng chi phí</th>
                                <th class="text-center bg-header-loinhuan" colspan="3">Lợi nhuận</th>
                                <th class="text-center " style="vertical-align: middle;" rowspan="2">Ghi chú</th>
                            </tr>
                            <tr>
                                <!-- <th>STT</th> -->
                                <th>Mã đơn hàng</th>
                                <th>Khách hàng</th>
                                <th>Booking</th>
                                <th>Tuyến vận tải</th>
                                <th>Chủ xe</th>
                                <th>Xe vận chuyển</th>
                                <th>Tài xế</th>
                                <th>Ngày đóng/trả</th>
                                <th>Số lượng nhiên liệu (lít)</th>
                                <th>Tiền nhiên liệu (VNĐ)</th>
                                <th>Tiền cước vỏ (VNĐ)</th>
                                <th>Tiền hải quan (VNĐ)</th>
                                <th>Tiền nâng hạ (VNĐ)</th>
                                <th>Tiền khác (VNĐ)</th>
                                <th>Phí cầu đường (VNĐ)</th>
                                <th>Tiền ăn ca (VNĐ)</th>
                                <th>Lương chuyến (VNĐ)</th>
                                <th>Lương chủ nhật (VNĐ)</th>
                                <th>Tiền thuê xe ngoài (VNĐ)</th>
                                <th>Thu thủ tục (VNĐ)</th>
                                <th>Thu khác (VNĐ)</th>
                                <th>Giá cước vận tải (VNĐ)</th>
                                <th>Tổng doanh thu (VNĐ)</th>
                                <th>Tổng chi sửa chữa (VNĐ)</th>
                                <th>Tổng chi đơn hàng (VNĐ)</th>
                                <th>Tổng chi (VNĐ)</th>
                                <th>Lợi nhuận (VNĐ)</th>
                                <th>1.3% Lợi nhuận (VNĐ)</th>
                                <th>Lợi nhuận thực (VNĐ)</th>
                                <!-- <th>Ghi chú</th> -->
                            </tr>
                        </thead>

                        <tbody style=" white-space: nowrap;">
                            <tr class="bg-row-header">
                                <td colspan="31">Tổng lợi nhuận theo tất cả khách hàng</td>
                            </tr>
                            <?php $count = 1;
                            $hasData = false; // Biến kiểm tra dữ liệu
                            foreach ($result as $items):
                                $hasData = true; // Đánh dấu có dữ liệu     
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $count++; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['id_donhang']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['id_khachhang']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['booking']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['tentuyenvantai']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['machuxe']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['bienso']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['tentaixe']; ?>
                                    </td>
                                    <td>
                                        <?php echo date('d-m-Y', strtotime($items['ngaydongtra'])); ?>
                                    </td>
                                    <td>
                                        <?php echo $items['soluongnhienlieu']; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $tiennhienlieu = $items['tiennhienlieu'];
                                        $formatted_tiennhienlieu = number_format($tiennhienlieu, 0, ',', ',');
                                        echo $formatted_tiennhienlieu;
                                        ?>
                                    </td>

                                    <td>
                                        <?php
                                        $tiencuocvo = $items['tiencuocvo'];
                                        $formatted_tiencuocvo = number_format($tiencuocvo, 0, ',', ',');
                                        echo $formatted_tiencuocvo;
                                        ?>
                                    </td>

                                    <td>
                                        <?php
                                        $tienhaiquan = $items['tienhaiquan'];
                                        $formatted_tienhaiquan = number_format($tienhaiquan, 0, ',', ',');
                                        echo $formatted_tienhaiquan;
                                        ?>
                                    </td>

                                    <td>
                                        <?php
                                        $tiennangha = $items['tiennangha'];
                                        $formatted_tiennangha = number_format($tiennangha, 0, ',', ',');
                                        echo $formatted_tiennangha;
                                        ?>
                                    </td>

                                    <td>
                                        <?php
                                        $tienkhac = $items['tienkhac'];
                                        $formatted_tienkhac = number_format($tienkhac, 0, ',', ',');
                                        echo $formatted_tienkhac;
                                        ?>
                                    </td>

                                    <td>
                                        <?php
                                        $phicauduong = $items['phicauduong'];
                                        $formatted_phicauduong = number_format($phicauduong, 0, ',', ',');
                                        echo $formatted_phicauduong;
                                        ?>
                                    </td>

                                    <td>
                                        <?php
                                        $tienanca = $items['tienanca'];
                                        $formatted_tienanca = number_format($tienanca, 0, ',', ',');
                                        echo $formatted_tienanca;
                                        ?>
                                    </td>

                                    <td>
                                        <?php
                                        $luongchuyen = $items['luongchuyen'];
                                        $formatted_luongchuyen = number_format($luongchuyen, 0, ',', ',');
                                        echo $formatted_luongchuyen;
                                        ?>
                                    </td>

                                    <td>
                                        <?php
                                        $luongchunhat = $items['luongchunhat'];
                                        $formatted_luongchunhat = number_format($luongchunhat, 0, ',', ',');
                                        echo $formatted_luongchunhat;
                                        ?>
                                    </td>

                                    <td>
                                        <?php
                                        $tienthuexengoai = $items['tienthuexengoai'];
                                        $formatted_tienthuexengoai = number_format($tienthuexengoai, 0, ',', ',');
                                        echo $formatted_tienthuexengoai;
                                        ?>
                                    </td>

                                    <td>
                                        <?php
                                        $thuthutuc = $items['thuthutuc'];
                                        $formatted_thuthutuc = number_format($thuthutuc, 0, ',', ',');
                                        echo $formatted_thuthutuc;
                                        ?>
                                    </td>

                                    <td>
                                        <?php
                                        $thukhac = $items['thukhac'];
                                        $formatted_thukhac = number_format($thukhac, 0, ',', ',');
                                        echo $formatted_thukhac;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $giacuocvantai = $items['giacuocvantai'];
                                        $formatted_giacuocvantai = number_format($giacuocvantai, 0, ',', ',');
                                        echo $formatted_giacuocvantai;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $tongdoanhthu = $items['tongdoanhthu'];
                                        $formatted_tongdoanhthu = number_format($tongdoanhthu, 0, ',', ',');
                                        echo $formatted_tongdoanhthu;
                                        ?>
                                    </td>
                                    <td>
                                        <!-- data sửa chữa -->
                                    </td>
                                    <td>
                                        <?php
                                        $tongchi = $items['tongchi'];
                                        $formatted_tongchi = number_format($tongchi, 0, ',', ',');
                                        echo $formatted_tongchi;
                                        ?>
                                    </td>
                                    <td>

                                    </td>

                                    <td>
                                        <?php
                                        $loinhuan = $items['loinhuan'];
                                        $formatted_loinhuan = number_format($loinhuan, 0, ',', ',');
                                        echo $formatted_loinhuan;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $_1_3lợinhuận = $items['1.3% lợi nhuận'];
                                        $formatted__1_3lợinhuận = number_format($_1_3lợinhuận, 0, ',', ',');
                                        echo $formatted__1_3lợinhuận;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $loinhuanthuc = $items['loinhuanthuc'];
                                        $formatted_loinhuanthuc = number_format($loinhuanthuc, 0, ',', ',');
                                        echo $formatted_loinhuanthuc;
                                        ?>
                                    </td>

                                    <td>
                                        <?php echo $items['ghichu']; ?>
                                    </td>
                                </tr>

                            <?php endforeach ?>
                            <?php if ($hasData): ?>
                                <tr class="bg-row-sum">
                                    <td>Tổng cộng</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><?php echo number_format($items['soluongnhienlieu_sum'], 2, '.', ','); ?></td>
                                    <td><?php echo number_format($items['tiennhienlieu_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['tiencuocvo_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['tienhaiquan_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['tiennangha_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['tienkhac_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['phicauduong_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['tienanca_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['luongchuyen_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['luongchunhat_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['tienthuexengoai_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['thuthutuc_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['thukhac_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['giacuocvantai_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['tongdoanhthu_sum'], 0, ',', ','); ?></td>

                                    <td>
                                        <?php echo number_format($resultSC[0]['tongtiensuachua_sum'], 0, ',', ','); ?>
                                    </td>
                                    <td><?php echo number_format($items['tongchi_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['tongchi_sum'] + $resultSC[0]['tongtiensuachua_sum'], 0, ',', ','); ?>
                                    </td>
                                    <td><?php echo number_format($items['loinhuan_sum'] - $resultSC[0]['tongtiensuachua_sum'], 0, ',', ','); ?>
                                    </td>
                                    <td><?php echo number_format(1.3 / 100 * ($items['loinhuan_sum'] - $resultSC[0]['tongtiensuachua_sum']), 0, ',', ','); ?>
                                    </td>
                                    <td><?php echo number_format($items['loinhuan_sum'] - (1.3 / 100 * $items['loinhuan_sum']), 0, ',', ','); ?>
                                    </td>
                                    <td></td>
                                </tr>
                            <?php endif; ?>
                            <tr>
                                <td colspan="29"></td>
                            </tr>

                            <tr class="bg-row-header">
                                <td colspan="31">Tổng lợi nhuận theo từng khách hàng</td>
                            </tr>

                            <?php $count = 1;
                            $hasData = false; // Biến kiểm tra dữ liệu
                            foreach ($resultLoiNhuanUnique as $itemsUniqueLoiNhuan):
                                $hasData = true; // Đánh dấu có dữ liệu     
                                ?>
                                <tr>
                                    <td><?php echo $count++; ?> </td>
                                    <td></td>
                                    <td><?php echo $itemsUniqueLoiNhuan['id_khachhang']; ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="bg-row-sum">
                                        <?php echo $itemsUniqueLoiNhuan['soluongnhienlieu_sum']; ?>
                                    </td>
                                    <td class="bg-row-sum">
                                        <?php
                                        $tiennhienlieu = $itemsUniqueLoiNhuan['tiennhienlieu_sum'];
                                        $formatted_tiennhienlieu = number_format($tiennhienlieu, 0, ',', ',');
                                        echo $formatted_tiennhienlieu;
                                        ?>
                                    </td>
                                    <td class="bg-row-sum">
                                        <?php
                                        $tiencuocvo = $itemsUniqueLoiNhuan['tiencuocvo_sum'];
                                        $formatted_tiencuocvo = number_format($tiencuocvo, 0, ',', ',');
                                        echo $formatted_tiencuocvo;
                                        ?>
                                    </td>
                                    <td class="bg-row-sum">
                                        <?php
                                        $tienhaiquan = $itemsUniqueLoiNhuan['tienhaiquan_sum'];
                                        $formatted_tienhaiquan = number_format($tienhaiquan, 0, ',', ',');
                                        echo $formatted_tienhaiquan;
                                        ?>
                                    </td>
                                    <td class="bg-row-sum">
                                        <?php
                                        $tiennangha = $itemsUniqueLoiNhuan['tiennangha_sum'];
                                        $formatted_tiennangha = number_format($tiennangha, 0, ',', ',');
                                        echo $formatted_tiennangha;
                                        ?>
                                    </td>
                                    <td class="bg-row-sum">
                                        <?php
                                        $tienkhac = $itemsUniqueLoiNhuan['tienkhac_sum'];
                                        $formatted_tienkhac = number_format($tienkhac, 0, ',', ',');
                                        echo $formatted_tienkhac;
                                        ?>
                                    </td>
                                    <td class="bg-row-sum">
                                        <?php
                                        $phicauduong = $itemsUniqueLoiNhuan['phicauduong_sum'];
                                        $formatted_phicauduong = number_format($phicauduong, 0, ',', ',');
                                        echo $formatted_phicauduong;
                                        ?>
                                    </td>
                                    <td class="bg-row-sum">
                                        <?php
                                        $tienanca = $itemsUniqueLoiNhuan['tienanca_sum'];
                                        $formatted_tienanca = number_format($tienanca, 0, ',', ',');
                                        echo $formatted_tienanca;
                                        ?>
                                    </td>
                                    <td class="bg-row-sum">
                                        <?php
                                        $luongchuyen = $itemsUniqueLoiNhuan['luongchuyen_sum'];
                                        $formatted_luongchuyen = number_format($luongchuyen, 0, ',', ',');
                                        echo $formatted_luongchuyen;
                                        ?>
                                    </td>
                                    <td class="bg-row-sum">
                                        <?php
                                        $luongchunhat = $itemsUniqueLoiNhuan['luongchunhat_sum'];
                                        $formatted_luongchunhat = number_format($luongchunhat, 0, ',', ',');
                                        echo $formatted_luongchunhat;
                                        ?>
                                    </td>
                                    <td class="bg-row-sum">
                                        <?php
                                        $tienthuexengoai = $itemsUniqueLoiNhuan['tienthuexengoai_sum'];
                                        $formatted_tienthuexengoai = number_format($tienthuexengoai, 0, ',', ',');
                                        echo $formatted_tienthuexengoai;
                                        ?>
                                    </td>
                                    <td class="bg-row-sum">
                                        <?php
                                        $thuthutuc = $itemsUniqueLoiNhuan['thuthutuc_sum'];
                                        $formatted_thuthutuc = number_format($thuthutuc, 0, ',', ',');
                                        echo $formatted_thuthutuc;
                                        ?>
                                    </td>
                                    <td class="bg-row-sum">
                                        <?php
                                        $thukhac = $itemsUniqueLoiNhuan['thukhac_sum'];
                                        $formatted_thukhac = number_format($thukhac, 0, ',', ',');
                                        echo $formatted_thukhac;
                                        ?>
                                    </td>
                                    <td class="bg-row-sum">
                                        <?php
                                        $giacuocvantai = $itemsUniqueLoiNhuan['giacuocvantai_sum'];
                                        $formatted_giacuocvantai = number_format($giacuocvantai, 0, ',', ',');
                                        echo $formatted_giacuocvantai;
                                        ?>
                                    </td>
                                    <td class="bg-row-sum">
                                        <?php
                                        $tongdoanhthu = $itemsUniqueLoiNhuan['tongdoanhthu_sum'];
                                        $formatted_tongdoanhthu = number_format($tongdoanhthu, 0, ',', ',');
                                        echo $formatted_tongdoanhthu;
                                        ?>
                                    </td>
                                    <td>

                                    </td>
                                    <td class="bg-row-sum">
                                        <?php
                                        $tongchi = $itemsUniqueLoiNhuan['tongchi_sum'];
                                        $formatted_tongchi = number_format($tongchi, 0, ',', ',');
                                        echo $formatted_tongchi;
                                        ?>
                                    </td>
                                    <td>

                                    </td>

                                    <td class="bg-row-sum">
                                        <?php
                                        $loinhuan = $itemsUniqueLoiNhuan['loinhuan_sum'];
                                        $formatted_loinhuan = number_format($loinhuan, 0, ',', ',');
                                        echo $formatted_loinhuan;
                                        ?>
                                    </td>
                                    <td class="bg-row-sum">
                                        <?php
                                        $loinhuan13 = $itemsUniqueLoiNhuan['1_3_loinhuan_sum'];
                                        $formatted_loinhuan13 = number_format($loinhuan13, 0, ',', ',');
                                        echo $formatted_loinhuan13;
                                        ?>
                                    </td>
                                    <td class="bg-row-sum">
                                        <?php
                                        $loinhuanthuc = $itemsUniqueLoiNhuan['loinhuanthuc_sum'];
                                        $formatted_loinhuanthuc = number_format($loinhuanthuc, 0, ',', ',');
                                        echo $formatted_loinhuanthuc;
                                        ?>
                                    </td>

                                    <td></td>
                                </tr>

                            <?php endforeach ?>
                            <?php if ($hasData): ?>
                                <tr class="bg-row-sum">
                                    <td>Tổng cộng</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><?php echo number_format($items['soluongnhienlieu_sum'], 2, '.', ','); ?></td>
                                    <td><?php echo number_format($items['tiennhienlieu_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['tiencuocvo_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['tienhaiquan_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['tiennangha_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['tienkhac_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['phicauduong_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['tienanca_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['luongchuyen_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['luongchunhat_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['tienthuexengoai_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['thuthutuc_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['thukhac_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['giacuocvantai_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['tongdoanhthu_sum'], 0, ',', ','); ?></td>
                                    <td>
                                        <?php echo number_format($resultSC[0]['tongtiensuachua_sum'], 0, ',', ','); ?>
                                    </td>
                                    <td><?php echo number_format($items['tongchi_sum'], 0, ',', ','); ?>
                                    </td>
                                    <td><?php echo number_format($items['tongchi_sum'] + $resultSC[0]['tongtiensuachua_sum'], 0, ',', ','); ?>
                                    </td>
                                    <td><?php echo number_format($items['loinhuan_sum'] - $resultSC[0]['tongtiensuachua_sum'], 0, ',', ','); ?>
                                    </td>
                                    <td><?php echo number_format(1.3 / 100 * ($items['loinhuan_sum'] - $resultSC[0]['tongtiensuachua_sum']), 0, ',', ','); ?>
                                    </td>
                                    <td><?php echo number_format($items['loinhuanthuc_sum'], 0, ',', ','); ?></td>
                                    <td></td>
                                </tr>
                            <?php endif; ?>
                            <?php if (!$hasData): ?>
                                <tr>
                                    <td colspan="100" class="text-center">Không tìm thấy dữ liệu phù hợp!</td>
                                </tr>
                            <?php endif; ?>

                        </tbody>
                    </table>

                </div>

                <script>
                    function exportTableToExcel(tableID) {
                        var downloadLink;
                        var dataType = 'application/vnd.ms-excel';
                        var tableSelect = document.getElementById(tableID);

                        // Clone the table element to preserve the original table
                        var clonedTable = tableSelect.cloneNode(true);


                        // Add CSS styles for borders to the cloned table
                        clonedTable.style.borderCollapse = 'collapse';
                        var cells = clonedTable.getElementsByTagName('td');
                        for (var i = 0; i < cells.length; i++) {
                            cells[i].style.border = '1px solid black';
                        }

                        var headers = clonedTable.getElementsByTagName('th');
                        for (var i = 0; i < headers.length; i++) {
                            headers[i].style.border = '1px solid black';
                        }

                        // Định dạng lại các giá trị ngày tháng trong bảng
                        var cells = clonedTable.getElementsByTagName('td');
                        for (var i = 0; i < cells.length; i++) {
                            var dateValue = cells[i].innerHTML;
                            var formattedDate = dateValue.replace(/(\d{2})-(\d{2})-(\d{4})/g, '$1/$2/$3');
                            cells[i].innerHTML = formattedDate;
                        }

                        // Lấy URL hiện tại
                        var currentURL = window.location.href;

                        // Kiểm tra xem URL có chứa tham số "from_date" và "to_date" hay không
                        if (currentURL.includes("from_date") && currentURL.includes("to_date")) {
                            // Trích xuất giá trị của tham số "from_date" và "to_date" từ URL
                            var urlParams = new URLSearchParams(currentURL);
                            var fromDate = urlParams.get("from_date");
                            var toDate = urlParams.get("to_date");

                            // Kiểm tra nếu giá trị của tham số không rỗng
                            if (fromDate && toDate) {
                                // Tạo filename theo định dạng 'baocaosuachua_from_date_to_date'
                                var filename = 'baocaoloinhuan_' + fromDate + '_' + toDate;
                            }
                        }

                        // Khởi tạo giá trị mặc định cho fromDate và toDate nếu không có trên URL
                        var fromDateDefault, toDateDefault;

                        if (!fromDate || !toDate) {
                            // Lấy ngày tháng hiện tại
                            var currentDate = new Date();
                            var currentYear = currentDate.getFullYear();
                            var currentMonth = ('0' + (currentDate.getMonth() + 1)).slice(-2);
                            var firstDay = '01';
                            var lastDay = new Date(currentYear, currentMonth, 0).getDate();

                            // Tạo chuỗi ngày tháng năm mặc định
                            fromDateDefault = firstDay + '/' + currentMonth + '/' + currentYear;
                            toDateDefault = lastDay + '/' + currentMonth + '/' + currentYear;
                        } else {
                            // Chuyển đổi định dạng ngày từ "yyyy-mm-dd" sang "dd/mm/yyyy"
                            var fromDateParts = fromDate.split("-");
                            var formattedFromDate = fromDateParts[2] + '/' + fromDateParts[1] + '/' + fromDateParts[0];
                            var toDateParts = toDate.split("-");
                            var formattedToDate = toDateParts[2] + '/' + toDateParts[1] + '/' + toDateParts[0];

                            // Gán giá trị đã được định dạng cho fromDate và toDate
                            fromDateDefault = formattedFromDate;
                            toDateDefault = formattedToDate;
                        }

                        // Mã hóa giá trị ngày thành URL-safe
                        var encodedFromDate = encodeURIComponent(fromDateDefault);
                        var encodedToDate = encodeURIComponent(toDateDefault);

                        // Add caption with report title and company name
                        var caption = document.createElement('caption');
                        caption.innerHTML = '<div class="caption-wrapper">'
                            + '<h2>CÔNG TY CỔ PHẦN TIẾP VẬN THÁI BÌNH DƯƠNG</h2><p>Địa chỉ: KCN Đình Vũ, Đông Hải 2, Hải An, Hải Phòng</p>'
                            + '<h3>BẢNG THỐNG KÊ LỢI NHUẬN THEO KHÁCH HÀNG</h3><p>Từ ngày: ' + encodedFromDate + ' - Đến ngày: ' + encodedToDate + '</p>'
                            + '</div>';
                        caption.style.fontWeight = 'bold';
                        caption.style.fontSize = '16px';
                        caption.style.color = 'blue';
                        clonedTable.insertBefore(caption, clonedTable.firstChild);

                        var tableHTML = clonedTable.outerHTML.replace(/ /g, '%20');


                        // Nếu không tìm thấy tham số hoặc giá trị của tham số rỗng
                        if (!filename) {
                            // Lấy ngày tháng năm hiện tại
                            var currentDate = new Date();
                            var year = currentDate.getFullYear();
                            var month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
                            var firstDay = '01';
                            var lastDay = new Date(year, month, 0).getDate();

                            // Tạo filename theo định dạng 'baocaosuachua_firstDay_lastDay'
                            filename = 'baocaoloinhuan_' + year + '-' + month + '-' + firstDay + '_' + year + '-' + month + '-' + lastDay;
                        }

                        // Create download link element
                        downloadLink = document.createElement("a");

                        document.body.appendChild(downloadLink);

                        if (navigator.msSaveOrOpenBlob) {
                            var blob = new Blob(['\ufeff', tableHTML], {
                                type: dataType
                            });
                            navigator.msSaveOrOpenBlob(blob, filename);
                        } else {
                            // Create a link to the file
                            downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

                            // Setting the file name
                            downloadLink.download = filename;

                            // Trigger the download
                            downloadLink.click();
                        }
                    }
                </script>


            </div>
            <!-- /.container-fluid -->
            <?php
            include ('includes/footer.php');
            // include ('includes/scripts.php');
            ?>

        </div>
        <!-- End of Main Content -->
        <script>

            // tìm kiếm change text search
            $(document).ready(function () {
                $('.search-input').on('input', function () {
                    var searchText = $(this).val().toLowerCase();
                    $('#myTable tbody tr').each(function () {
                        var rowData = $(this).text().toLowerCase();
                        if (rowData.indexOf(searchText) === -1) {
                            $(this).hide();
                        } else {
                            $(this).show();
                        }
                    });
                });
            });


        </script>


        <?php
        // include ('includes/footer.php');
        include ('includes/scripts.php');
        ?>