<style>
    .storage-image-field{
        width:calc(100%);
        height:25vh;
    }
    .storage-image{
        transition:transform .2s ease-in;
        width:calc(100%);
        height:calc(100%);
        object-fit:cover;
        object-position:center center;
    }
    .storage-item{
        transition:transform .2s ease-in;
    }
    .storage-item:hover{
        transform:scale(1.029)
    }
    .storage-item:hover .storage-image{
        transform:scale(1.2)
    }
</style>
<div class="content py-3">
    <div class="container-fluid">
        <h3 class="text-center"><b>Danh sách thiết bị</b></h3>
        <hr class="bg-navy">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="input-group mb-2">
                    <input type="search" id="search" class="form-control form-control-border" placeholder="Tìm kiếm thiết bị tại đây...">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-sm border-0 border-bottom btn-default">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-cols-sm-1 row-cols-md-2 row-cols-xl-4 justify-content-center gx-3 gy-3">
            <?php 
            $storages = $conn->query("SELECT * FROM thiet_bi_uit order by `Ten_thiet_bi` asc");
            while($row = $storages->fetch_assoc()):
            ?>
                <a class="col storage-item text-decoration-none text-dark" href="javascript:void(0)" data-id="<?= $row['ID'] ?>">
                    <div class="card rounded-0 shadow">
                        <div class="text-center overflow-hidden storage-image-field">
                            <img class="img-top bg-gradient-dark border-info storage-image" src="<?php echo validate_image($row['thumbnail_path']) ?>" alt="Hình ảnh thiết bị">
                        </div>
                        <div class="card-body rounded-0">
                            <h4 class="text-center"><b><?= ($row['Ten_thiet_bi']) ?></b></h4>
                        </div>
                    </div>
                </a>
            <?php endwhile; ?>
            <?php if($storages->num_rows < 1): ?>
                <center><span class="text-muted">Chưa có thiết bị được liệt kê.</span></center>
            <?php endif; ?>
                <div id="no_result" style="display:none"><center><span class="text-muted">Không có kết quả.</span></center></div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#search').on("input",function(e){
            var _search = $(this).val().toLowerCase()
            $('.storage-item').each(function(){
                var _txt = $(this).text().toLowerCase()
                if(_txt.includes(_search) === true){
                    $(this).toggle(true)
                }else{
                    $(this).toggle(false)
                }
                if($('.storage-item:visible').length <= 0){
                    $("#no_result").show('slow')
                }else{
                    $("#no_result").hide()
                }
            })
        })
        $('.storage-item').click(function(){
            uni_modal("Thông tin thiết bị","view_storage.php?id="+$(this).attr('data-id'),'mid-large')
        })
    })
</script>