<head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.17.1/bootstrap-table.min.css"/>
<style>
    .img-thumb-path{
        width:100px;
        height:80px;
        object-fit:scale-down;
        object-position:center center;
    }
    .container_swap{
        width: auto;
        padding-left: 16px;
        padding-top: 6px;
        padding-right: 16px;
    }   
    .div_filter{
        width: 30%;
        float: left;
        text-align: left;
    }
    .div_left{
        width: 85%;
        padding-right: 10px;
        float: left;
        text-align: center;    
    }     
    .div_right{    
        width: 15%;
        float: left;
        text-align: center;
    }
</style>
</head>
<?php
    $id = intval($_GET['id']);
    $connect = mysqli_connect("localhost", "root", "", "csms_db");
    if(!$connect){
        die("Không thể kết nối đến cơ sở dữ liệu: " . mysqli_error($connect));
    }
    mysqli_select_db($connect,"csms_db");
    if(isset($id)):
        switch($id){
            case '1':
                $year = intval($_GET['year']);
                $sql = "SELECT b.*,s.Ten_thiet_bi as storage FROM `booking_list` b inner join `thiet_bi_uit` s on b.storage_id = s.id WHERE YEAR(b.date_from)=(".$year.")";
                break;
            case '2';
                $year = intval($_GET['year']);
                $month = intval($_GET['month']);
                $sql = "SELECT b.*,s.Ten_thiet_bi as storage FROM `booking_list` b inner join `thiet_bi_uit` s on b.storage_id = s.id WHERE MONTH(b.date_from)=(".$month.") AND YEAR(b.date_from)=(".$year.")";
                break;
            case '3':
                $year = intval($_GET['year']);
                $month = intval($_GET['month']);
                $date = intval($_GET['date']);
                $sql = "SELECT b.*,s.Ten_thiet_bi as storage FROM `booking_list` b inner join `thiet_bi_uit` s on b.storage_id = s.id WHERE DATE(b.date_from)='".$year."-".$month."-".$date."'";
                break;
            case '4':
                $sql = "SELECT b.*,s.Ten_thiet_bi as storage FROM `booking_list` b inner join `thiet_bi_uit` s on b.storage_id = s.id WHERE b.date_to < NOW() AND b.da_tra = 0";
                break;
            case '5':
                $device = $_GET['device'];
                $sql = "SELECT b.*,s.Ten_thiet_bi as storage FROM `booking_list` b inner join `thiet_bi_uit` s on b.storage_id = s.id WHERE b.storage_id='".$device."'";
                break;
        }
    endif;
        $result = mysqli_query($connect,$sql);
        echo "<table class='table table-hover table-striped'>
        <colgroup>
            <col width='5%'>
            <col width='15%'>
            <col width='15%'>
            <col width='20%'>
            <col width='20%'>
            <col width='15%'>
            <col width='15%'>
        </colgroup>
        <thead>
            <tr>
                <th>#</th>
                <th class='text-center'>Ngày tạo</th>
                <th class='text-center'>Mã đặt</th>
                <th class='text-center'>Tên người mượn</th>
                <th class='text-center'>Tên thiết bị</th>
                <th class='text-center'>Ngày mượn từ</th>
                <th class='text-center'>Đến</th>
            </tr>
        </thead>";
                echo "<tbody>";
                while($row = mysqli_fetch_array($result)){
                    echo "<tr>";
                    echo "<td class='text-center'>".$row['id']."</td>";
                    echo "<td class=''>".date("d/m/Y",strtotime($row['date_created']))."</td>";
                    echo "<td class='text-center'>".$row['book_code']."</td>";
                    echo "<td class='text-center'>".ucwords($row['client_name'])."</td>";
                    echo "<td class='text-center'>".ucwords($row['storage'])."</td>";
                    echo "<td class=''>".date("d/m/Y",strtotime($row['date_from']))."</td>";
                    echo "<td class=''>".date("d/m/Y",strtotime($row['date_to']))."</td>";
                echo "</tr>";
                }
                echo "</tbody>";
            echo "</table>";
            mysqli_close($connect);
            ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.20.1/bootstrap-table.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.17.1/extensions/filter-control/bootstrap-table-filter-control.min.js"></script>