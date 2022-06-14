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
<div class="card card-outline card-primary rounded-0 shadow">
	<div class="card-header">
		<h3 class="card-title">Danh sách thiết bị</h3>
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
				<select data-filter="name col-sm-3" class="filter-name filter form-control div_filter" onchange="showTable(this.value)">
					<option value="">-----Chọn-----</option>
					<option value="2021">Theo Năm</option>
					<option value="2">Theo Tháng</option>
					<option value="3">Theo Ngày</option>
					<option value="4">Quá Hạn</option>
				</select>
                <input type="year" id="start" name="start">
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
/* var $table = $('#table');
    $(function () {
        $('#toolbar').find('select').change(function () {
            $table.bootstrapTable('refreshOptions', {
                exportDataType: $(this).val()
            });
        });
    })
*/
/*function CustomFilter(obj){
	var value = obj.value;
    if (value === ''){
    }
    else if (value === '1'){
      $('#start').attr('type','year');
      var tukhoa = "";
      $('#table tr').filter(function() {
         $(this).toggle($(this).text().toLowerCase().indexOf(tukhoa)>-1);
      });
    }
    else if (value === '2'){
      $('#start').attr('type','month');
    }
    else if (value === '3'){
      $('#start').attr('type','date');
    }
    else if (value === '4'){
      $('#start').attr('type','date');
    }
}*/

function showTable(id_option){
	if(id_option==""){
		document.getElementById("container-table").innerHTML = "";
	}if(id_option=="2021"){
		var myRequest = new XMLHttpRequest();
		myRequest.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("container-table").innerHTML = this.responseText;
		}
	};
	    myRequest.open("GET","statistics/table.php?id=" + id_option,true);
	    myRequest.send(null); 
	}
	else{
		document.getElementById("container-table").innerHTML = "";
	}
}
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.20.1/bootstrap-table.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.17.1/extensions/filter-control/bootstrap-table-filter-control.min.js"></script>