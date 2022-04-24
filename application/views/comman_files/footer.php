<!-- Footer -->
<footer class="page-footer font-small blue">

    <!-- Copyright -->
    <div class="footer-copyright text-center py-3">© 2022 Copyright:
        <a href="/"> Qube Health</a>
    </div>
    <!-- Copyright -->

</footer>
<!-- Footer -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
    integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
    crossorigin="anonymous"></script>
<script src="<?php echo base_url(); ?>assets/js/login.js"></script>
<script src="<?php echo base_url(); ?>assets/js/fileinput.js"></script>
<script src="<?php echo base_url(); ?>assets/js/script.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/js/dataTables.responsive.min.js"></script> -->
<script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/daterangepicker.js"></script>
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