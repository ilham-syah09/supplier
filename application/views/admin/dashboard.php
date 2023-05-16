<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title; ?></h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fa fa-users fa-2x text-white"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Customer</h4>
                            </div>
                            <div class="card-body">
                                <?= $user; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-info">
                            <i class="fa fa-circle fa-2x text-white"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Barang</h4>
                            </div>
                            <div class="card-body">
                                <?= $barang; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fa fa-first-order fa-2x text-white"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Orders</h4>
                            </div>
                            <div class="card-body">
                                <?= $orders; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>