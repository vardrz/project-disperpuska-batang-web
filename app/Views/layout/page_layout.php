<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Arsip Disperpuska</title>

	<?= $this->include('layout/css_session') ?>
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
						<a class="nav-link" href="<?= base_url('home/surat') ?>">Surat</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?= base_url('home/public') ?>">Anggota</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?= base_url('home/admin') ?>">Admin</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?= base_url('home/logout') ?>">Logout</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<?php if (!empty(session()->getFlashdata('message'))) : ?>

		<div class="alert alert-danger">
			<?php echo session()->getFlashdata('message'); ?>
		</div>

	<?php endif ?>
	<?= $this->renderSection('content') ?>

	<footer class="bg-secondary text-center text-lg-start fixed-bottom">
		<div class="container text-center p-3">Copyright &copy <?= Date('Y') ?> Kearsipan</div>
	</footer>

	<?= $this->include('layout/js_session') ?>
</body>

</html>