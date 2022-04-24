<?php
$user_data = $this->user_model->get_user_data_by_id($this->session->userdata('user_id'));
?>
<div class="col-md-3">
    <div class="profile-sidebar">
        <div class="profile-userpic">
            <img src="<?php if ($user_data['profile_image'] == '') {
                            echo base_url() . 'assets/images/profile/default.png';
                        } else {
                            echo base_url() . 'assets/images/profile/' . $user_data['profile_image'];
                        } ?>" class="img-responsive"
                alt="<?php echo $user_data['first_name'] . ' ' . $user_data['last_name']; ?>">
        </div>
        <div class="profile-usertitle">
            <div class="profile-usertitle-name">
                <?php
                if ($user_data['first_name'] == '' && $user_data['last_name'] == '') {
                    echo 'System User';
                } else {
                    echo $user_data['first_name'] . ' ' . $user_data['last_name'];
                }
                ?>
            </div>
            <div class="profile-usertitle-job">
                <?php if ($user_data['role_id'] == 1) {
                    echo 'Admin';
                } else {
                    echo 'User';
                } ?>
            </div>
        </div>
        <div class="profile-usermenu">
            <ul class="nav">
                <li>
                    <a href="<?php echo base_url('user') ?>" <?php if ($page_name == 'profile') {
                                                                    echo 'class="active"';
                                                                } ?>>
                        <i class="glyphicon glyphicon-home"></i>
                        Update profile </a>
                </li>
                <?php if ($this->session->userdata('user_login') && $this->session->userdata('role_id') == 1) { ?>
                <li><a href="<?php echo base_url('admin') ?>" <?php if ($page_name == 'list_users') {
                                                                        echo 'class="active"';
                                                                    } ?>>

                        <i class="glyphicon glyphicon-user"></i>
                        User List </a>
                </li>
                <li>
                    <a href="<?php echo base_url('admin/add_user') ?>" <?php if ($page_name == 'add_user') {
                                                                                echo 'class="active"';
                                                                            } ?>>
                        <i class="glyphicon glyphicon-ok"></i>
                        Add User </a>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>