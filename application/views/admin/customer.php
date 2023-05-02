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
											<th class="text-center">
												#
											</th>
											<th>Name</th>
											<th>Username</th>
											<th>Image</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php $i = 1;
										foreach ($customer as $data) : ?>
											<tr>
												<td><?= $i++; ?></td>
												<td><?= $data->name; ?></td>
												<td><?= $data->username; ?></td>
												<td>
													<img src="<?= base_url('uploads/profile/' . $data->image); ?>" width="50" class="img-fluid rounded-circle" alt="image">
												</td>
												<td>
													<span class="badge <?= ($data->status == 0) ? 'badge-danger' : 'badge-success'; ?>"><?= ($data->status == 0) ? 'Unverified' : 'Verified'; ?></span>
												</td>
												<td>
													<div class="dropdown">
														<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Action
														</button>
														<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
															<a href="<?= base_url('admin/customer/delete/' . $data->id); ?>" class="dropdown-item"><i class="fas fa-trash"></i> Delete</a>
															<a href="javascript:void(0)" class="dropdown-item edit_btn" data-toggle="modal" data-target="#modalEdit" data-id="<?= $data->id; ?>" data-name="<?= $data->name; ?>" data-username="<?= $data->username; ?>" data-status="<?= $data->status; ?>"><i class="fas fa-arrow-left"></i> Edit</a>
															<a href="<?= base_url('admin/customer/resetPwd/' . $data->id); ?>" class="dropdown-item"><i class="fas fa-arrow-left"></i> Reset Password</a>
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
				<h5 class="modal-title">Add Customer</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="<?= base_url('admin/customer/add'); ?>" method="post">
					<div class="form-group">
						<label>Name</label>
						<input type="text" class="form-control" name="name">
					</div>
					<div class="form-group">
						<label>Username / Email</label>
						<input type="email" class="form-control" name="username">
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
				<h5 class="modal-title">Edit Customer</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="<?= base_url('admin/customer/edit'); ?>" method="post">
					<input type="hidden" name="id" id="idCustomer">
					<div class="form-group">
						<label>Name</label>
						<input type="text" class="form-control" name="name" id="name">
					</div>
					<div class="form-group">
						<label>Username</label>
						<input type="text" class="form-control" name="username" id="username">
					</div>
					<div class="form-group">
						<label>Status</label>
						<select class="form-control" name="status" id="status">
							<option value="">-- Pilih Status --</option>
							<option value="1">Verified</option>
							<option value="0">Unverified</option>
						</select>
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
			let name = $(this).data('name');
			let username = $(this).data('username');
			let status = $(this).data('status');

			$('#idCustomer').val(id);
			$('#name').val(name);
			$('#username').val(username);
			$('#status').val(status);
		});
	});
</script>