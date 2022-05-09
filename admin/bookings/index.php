<style>
    .img-avatar{
        width:45px;
        height:45px;
        object-fit:cover;
        object-position:center center;
        border-radius:100%;
    }
</style>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Danh sách yêu cầu mượn thiết bị</h3>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-hover table-striped">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="15%">
					<col width="20%">
					<col width="20%">
					<col width="10%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Ngày tạo</th>
						<th>Mã đặt</th>
						<th>Tên người mượn</th>
						<th>Tên thiết bị</th>
						<th>Trạng thái</th>
						<th>Hành động</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$i = 1;
						$qry = $conn->query("SELECT b.*,s.name as storage from `booking_list` b inner join `storage_list` s on b.storage_id = s.id order by b.`status` asc, unix_timestamp(b.date_created) desc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class=""><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
							<td><?php echo ($row['book_code']) ?></td>
							<td><?php echo ucwords($row['client_name']) ?></td>
							<td><?php echo ucwords($row['storage']) ?></td>
							<td class="text-center">
								<?php
                                    switch($row['status']){
										case '2':
                                            echo "<span class='badge badge-danger badge-pill'>Đã hủy</span>";
                                            break;
                                        case '1':
                                            echo "<span class='badge badge-success badge-pill'>Đã duyệt</span>";
                                            break;
                                        case '0':
                                            echo "<span class='badge badge-secondary badge-pill'>Chờ duyệt</span>";
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
				                    <a class="dropdown-item" href="./?page=bookings/view_details&id=<?php echo $row['id'] ?>" data-id=""><span class="fa fa-window-restore text-gray"></span> Xem</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item update_status" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" data-status="<?php echo $row['status'] ?>"  data-code="<?php echo $row['book_code'] ?>"><span class="fa fa-check text-dark"></span> Cập nhật trạng thái</a>
									<div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" data-code="<?php echo $row['book_code'] ?>"><span class="fa fa-trash text-danger"></span> Xóa</a>
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
		$('.delete_data').click(function(){
			_conf("Bạn có chắc muốn xóa <b>"+$(this).attr('data-code')+"\'s</b> từ danh sách yêu cầu mượn?","delete_booking",[$(this).attr('data-id')])
		})
		$('.update_status').click(function(){
            uni_modal("Cập nhật <b>"+$(this).attr('data-code')+"\'s</b> Trạng thái","bookings/update_status.php?id="+$(this).attr('data-id'),"mid-large")
        })
		$('.view_details').click(function(){
			uni_modal("Thông tin mượn thiết bị", "booking/view_details.php?id="+$(this).attr('data-id'),'large')
		})
		$('.table td,.table th').addClass('py-1 px-2 align-middle')
		$('.table').dataTable({
            columnDefs: [
                { orderable: false, targets: 5 }
            ],
        });
	})
	function delete_booking($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_booking",
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