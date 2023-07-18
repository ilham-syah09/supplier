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
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th class="text-center">#</th>
										<th>Kode Barang</th>
										<th>Nama Barang</th>
										<th>Gambar</th>
										<th>Harga</th>
										<th>Jumlah</th>
										<th>Subtotal</th>
										<!-- <th>Action</th> -->
									</tr>
								</thead>
								<tbody>
									<?php $i = 1;
									$total = 0;
									foreach ($keranjang as $data) : ?>
										<?php $total += ($data->harga * $data->jumlah); ?>
										<tr>
											<td><?= $i++; ?></td>
											<td><?= $data->kodeBarang; ?></td>
											<td><?= $data->namaBarang; ?></td>
											<td>
												<a href="" target="_blank">
													<img src="<?= base_url('uploads/gambar/' . $data->gambar); ?>" width="100" class="img-fluid img-thumbnail" alt="<?= $data->kodeBarang; ?>">
												</a>
											</td>
											<td><?= 'Rp. ' . number_format($data->harga, 0, ',', '.'); ?></td>
											<td>
												<div class="input-group mx-auto" style="width: 100px;">
													<div class="input-group-btn">
														<button class="btn btn-sm btn-primary btn_minus" data-id="<?= $data->id; ?>">
															<i class="fa fa-minus"></i>
														</button>
													</div>
													<input type="text" class="form-control form-control-sm bg-secondary text-center input_jumlah" value="<?= $data->jumlah; ?>" data-stok="<?= $data->stok; ?>" data-id="<?= $data->id; ?>" data-harga="<?= $data->harga; ?>">
													<div class="input-group-btn">
														<button type="submit" class="btn btn-sm btn-primary btn_plus" data-id="<?= $data->id; ?>">
															<i class="fa fa-plus"></i>
														</button>
													</div>
												</div>
											</td>
											<td class="subTotal">
												<span class="harga"><?= 'Rp. ' . number_format(($data->harga * $data->jumlah), 0, ',', '.'); ?></span>
											</td>
											<!-- <td>
												<div class="dropdown">
													<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														Action
													</button>
													<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
														<a href="<?= base_url('user/keranjang/delete/' . $data->id); ?>" class="dropdown-item"><i class="fas fa-trash"></i> Delete</a>
													</div>
												</div>
											</td> -->
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
								<div class="d-flex justify-content-between mb-3 pt-1">
									<h6 class="font-weight-medium">Subtotal</h6>
									<h6 class="font-weight-medium" id="subTotal"><?= 'Rp. ' . number_format($total, 0, ',', '.'); ?></h6>
								</div>
							</div>
							<div class="card-footer border-secondary bg-transparent">
								<div class="d-flex justify-content-between mt-2">
									<h5 class="font-weight-bold">Total</h5>
									<h5 class="font-weight-bold" id="total"><?= 'Rp. ' . number_format($total, 0, ',', '.'); ?></h5>
								</div>
								<button class="btn btn-block btn-primary my-3 py-3" data-toggle="modal" data-target="#checkout" id="to-checkout">Proceed To Checkout</button>
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
						<label>Bank Transfer</label>
						<select class="form-control" name="idRekening" required>
							<option value="">-- Pilih Bank Transfer --</option>
							<?php foreach ($rekening as $rek) : ?>
								<option value="<?= $rek->id; ?>"><?= $rek->namaBank . ' - ' . $rek->noRek; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group">
						<label>Pengiriman</label>
						<select class="form-control" name="idOngkir" required id="idOngkir">
							<option value="">-- Pilih Ongkir --</option>
							<?php foreach ($ongkir as $ong) : ?>
								<option value="<?= $ong->id; ?>" data-harga="<?= $ong->harga; ?>"><?= $ong->kota . ' - ' . 'Rp. ' . number_format($ong->harga, 0, ',', '.'); ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group">
						<label>Total Biaya</label>
						<input type="hidden" name="totalBiaya" value="<?= $total; ?>" id="totalBiayaHide">
						<input type="text" class="form-control" name="totbiaya" data-total="<?= $total; ?>" required readonly id="totalBiaya" value="<?= 'Rp. ' . number_format($total, 0, ',', '.'); ?>">
					</div>
					<div class="form-group">
						<label>Nama Perusahaan</label>
						<input type="text" class="form-control" name="namaPT" required>
					</div>
					<div class="form-group">
						<label>No. HP</label>
						<input type="number" class="form-control" name="nohp" required value="<?= $this->dt_user->noHp; ?>">
					</div>
					<div class="form-group">
						<label>Alamat</label>
						<textarea name="alamat" class="form-control" cols="30" rows="10" required><?= $this->dt_user->alamat; ?></textarea>
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

