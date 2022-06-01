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
				<select data-filter="name col-sm-3" class="filter-name filter form-control div_filter" onchange="CustomFilter(this)">
					<option value="">-----Chọn-----</option>
					<option value="nam">Theo Năm</option>
					<option value="thang">Theo Tháng</option>
					<option value="ngay">Theo Ngày</option>
					<option value="quahan">Quá Hạn</option>
				</select>
                <input type="year" id="start" name="start">
			</div>
		</form>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-hover table-striped myTable" id="table" data-search="true" data-toggle="table" data-filter-control="true" data-click-to-select="true" data-toolbar="#toolbar">
				<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="15%">
					<col width="35%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center" data-sortable="true">#</th>
						<th class="text-center" data-field="date" data-filter-control="select" data-sortable="true">Ngày tạo</th>
						<th class="text-center">Hình minh họa</th>
						<th class="text-center" data-field="name" data-filter-control="select" data-sortable="true">Tên</th>
						<th class="text-center" data-field="status" data-filter-control="select" data-sortable="true">Trạng thái</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$i = 1;
						$qry = $conn->query("SELECT * from `storage_list`order by `name` asc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class=""><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
							<td class="text-center">
								<img src="<?= validate_image($row['thumbnail_path'] ? $row['thumbnail_path'] : "") ?>" alt="Storage Image" class="img-thumbnail bg-gradient-dark img-thumb-path">
							</td>
							<td><?php echo ucwords($row['name']) ?></td>
							<td class="text-center">
                                <?php
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
                                ?>
                            </td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>
<script>
var doc = document, win = window;
var func = {
CreateOjb: function()
{
    var xmlhttp;
    if(win.XMLHttpRequest)
    {
        xmlhttp = new XMLHttpRequest();
    }
    else if(win.ActiveXObject)
    {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }  
    else
    {
        xmlhttp = null;
    }
    return xmlhttp;
},
get:function()
{
    var http = func.CreateOjb();
    http.onreadystatechange = function()
    {
        if(http.readyState == 4)
        {
        doc.getElementById("Show").innerHTML = http.responseText;
        }
    }
}
http.open('get','test-2.php?value=' + doc.getElementById("value").value);
http.send(null);
$(document).ready(function() {
   $('#myInput').on('keyup', function(event) {
      event.preventDefault();
      /* Act on the event */
      var tukhoa = $(this).val().toLowerCase();
      $('#table tr').filter(function() {
         $(this).toggle($(this).text().toLowerCase().indexOf(tukhoa)>-1);
      });
   });
});

/* var $table = $('#table');
    $(function () {
        $('#toolbar').find('select').change(function () {
            $table.bootstrapTable('refreshOptions', {
                exportDataType: $(this).val()
            });
        });
    })
*/
function CustomFilter(obj){
	var value = obj.value;
    if (value === ''){
    }
    else if (value === 'nam'){
      $('#start').attr('type','year');
      var tukhoa = "";
      $('#table tr').filter(function() {
         $(this).toggle($(this).text().toLowerCase().indexOf(tukhoa)>-1);
      });
    }
    else if (value === 'thang'){
      $('#start').attr('type','month');
    }
    else if (value === 'ngay'){
      $('#start').attr('type','date');
    }
    else if (value === 'quahan'){
      $('#start').attr('type','date');
    }
}
</>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.20.1/bootstrap-table.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.17.1/extensions/filter-control/bootstrap-table-filter-control.min.js"></script>