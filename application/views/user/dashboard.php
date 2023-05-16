<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fa fa-shopping-cart fa-2x text-white"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Keranjang</h4>
                        </div>
                        <div class="card-body">
                            <?= $keranjang; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-circle fa-2x text-white"></i>
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