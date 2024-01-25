<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN ADMINISTRATOR</title>

    <?= $this->include('layout/css_session') ?>
</head>

<body>
    <section class="vh-100" style="background-color: #508bfc;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <form action="<?= base_url('login') ?>" method="POST">
                            <div class="card-body p-5">

                                <h3 class="mb-5 text-center">Sign in As Staff</h3>

                                <div class="form-group form-outline mb-4">
                                    <label class="form-label" for="nip">NIP</label>
                                    <input id="nip" class="form-control form-control-lg" name="nip" />
                                </div>

                                <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>

                                <hr class="my-4">
                            </div>
                        </form>

                        <?php if (!empty(session()->getFlashdata('message'))) : ?>

                            <div class="alert alert-danger">
                                <?php echo session()->getFlashdata('message'); ?>
                            </div>

                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?= $this->include('layout/js_session') ?>
</body>

</html>