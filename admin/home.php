<h1>Welcome to <?php echo $_settings->info('name') ?></h1>
<hr class="border-info">
<div class="row">
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-th-list"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Danh sách thiết bị</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `storage_list` where status = 1")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-gradient-secondary elevation-1"><i class="fas fa-book"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Yêu cầu chưa duyệt</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `booking_list` where `status` = 0")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-gradient-primary elevation-1"><i class="fas fa-book"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Yêu cầu đã duyệt</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `booking_list` where `status` = 1")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-gradient-secondary elevation-1"><i class="fas fa-question-circle"></i></span>
            <div class="info-box-content">
            <span class="info-box-text">Phản hồi chưa đọc</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `message_list` where `status` = 0")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-gradient-primary elevation-1"><i class="fas fa-question-circle"></i></span>
            <div class="info-box-content">
            <span class="info-box-text">Phản hồi đã đọc</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `message_list` where `status` = 1")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
</div>