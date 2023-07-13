<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1><?= $title; ?></h1>
		</div>

		<div class="section-body">

			<!-- main -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<button class="btn btn-primary" data-toggle="modal" data-target="#modalAdd"><i class="fas fa-plus"></i></button>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-striped" id="table-1">
									<thead>
										<tr>
											<th class="text-center">#</th>
											<th>Nama Bank</th>
											<th>No. Rekening</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php $i = 1;
										foreach ($rekening as $data) : ?>
											<tr>
												<td><?= $i++; ?></td>
												<td><?= $data->namaBank; ?></td>
												<td><?= $data->noRek; ?></td>
												<td>
													<div class="dropdown">
														<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Action
														</button>
														<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
															<a href="<?= base_url('admin/rekening/delete/' . $data->id); ?>" class="dropdown-item"><i class="fas fa-trash"></i> Delete</a>
															<a href="javascript:void(0)" class="dropdown-item edit_btn" data-toggle="modal" data-target="#modalEdit" data-id="<?= $data->id; ?>" data-namabank="<?= $data->namaBank; ?>" data-norek="<?= $data->noRek; ?>"><i class="fas fa-arrow-left"></i> Edit</a>
														</div>
													</div>
												</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- end main -->
		</div>
	</section>
</div>

<!-- modal add -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalAdd">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Rekening</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="<?= base_url('admin/rekening/add'); ?>" method="post">
					<div class="form-group">
						<label>Nama Bank</label>
						<input type="text" class="form-control" name="namaBank" required>
					</div>
					<div class="form-group">
						<label>No. Rekening</label>
						<input type="text" class="form-control" name="noRek" required>
					</div>
					<div class="modal-footer bg-whitesmoke br">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- modal edit -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalEdit">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Rekening</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="<?= base_url('admin/rekening/edit'); ?>" method="post">
					<input type="hidden" name="id" id="id">
					<div class="form-group">
						<label>Nama Bank</label>
						<input type="text" class="form-control" name="namaBank" required id="namabank">
					</div>
					<div class="form-group">
						<label>No. Rekening</label>
						<input type="text" class="form-control" name="noRek" required id="norek">
					</div>
					<div class="modal-footer bg-whitesmoke br">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	let edit_btn = $('.edit_btn');

	$(edit_btn).each(function(i) {
		$(edit_btn[i]).click(function() {
			let id = $(this).data('id');
			let namabank = $(this).data('namabank');
			let norek = $(this).data('norek');

			$('#id').val(id);
			$('#namabank').val(namabank);
			$('#norek').val(norek);
		});
	});
</script>