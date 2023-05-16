<section class="section">
	<div class="section-body">
		<div class="card">
			<div class="card-header">
				<h4>Keranjang</h4>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-lg-8">
						<div class="table-responsive">
							<table class="table table-bordered table-hover" id="table-1">
								<thead>
									<tr>
										<th class="text-center">#</th>
										<th>Kode Barang</th>
										<th>Nama Barang</th>
										<th>Barang</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i = 1;
									foreach ($keranjang as $data) : ?>
										<tr>
											<td><?= $i++; ?></td>
											<td><?= $data->kodeBarang; ?></td>
											<td><?= $data->namaBarang; ?></td>
											<td>
												<img src="<?= base_url('uploads/gambar/' . $data->gambar); ?>" width="100" class="img-fluid img-thumbnail" alt="<?= $data->kodeBarang; ?>">
											</td>
											<td>
												<div class="dropdown">
													<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														Action
													</button>
													<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
														<a href="<?= base_url('user/keranjang/delete/' . $data->id); ?>" class="dropdown-item"><i class="fas fa-trash"></i> Delete</a>
													</div>
												</div>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="card">
							<div class="card-header bg-secondary border-0">
								<h4 class="font-weight-semi-bold m-0">Keranjang</h4>
							</div>
							<div class="card-body">
								<div class="d-flex justify-content-between mt-2">
									<h5 class="font-weight-bold">Total Barang</h5>
									<h5 class="font-weight-bold" id="total"><?= ($keranjang) ? count($keranjang) : '0'; ?></h5>
								</div>
							</div>
							<div class="card-footer border-secondary bg-transparent">
								<button class="btn btn-block btn-primary my-3 py-3" <?= ($keranjang) ? '' : 'disabled'; ?> data-toggle="modal" data-target="#checkout" id="to-checkout">Proceed To Checkout</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- modal checkout -->
<div class="modal fade" tabindex="-1" role="dialog" id="checkout">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Checkout</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url('user/keranjang/checkout') ?>" method="post">
					<div class="form-group">
						<label>Nama Perusahaan</label>
						<input type="text" class="form-control" name="namaPT" required>
					</div>
					<div class="form-group">
						<label>No. HP</label>
						<input type="number" class="form-control" name="nohp" required>
					</div>
					<div class="form-group">
						<label>Alamat</label>
						<textarea name="alamat" class="form-control" cols="30" rows="10" required></textarea>
					</div>
					<div class="modal-footer bg-whitesmoke br">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Checkout</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>