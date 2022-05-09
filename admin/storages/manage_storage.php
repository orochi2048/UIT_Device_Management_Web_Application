<?php
require_once('../../config.php');
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `storage_list` where id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
    }
}
?>
<style>
    #cimg{
        object-fit:scale-down;
        object-position:center center;
        height:200px;
        width:200px;
    }
</style>
<div class="container-fluid">
    <form action="" id="storage-form">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div class="form-group">
            <label for="name" class="control-label">Tên thiết bị</label>
            <input type="text" name="name" id="name" class="form-control form-control-border" placeholder="Tên thiết bị" value ="<?php echo isset($name) ? $name : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="description" class="control-label">Mô tả</label>
            <textarea rows="3" name="description" id="description" class="form-control form-control-border summernote" placeholder="Điền mô tả thiết bị tại đây." required><?php echo isset($description) ? $description : '' ?></textarea>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="img" class="control-label text-muted">Chọn hình đại diện</label>
                <input type="file" id="img" name="img" class="form-control form-control-border" accept="image/png,image/jpeg" onchange="displayImg(this,$(this))">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <center>
                    <img src="<?= validate_image(isset($thumbnail_path) ? $thumbnail_path : "") ?>" alt="Cold Storage Image" id="cimg" class="bg-gradient-dark">
                </center>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Trạng thái</label>
            <select name="status" id="status" class="form-control form-control-border" required>
                <option value="2" <?= isset($status) && $status == 2 ? "selected" :"" ?>>Đã mượn</option>
                <option value="1" <?= isset($status) && $status == 1 ? "selected" :"" ?>>Có sẵn</option>
                <option value="0" <?= isset($status) && $status == 0 ? "selected" :"" ?>>Bị hỏng</option>
            </select>
        </div>
    </form>
</div>
<script>
     function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }else{
            $('#cimg').attr('src', "<?= validate_image(isset($thumbnail_path) ? $thumbnail_path : "") ?>");
        }
	}
    $(function(){
        $('#uni_modal #storage-form').submit(function(e){
            e.preventDefault();
            var _this = $(this)
            $('.pop-msg').remove()
            var el = $('<div>')
                el.addClass("pop-msg alert")
                el.hide()
            start_loader();
            $.ajax({
                url:_base_url_+"classes/Master.php?f=save_storage",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
                success:function(resp){
                    if(resp.status == 'success'){
                        location.reload();
                    }else if(!!resp.msg){
                        el.addClass("alert-danger")
                        el.text(resp.msg)
                        _this.prepend(el)
                    }else{
                        el.addClass("alert-danger")
                        el.text("An error occurred due to unknown reason.")
                        _this.prepend(el)
                    }
                    el.show('slow')
                    $('html,body,.modal').animate({scrollTop:0},'fast')
                    end_loader();
                }
            })
        })
    })
</script>