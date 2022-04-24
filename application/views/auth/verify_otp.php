<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Qube Health</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="<?= base_url() ?>assets/css/login.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.css" integrity="sha512-oe8OpYjBaDWPt2VmSFR+qYOdnTjeV9QPLJUeqZyprDEQvQLJ9C5PCFclxwNuvb/GQgQngdCXzKSFltuHD3eCxA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="page-content">
    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-md-center h-100">
                <div class="card-wrapper">
                    <div class="brand">
                        <img src="<?php echo base_url(); ?>assets/images/logo/qube-health.png" alt="logo">
                    </div>
                    <div class="card fat">
                        <div class="card-body">
                            <div class="col-sm-12 mt-5 bgWhite">
                                <div class="title">
                                    Verify OTP
                                </div>

                                <form method="POST" action="<?php echo base_url('auth/verify'); ?>" class="mt-5">
                                    <div class="verify-otp">
                                        <input class="otp" type="text" oninput='digitValidate(this)' onkeyup='tabChange(1)' maxlength=1 name="otp[]">
                                        <input class="otp" type="text" oninput='digitValidate(this)' onkeyup='tabChange(2)' maxlength=1 name="otp[]">
                                        <input class="otp" type="text" oninput='digitValidate(this)' onkeyup='tabChange(3)' maxlength=1 name="otp[]">
                                        <input class="otp" type="text" oninput='digitValidate(this)' onkeyup='tabChange(4)' maxlength=1 name="otp[]">
                                    </div>
                                    <input type="hidden" name="phone" value="<?php echo $phone; ?>">
                                    <hr class="mt-4">
                                    <button type="submit" class='btn btn-primary btn-block mt-4 mb-4 customBtn'>Verify</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="footer">
                        Copyright &copy; 2022 &mdash; Qube Health
                    </div>
                </div>
            </div>
        </div>

    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous"></script>
    <script src="<?php echo base_url(); ?>assets/js/login.js"></script>
    <!-- SHOW TOASTR NOTIFIVATION -->
    <?php if ($this->session->flashdata('flash_message') != "") : ?>

        <script type="text/javascript">
            toastr.success('<?php echo $this->session->flashdata("flash_message"); ?>');
        </script>

    <?php endif; ?>

    <?php if ($this->session->flashdata('error_message') != "") : ?>

        <script type="text/javascript">
            toastr.error('<?php echo $this->session->flashdata("error_message"); ?>');
        </script>

    <?php endif; ?>

    <?php if ($this->session->flashdata('info_message') != "") : ?>

        <script type="text/javascript">
            toastr.info('<?php echo $this->session->flashdata("info_message"); ?>');
        </script>

    <?php endif; ?>

</body>

</html>

</body>

</html>