<!DOCTYPE html>
<html lang="en">
<?php
include 'comman_files/head.php';
?>
</head>

<body class="my-login-page">
    <div class="fluid-container">
        <?php
        if ($this->session->userdata('user_login')) {
            include 'comman_files/header.php';
        } ?>
        <div class="row">
            <?php
            if ($this->session->userdata('user_login')) {
                include 'comman_files/sidebar.php';
            } ?>

            <?php if ($page_name === null) {
                include $path;
            } else {
                include $page_name . '.php';
            } ?>
        </div>
    </div>
    <?php include 'comman_files/footer.php';
    ?>
</body>

</html>