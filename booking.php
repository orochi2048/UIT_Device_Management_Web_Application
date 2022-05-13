<div class="content py-3">
    <div class="container-fluid">
        <h3 class="text-center"><b>Form đăng ký mượn thiết bị</b></h3>
        <hr class="bg-navy">
        <?php if($_settings->chk_flashdata('pop_msg')): ?>
            <div class="alert alert-success">
                <i class="fa fa-check mr-2"></i> <?= $_settings->flashdata('pop_msg') ?>
            </div>
            <script>
                $(function(){
                    $('html, body').animate({scrollTop:0})
                })
            </script>
        <?php endif; ?>
        <div class="card card-outline card-info rounded-0 shadow">
            <div class="card-body rounded-0">
                <div class="container-fluid">
                    <form action="" id="booking-form">
                        <input type="hidden" name="id" value="">
                        <fieldset>
                            <legend class="text-info">Thông tin người mượn</legend>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <input type="text" id="fullname" name="fullname" autofocus class="form-control form-control-sm form-control-border" placeholder="Họ và tên" required>
                                    <small class="text-muted px-4">Họ và tên</small>
                                </div>
                                <div class="form-group col-md-4">
                                    <input type="text" id="MSSV" name="MSSV" autofocus class="form-control form-control-sm form-control-border" placeholder="Mã số sinh viên" required>
                                    <small class="text-muted px-4">Mã số sinh viên</small>
                                </div>
                                <div class="form-group col-md-4">
                                    <input type="text" id="ClassID" name="ClassID" autofocus class="form-control form-control-sm form-control-border" placeholder="Mã lớp" required>
                                    <small class="text-muted px-4">Mã lớp</small>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-md-4 form-group">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <small class="text-muted">Giới tính</small>
                                        </div>
                                        <div class="form-group col-auto">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="genderMale" name="gender" value="Male" required checked>
                                                <label for="genderMale" class="custom-control-label">Nam</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-auto">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="genderFemale" name="gender" value="Female">
                                                <label for="genderFemale" class="custom-control-label">Nữ</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <input type="text" id="contact" name="contact" class="form-control form-control-sm form-control-border" placeholder="Contact" required>
                                    <small class="text-muted px-4">Số điện thoại</small>
                                </div>
                                <div class="form-group col-md-4">
                                    <input type="text" id="email" name="email" class="form-control form-control-sm form-control-border" placeholder="Email" required>
                                    <small class="text-muted px-4">Email</small>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend class="text-info">Thông tin mượn thiết bị</legend>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <small class="text-muted px-4">Thiết bị</small>
                                    <select name="storage_id" id="storage_id" class="form-control form-control-border select2" data-placeholder="Vui lòng chọn thiết bị tại đây" required>
                                        <option value="" disabled selected></option>
                                        <?php 
                                        $storage_arr = [];
                                        $storage = $conn->query("SELECT * FROM `thietbi_2017` where Da_hu =0 order by `Ten_thiet_bi` asc ");
                                        while($row = $storage->fetch_assoc()):
                                            $storage_arr[$row['id']] = $row;
                                        ?>
                                        <option value="<?= $row['Ky_hieu'] ?>"><?= $row['Ten_thiet_bi'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <small class="text-muted px-4">Số lượng</small>
                                    <select name="type" id="type" class="form-control form-control-border select2" data-placeholder="Vui lòng chọn số lượng tại đây" required>
                                        <option value="" disabled selected></option>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <input type="date" id="date_from" name="date_from" class="form-control form-control-sm form-control-border" placeholder="Ngày mượn từ" required>
                                    <small class="text-muted px-4">Ngày mượn từ</small>
                                </div>
                                <div class="form-group col-md-4">
                                    <input type="date" id="date_to" name="date_to" class="form-control form-control-sm form-control-border" placeholder="Đến" required>
                                    <small class="text-muted px-4">Đến</small>
                                </div>
                            </div>
                            <hr class="">
                            <table class="table table-bordered" id="other-info">
                                <colgroup>
                                    <col width="30%">
                                    <col width="70%">
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <th>Mô tả </th>
                                        <td id="storage-description">-----</td>
                                    </tr>
                                    <tr>
                                        <th>Số ngày mượn <input type="hidden" name="storing_days"></th>
                                        <td id="storage-days" class="text-right">--</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <small class="text-muted">Thông tin khác</small>
                                    <textarea name="other_info" id="other_info" rows="3" style="resize:none" class="form-control form-control-sm rounded-0" placeholder="Điền thông tin khác (nếu có) tại đây."></textarea>
                                </div>
                            </div>
                        </fieldset>
                        <hr class="bg-navy">
                        <center>
                            <button class="btn btn-sm bg-primary btn-flat mx-2 col-3">Nộp form</button>
                            <a class="btn btn-sm btn-light border btn-flat mx-2 col-3" href="./">Hủy</a>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var storage = $.parseJSON('<?= json_encode($storage_arr) ?>');
    function calc_amount(){
        var days = $('input[name="storing_days"]').val()
        var cost = $('input[name="cost"]').val()
        var amount = 0
        if(days > 0 && cost > 0){
            amount = parseFloat(cost) * parseFloat(days)
        }
        $('#storage-amount').text(parseFloat(amount).toLocaleString('en-US',{style:'decimal',minimumFractionDigits:2,maximumFractionDigits:2}))
        $('input[name="amount"]').val(amount)
    }
    function submit_booking(){
        var _this = $("#booking-form")
            $('.pop-msg').remove()
            var el = $('<div>')
                el.addClass("pop-msg alert")
                el.hide()
            start_loader();
            $.ajax({
                url:_base_url_+"classes/Master.php?f=save_booking",
				data: new FormData($("#booking-form")[0]),
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
                    $('html, body').animate({scrollTop:0},'fast')
                    end_loader();
                }
            })
    }
    $(function(){
        $('.select2').each(function(){
            var _this = $(this)
            _this.select2({
                placeholder:_this.attr('data-placeholder') || 'Please Select Here',
                width:'100%'
            })
        })
        $('#storage_id').change(function(){
            var sid = $(this).val()
            if(!!storage[sid]){
                var data = storage[sid]
                $('#storage-description').html(data.description)
                $('#storage-cost').text(parseFloat(data.cost).toLocaleString('en-US',{style:'decimal',minimumFractionDigits:2,maximumFractionDigits:2}))
                $('input[name="cost"]').val(data.cost)
            }
            calc_amount()
        })
        $('#date_from,#date_to').change(function(){
            var date_from = $('#date_from').val()
            var date_to = $('#date_to').val()
            var days = 0;
            if(date_from != '' && date_to != ''){
                date_from = new Date(date_from)
                date_to = new Date(date_to)
                var diff = date_to.getTime() - date_from.getTime();
                days = Math.floor(diff / (1000 * 3600 * 24))
            }

            $('input[name="storing_days"]').val(days)
            $('#storage-days').text((days).toLocaleString('en-US'))
            calc_amount()
        })
        $('#booking-form').submit(function(e){
            e.preventDefault()
            _conf("Hãy đảm bảo rằng bạn đã kiểm tra mọi thông tin trước khi nộp yêu cầu.","submit_booking",[])
            
        })
    })
</script>