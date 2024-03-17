<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <div class="col-8">
            <h1 class="my-3">Tabel Data Admin</h1>
            <a class="btn btn-primary align-right" href="<?=base_url('home/admin')?>">Tambah</a>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Password</th>
                        <th>Tipe</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Password</th>
                        <th>Tipe</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach ($staffs as $key => $value) { ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= $value->name ?></td>
                            <td><?= $value->nip ?></td>
                            <td><?= $value->password ?></td>
                            <td><?= $value->role ?></td>
                            <td>
                                <a class="btn btn-warning" href="<?= base_url('home/admin?id=' . $value->id) ?>">Edit</a>
                                <a class="btn btn-danger" href="<?= base_url('home/admin/delete/' . $value->id) ?>">Hapus</a>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                    </tr>
                </tbody>
            </table>

        </div>
        <div class="col-4">
            <form class="form" method="POST" action="
            <?php if(empty($is_edit)) {
                        echo base_url('home/admin/save');
                    } else {
                        echo base_url('home/admin/save?id='.$data->id);
                    } ?>">
                        
                <h3><?php 
                if(empty($is_edit)) {
                    echo"Tambah Data Admin";
                } else {
                    echo "Edit Data Admin";
                } ?></h3>
                <input type="hidden" name="id" value="<?=$data->id?>"/>
                <div class="form-outline mt-4">
                    <label class="form-label" for="nip" name="nip">Nomor Pegawai</label>
                    <input type="text" id="nip" class="form-control" name="nip" value="<?=$data->nip?>"/>
                </div>

                <div class="form-outline mt-2">
                    <label class="form-label" for="nama" name="nama">Nama Lengkap</label>
                    <input type="text" id="nama" class="form-control" name="nama" value="<?=$data->name?>"/>
                </div>

                <div class="form-outline mt-2">
                    <label class="form-label" for="password">Password</label>
                    <input type="text" id="password" class="form-control" name="password" value="<?=$data->password?>"/>
                </div>
                
                <label class="form-label mt-2" for="tipe">Tipe</label>
                <select class="browser-default custom-select" id="tipe" name="tipe">
                    <option value="staff" <?=($data->role == 'staff'?'selected="selected"':'')?>>Staff</option>
                    <option value="admin" <?=($data->role == 'admin'?'selected="selected"':'')?>>Admin</option>
                </select>

                <button type="submit" class="btn btn-primary btn-block mt-4">Simpan</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>