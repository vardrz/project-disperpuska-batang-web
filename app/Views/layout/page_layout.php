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
			<a class="navbar-brand" href="<?= base_url() ?>">Home</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" href="<?= base_url('home/surat') ?>">Arsip</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?= base_url('home/public') ?>">Anggota</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?= base_url('home/admin') ?>">Admin</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?= base_url('home/pengembalian') ?>">Pengembalian</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?= base_url('home/laporan') ?>">Laporan</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?= base_url('logout') ?>">Logout</a>
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
			document.querySelector('a[href="<?= base_url('logout') ?>"]').addEventListener('click', function(e) {
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
	</script>
</body>

</html>