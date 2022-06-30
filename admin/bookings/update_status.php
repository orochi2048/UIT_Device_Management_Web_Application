<?php
require_once('../../config.php');
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT b.*,s.Ten_thiet_bi as storage from `booking_list` b inner join `thiet_bi_uit` s on b.storage_id = s.ID where b.ID = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
    $meta_qry = $conn->query("SELECT * FROM `booking_details` where booking_id = '{$id}'");
    if($meta_qry->num_rows > 0){
        while($row = $meta_qry->fetch_assoc()){
            ${$row['meta_field']} = $row['meta_value'];
        }
    }
    }
}
?>
<div class="container-fluid">
    <form action="" id="update_status_form">
        <input type="hidden" name="id" value="<?= isset($_GET['id']) ? $_GET['id'] : "" ?>">
        <div class="form-group">
            <label for="status" class="control-label text-navy">Trạng thái</label>
            <select name="status" id="status" class="form-control form-control-border" required>
                <option value="0" <?= isset($status) && $status == 0 ? "selected" : "" ?>>Chưa duyệt</option>
                <option value="1" <?= isset($status) && $status == 1 ? "selected" : "" ?>>Đã duyệt</option>
                <option value="2" <?= isset($status) && $status == 2 ? "selected" : "" ?>>Đã hủy</option>
            </select>
            <label for="da_tra" class="control-label text-navy">Đã trả hay chưa?</label>
            <select name="da_tra" id="da_tra" class="form-control form-control-border" required>
                <option value="0" <?= isset($da_tra) && $da_tra == 0 ? "selected" : "" ?>>Chưa trả</option>
                <option value="1" <?= isset($da_tra) && $da_tra == 1 ? "selected" : "" ?>>Đã trả</option>
            </select>
        </div>
        <div class="form-group">
            <label for="remarks" class="control-label text-navy">Ghi chú</label>
            <textarea name="remarks" id="remarks" rows="3" class="form-control form-control-sm rounded-0" style="resize:none" placeholder="Điền ghi chú của bạn vào đây."><?= isset($remarks) ? $remarks : '' ?></textarea>
        </div>
    </form>
</div>
<script>
    $(function(){
        $('#update_status_form').submit(function(e){
            e.preventDefault()
            start_loader()
            var el = $('<div>')
                el.addClass("pop-msg alert")
                el.hide()
            $.ajax({
                url:_base_url_+"classes/Master.php?f=update_status",
                method:"POST",
                data:$(this).serialize(),
                dataType:"json",
                error:err=>{
                    console.log(err)
                    alert_toast("An error occured while saving the data,", "error")
                    end_loader()
                },
                success:function(resp){
                    if(resp.status == 'success'){
                        location.reload()
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
                    end_loader();
                }
            })
        })
    })
</script>