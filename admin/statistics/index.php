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
    #date-input{
        width: 25%;
    }
    #year-device-input{
        width: 25%;
    }
</style>
</head>
<div class="card card-outline card-primary rounded-0 shadow">
	<div class="card-header">
		<h3 class="card-title">Danh sách yêu cầu mượn thiết bị đã duyệt</h3>
	</div>
    <!-- <div class="container_swap" id="search">
        <form id="search-form" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group col-xs-9 div_left">
                <input class="form-control" id="myInput" onkeyup="myFunction()" type="text" placeholder="Nhập từ khóa" />
            </div>
        </form>
    </div> -->
    <div class="container_swap" id="filter">
		<form>
			<div class="form-group">
				<select data-filter="name col-sm-3" id="id-option" class="filter-name filter form-control div_filter" onchange="showTable(this.value)">
					<option value="">-----Chọn-----</option>
					<option value="1">Theo Năm</option>
					<option value="2">Theo Tháng</option>
					<option value="3">Theo Ngày</option>
					<option value="4">Quá Hạn</option>
                    <option value="5">Số Lượt Mượn Của Một Thiết Bị</option>
                    <option value="6">Số Lượt Mượn Của Một Thiết Bị Theo Năm</option>
				</select>
                <input type="hidden" id="date-input" name="date-input" placeholder="" required>
                <input type="hidden" id="year-device-input" name="year-device-input">
                <input type="submit" id="statistic" name="result">
			</div>
		</form>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid" id="container-table">
            
		</div>
		</div>
	</div>
</div>
<script>
function showTable(id_option){
	if(id_option==""){
		document.getElementById("container-table").innerHTML = "";
        $('#date-input').attr('type','hidden');
    }
    if(id_option=="1"){
        $('#year-device-input').attr('type', 'hidden');
        $('#date-input').attr('type','year');
        $('#date-input').attr('placeholder','Nhập năm (VD: 2022)');
	}
    if(id_option=="2"){
        $('#year-device-input').attr('type', 'hidden');
        $('#date-input').attr('type','month');
    }
    if(id_option=="3"){
        $('#year-device-input').attr('type', 'hidden');
        $('#date-input').attr('type','date');
    }
    if(id_option=="4"){
        $('#year-device-input').attr('type', 'hidden');
        $('#date-input').attr('type','hidden');
    }
    if(id_option=="5"){
        $('#year-device-input').attr('type', 'hidden');
        $('#date-input').attr('type','string');
        $('#date-input').attr('placeholder','Nhập ID thiết bị (VD: TB.2017.01)');
    }
    if(id_option=="6"){
        $('#year-device-input').attr('type', 'year');
        $('#date-input').attr('type','string');
        $('#date-input').attr('placeholder','Nhập ID thiết bị (VD: TB.2017.01)');
        $('#year-device-input').attr('placeholder','Nhập Năm (VD: 2022)');
    }
}

$(document).ready(function () {
    // Bắt sự kiện khi người dùng click vào button
    $('#statistic').click(function (e) {
        // Ngăn không cho load lại trang
        e.preventDefault();
        //Lấy giá trị ngày tháng năm của ô input
        let ymd = $('#date-input').val().split("-");
        let year = ymd[0];
        let month = ymd[1];
        let date = ymd[2];
        let device = $('#date-input').val()
        let id = document.getElementById("id-option").value;
        // Gửi request đến file table.php để xử lý với tham số là year,month,date
        var myRequest = new XMLHttpRequest();
        myRequest.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("container-table").innerHTML = this.responseText;
            }
        };
            myRequest.open("GET","statistics/table.php?id=" + id + "&year=" + year + "&month=" + month + "&date=" + date + "&device=" + device,true);
            myRequest.send(null); 
        });
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.20.1/bootstrap-table.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.17.1/extensions/filter-control/bootstrap-table-filter-control.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>