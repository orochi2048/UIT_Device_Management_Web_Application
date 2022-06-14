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
    $connect = mysqli_connect("localhost", "root", "123456789", "csms_db");
    if(!$connect){
        die("Không thể kết nối đến cơ sở dữ liệu: " . mysqli_error($connect));
    }
    mysqli_select_db($connect,"csms_db");
    $sql = "SELECT * FROM `storage_list` WHERE YEAR(date_created)=(".$id.")";
    $result = mysqli_query($connect,$sql);
    echo "<table class='table table-hover table-striped myTable' id='table' data-search='true' data-toggle='table' data-filter-control='true' data-click-to-select='true' data-toolbar='#toolbar'>
    <colgroup>
        <col width='5%'>
        <col width='20%'>
        <col width='15%'>
        <col width='35%'>
        <col width='10%'>
    </colgroup>
    <thead>
        <tr>
            <th class='text-center' data-sortable='true'>#</th>
            <th class='text-center' data-field='date' data-filter-control='select' data-sortable='true'>Ngày tạo</th>
            <th class='text-center'>Hình minh họa</th>
            <th class='text-center' data-field='name' data-filter-control='select' data-sortable='true'>Tên</th>
            <th class='text-center' data-field='status' data-filter-control='select' data-sortable='true'>Trạng thái</th>
        </tr>
    </thead>
    ";
    echo "<tbody>";
    while($row = mysqli_fetch_array($result)){
        echo "<tr>";
        echo "<td class='text-center'>".$row['id']."</td>";
        echo "<td class=''>".date("Y-m-d H:i",strtotime($row['date_created']))."</td>";
        echo "<td class='text-center'>";
            echo "<img src='= validate_image(".$row['thumbnail_path']."?".$row['thumbnail_path']."') alt='Storage Image' class='img-thumbnail bg-gradient-dark img-thumb-path'>"; 
        echo "</td>";
        echo "<td>".ucwords($row['name'])."</td>";
        echo "<td class='text-center'>";
            switch($row['status']){
                case '2':
                    echo "Đã mượn";
                    break;
                case '1':
                    echo "Có sẵn";
                    break;
                case '0':
                    echo "Bị hỏng";
                    break;
            }
        echo "</td>";
    echo "</tr>";
    }
    echo "</tbody>";
echo "</table>";
mysqli_close($connect);
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.20.1/bootstrap-table.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.17.1/extensions/filter-control/bootstrap-table-filter-control.min.js"></script>