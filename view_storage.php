<?php
require_once('./config.php');
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `thiet_bi_uit` where ID = '{$_GET['id']}'");
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
    #uni_modal .modal-footer{
        display:none !important;
    }
    #thumb-path{
        width:calc(100%);
        height:40vh;
        object-fit:scale-down;
        object-position:center center;
    }
</style>
<div class="container-fluid">
    <dl>
        <dt class="text-muted"></dt>
        <dd class="text-center">
            <img src="<?= validate_image($thumbnail_path ? $thumbnail_path : "") ?>" alt="Thumbnail Path" class="img-thumbnail bg-gradient-black" id="thumb-path">
        </dd>
        <dt class="text-muted">Tên</dt>
        <dd class='pl-4 fs-4 fw-bold'><?= isset($Ten_thiet_bi) ? $Ten_thiet_bi : '' ?></dd>
        <dt class="text-muted">Mô tả</dt>
        <dd class='pl-4'>
            <p class=""><small><?= isset($description) ? html_entity_decode($description) : '' ?></small></p>
        </dd>
        <dt class="text-muted">Số lượng có sẵn</dt>
        <dd class='pl-4 fs-4 fw-bold'><?= isset($So_luong) ? $So_luong : '' ?></dd>
        <dt class="text-muted">Đã hư</dt>
        <dd class='pl-4 fs-4 fw-bold'><?= isset($Da_hu) ? $Da_hu : '' ?></dd>
        <dt class="text-muted">Trạng thái</dt>
        <dd class='pl-4'>
            <?php
            if(isset($Status)):
                switch($Status){
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
            endif;
            ?>
        </dd>
    </dl>
    <div class="col-12 text-right">
        <button class="btn btn-flat btn-sm btn-dark" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Đóng</button>
    </div>
</div>