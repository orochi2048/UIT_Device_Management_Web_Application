<style>
    .img-thumb-path{
        width:100px;
        height:80px;
        object-fit:scale-down;
        object-position:center center;
    }
</style>
<div class="card card-outline card-primary rounded-0 shadow">
	<div class="card-header">
		<h3 class="card-title">Danh sách thiết bị</h3>
		<div class="card-tools">
			<a href="javascript:void(0)" id="create_new" class="btn btn-flat btn-sm btn-primary"><span class="fas fa-plus"></span>  Thêm thiết bị mới</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-hover table-striped">
				<colgroup>
					<col width="5%">
					<col width="10%">
					<col width="15%">
					<col width="30%">
					<col width="5%">
					<col width="5%">
					<col width="10%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>ID</th>
						<th>Hình minh họa</th>
						<th>Tên thiết bị</th>
						<th>Số lượng</th>
						<th>Đã hư</th>
						<th>Trạng thái</th>
						<th>Hành động</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$i = 1;
						$qry = $conn->query("SELECT * from `thiet_bi_uit`order by `Ten_thiet_bi` asc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo ucwords($row['ID']) ?></td>
							<td class="text-center">
								<img src="<?= validate_image($row['thumbnail_path'] ? $row['thumbnail_path'] : "") ?>" alt="Storage Image" class="img-thumbnail bg-gradient-dark img-thumb-path">
							</td>
							<td><?php echo ucwords($row['Ten_thiet_bi']) ?></td>
							<td><?php echo ucwords($row['So_luong']) ?></td>
							<td><?php echo ucwords($row['Da_hu']) ?></td>
							<td class="text-center">
                                <?php
                                    switch($row['Status']){
                                        case '2':
											echo "<span class='badge badge-secondary badge-pill'>Đã mượn</span>";
											break;
										case '1':
											echo "<span class='badge badge-success badge-pill'>Có sẵn</span>";
											break;
										case '0':
											echo "<span class='badge badge-danger badge-pill'>Bị hỏng</span>";
											break;
                                    }
                                ?>
                            </td>
							<td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Hành động
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item view_data" href="javascript:void(0)" data-id ="<?php echo $row['ID'] ?>"><span class="fa fa-eye text-dark"></span> Xem</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item edit_data" href="javascript:void(0)" data-id ="<?php echo $row['ID'] ?>"><span class="fa fa-edit text-primary"></span> Sửa</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['ID'] ?>"><span class="fa fa-trash text-danger"></span> Xóa</a>
				                  </div>
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
	$(document).ready(function(){
        $('#create_new').click(function(){
			uni_modal("Thêm thiết bị mới","storages/manage_storage.php", 'mid-large')
		})
        $('.edit_data').click(function(){
			uni_modal("Cập nhật thông tin thiết bị","storages/manage_storage.php?id="+$(this).attr('data-id'), 'mid-large')
		})
		$('.delete_data').click(function(){
			_conf("Bạn có chắc muốn xóa thitế bị?","delete_storage",[$(this).attr('data-id')])
		})
		$('.view_data').click(function(){
			uni_modal("Thông tin thiết bị","storages/view_storage.php?id="+$(this).attr('data-id'), 'mid-large')
		})
		$('.table td, .table th').addClass('py-1 px-2 align-middle')
		$('.table').dataTable({
            columnDefs: [
                { orderable: false, targets: 5 }
            ],
        });

		$("#uni_modal").on('show.bs.modal',function(e){
			$('.summernote').summernote({
		        height: '30vh',
		        toolbar: [
		            [ 'style', [ 'style' ] ],
		            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
		            [ 'fontname', [ 'fontname' ] ],
		            [ 'fontsize', [ 'fontsize' ] ],
		            [ 'color', [ 'color' ] ],
		            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
		            [ 'table', [ 'table' ] ],
					['insert', ['link', 'picture']],
		            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
		        ]
		    })
		})
	})
	function delete_storage($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_storage",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>