<script>
	let input_jumlah = $('.input_jumlah');
	let btn_plus = $('.btn_plus');
	let subTotal = $('.subTotal');

	let totalSebelumnya = 1;

	$(btn_plus).each(function(i) {
		$(btn_plus[i]).click(function() {
			let id = $(this).data('id');

			let harga = $(input_jumlah[i]).data('harga');
			let stok = $(input_jumlah[i]).data('stok');
			let tot = $(input_jumlah[i]).val();

			let total = parseInt(tot) + 1;

			if (total > stok) {
				total = stok;

				iziToast.warning({
					title: 'Warning',
					message: 'Pesanan tidak dapat melebihi stok',
					position: 'topRight'
				});

				$(input_jumlah[i]).val(total);

				$('#to-checkout').prop('disabled', false);
				return 0;
			}

			$(input_jumlah[i]).val(total);

			updateQty(id, total, harga, i);
			$('#to-checkout').prop('disabled', false);
		});
	});

	let btn_minus = $('.btn_minus');

	$(btn_minus).each(function(i) {
		$(btn_minus[i]).click(function() {
			let id = $(this).data('id');

			let harga = $(input_jumlah[i]).data('harga');
			let tot = $(input_jumlah[i]).val();
			let jumlah = parseInt(tot) - 1;

			if (jumlah < 1) {
				jumlah = 1;

				iziToast.warning({
					title: 'Warning',
					message: 'Minimum order tidak boleh kurang dari satu',
					position: 'topRight'
				});

				$(input_jumlah[i]).val(jumlah);
				$('#to-checkout').prop('disabled', false);

				return 0;
			}

			$(input_jumlah[i]).val(jumlah);
			$('#to-checkout').prop('disabled', false);

			updateQty(id, jumlah, harga, i);
		});
	});

	$(input_jumlah).each(function(i) {
		$(input_jumlah[i]).change(function() {
			let jumlah = $(this).val();

			let id = $(this).data('id');
			let harga = $(this).data('harga');
			let stok = $(this).data('stok');

			if (jumlah > stok) {
				jumlah = stok;

				iziToast.warning({
					title: 'Warning',
					message: 'Pesanan tidak dapat melebihi stok',
					position: 'topRight'
				});

				$(this).val(jumlah);
				$('#to-checkout').prop('disabled', true);
			}

			if (jumlah == 0) {
				jumlah = 1;

				iziToast.warning({
					title: 'Warning',
					message: 'Minimum order tidak boleh kurang dari satu',
					position: 'topRight'
				});

				$(input_jumlah[i]).val(jumlah);
				$('#to-checkout').prop('disabled', false);
			}

			$('#to-checkout').prop('disabled', false);

			if (jumlah == '') {
				$(this).val(jumlahSebelumnya);

				return 0;
			}

			updateQty(id, jumlah, harga, i);
		});
	});

	$(input_jumlah).each(function(i) {
		$(input_jumlah).click(function() {
			jumlahSebelumnya = $(this).val();
			$('#to-checkout').prop('disabled', true);
		});
	})

	const updateQty = (id, jumlah, harga, i) => {
		$.ajax({
			url: `<?= base_url('user/keranjang/updateJumlah'); ?>`,
			type: 'post',
			dataType: 'json',
			data: {
				id,
				jumlah,
				harga
			},
			success: function(res) {
				$('#subTotal').text(res.total);
				$('#total').text(res.total);
				$(subTotal[i]).text(res.subTotal);

				$('#totalBiaya').val(res.total);
				$('#totalBiayaHide').val(res.total);

				iziToast.success({
					title: 'Sukses',
					message: 'Berhasil memperbarui jumlah produk',
					position: 'topRight'
				});
			}
		});
	}

	$('#idOngkir').change(function() {
		let harga = $(this).find(':selected').data('harga');

		if (harga === undefined) {
			return 0;
		}

		let rupiah = new Intl.NumberFormat('id-ID', {
			style: 'currency',
			currency: 'IDR'
		});

		let total = parseInt($('#totalBiaya').data('total'));
		harga = parseInt(harga);

		let totalBiaya = total + harga;

		$('#totalBiaya').val(rupiah.format(totalBiaya));
		$('#totalBiayaHide').val(totalBiaya);
	});
</script>