<section class="section">
	<div class="section-body">
		<div class="card">
			<div class="card-header">
				<h4>List Barang</h4>
			</div>
			<div class="card-body">
				<div class="row">
					<?php foreach ($barang as $brg) : ?>
						<div class="col-lg-3 col-md-6 col-sm-12 pb-1">
							<div class="card product-item border-0 mb-4">
								<div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
									<img class="img-fluid w-100" src="<?= base_url('uploads/gambar/' . $brg->gambar); ?>" alt="<?= $brg->namaBarang; ?>">
								</div>
								<div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
									<h6 class="text-truncate mb-3"><?= $brg->namaBarang; ?></h6>
									<h6 class="text-truncate mb-3"><?= 'Rp. ' . number_format($brg->harga, 0, ',', '.'); ?></h6>
									<span class="text-truncate mb-3"><?= 'Stok : ' . $brg->stok; ?></span>
								</div>

								<div class="card-body border-left border-right p-0 pt-4 pb-3">
									<P class="mb-3"><?= $brg->deskripsi; ?></P>
								</div>
								<div class="card-footer d-flex justify-content-center border">
									<form action="<?= base_url('user/listbarang/addToCart'); ?>" method="POST">
										<input type="hidden" name="idBarang" value="<?= $brg->id; ?>">
										<button type="submit" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Tambah ke Keranjang</button>
									</form>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="row">
					<div class="col-12 pb-1 d-flex justify-content-between">
						<div class="text-primary my-auto">
							<?= 'Total product : ' . $total_rows; ?>
						</div>
						<nav aria-label="Page navigation">
							<?= $paging; ?>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>