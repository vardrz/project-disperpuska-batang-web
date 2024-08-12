<?php

use App\Models\BorrowModel;

$borrowModel  = new BorrowModel();
$peminjaman = $borrowModel->relasi();

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Arsip Disperpuska</title>

	<?= $this->include('layout/css_session') ?>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

</head>

<body>

	<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
		<div class="container">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item <?= (uri_string() == 'home') ? 'active' : '' ?>">
						<a class="nav-link" href="<?= base_url('home') ?>">Home</a>
					</li>
					<li class="nav-item <?= (uri_string() == 'home/surat') ? 'active' : '' ?>">
						<a class="nav-link" href="<?= base_url('home/surat') ?>">Arsip</a>
					</li>
					<li class="nav-item <?= (uri_string() == 'home/public') ? 'active' : '' ?>">
						<a class="nav-link" href="<?= base_url('home/public') ?>">Anggota</a>
					</li>
					<li class="nav-item <?= (uri_string() == 'home/admin') ? 'active' : '' ?>">
						<a class="nav-link" href="<?= base_url('home/admin') ?>">Admin</a>
					</li>
					<li class="nav-item <?= (uri_string() == 'home/pengembalian') ? 'active' : '' ?>">
						<a class="nav-link" href="<?= base_url('home/pengembalian') ?>">Pengembalian</a>
					</li>
					<li class="nav-item <?= (uri_string() == 'home/laporan') ? 'active' : '' ?>">
						<a class="nav-link" href="<?= base_url('home/laporan') ?>">Laporan</a>
					</li>
				</ul>
				<ul class="navbar-nav ml-auto">
					<li class="nav-item dropdown position-relative">
						<a class="nav-link position-relative" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fas fa-envelope"></i>
							<sup class="badge badge-light badge-counter"><?= count($peminjaman); ?></sup>
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
							<span class="dropdown-header bg-primary text-center text-white">Notifikasi</span>
							<?php if (empty($peminjaman)) : ?>
								<div class="dropdown-item d-flex align-items-center">
									<span class="text-secondary text-center">Tidak Ada Pesan</span>
									<hr>
								</div>
							<?php else : ?>
								<?php foreach ($peminjaman as $item) : ?>
									<a href="<?= base_url('home/surat/detail?id=' . $item->archives_id); ?>">
										<div class="dropdown-item d-flex align-items-center">
											<div>
												<strong><?= $item->archives_number; ?></strong>
												<div class="d-flex justify-content-between small text-muted">
													<span><?= $item->public_name; ?></span>
													<span class="badge badge-warning badge-pill text-white"><?= $item->keterangan; ?></span>
												</div>
											</div>
										</div>
									</a>
								<?php endforeach; ?>
							<?php endif; ?>
							<a class="dropdown-item border-top text-center small" href="<?= base_url('home/surat'); ?>">
								Show Arsip
							</a>
						</div>
					</li>
					<li class="nav-item">
						<a class="nav-link btn-logout" href="<?= base_url('logout') ?>">Logout</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<?php if (!empty(session()->getFlashdata('message'))) : ?>

		<div class="alert alert-danger">
			<?php echo session()->getFlashdata('message'); ?>
		</div>
	<?php elseif (!empty(session()->getFlashdata('pesan'))) : ?>
		<div class="alert alert-success">
			<?php echo session()->getFlashdata('pesan'); ?>
		</div>
	<?php endif ?>
	<?= $this->renderSection('content') ?>

	<footer class="bg-secondary text-center text-lg-start fixed-bottom">
		<div class="container text-center p-3">Copyright &copy <?= Date('Y') ?> Kearsipan</div>
	</footer>

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
	<?= $this->include('layout/js_session') ?>
	<?= $this->renderSection('script') ?>
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const btnLogout = document.querySelectorAll('.btn-logout');
			btnLogout.forEach(button => {
				button.addEventListener('click', function(e) {
					e.preventDefault();
					Swal.fire({
						title: 'KELUAR?',
						text: "Apakah Anda Ingin Keluar!",
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Ya, keluar!',
						cancelButtonText: 'Tidak'
					}).then((result) => {
						if (result.isConfirmed) {
							window.location.href = '<?= base_url('logout') ?>';
						}
					});
				});
			});
		});
	</script>
</body>

</html>