<div class="col-md-9">
    <div class="profile-content">
        <div class="p-3 py-5">
            <form method="POST" action="<?php echo base_url('admin/add_user'); ?>" enctype="multipart/form-data">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Add User</h4>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6"><label class="labels">First Name</label><input type="text"
                            class="form-control" placeholder="First Name" name="first_name" value=""></div>
                    <div class="col-md-6"><label class="labels">Last Name</label><input type="text" class="form-control"
                            value="" placeholder="Last Name" name="last_name">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12"><label class="labels">Phone Number</label><input type="text"
                            class="form-control" value="" name="phone" placeholder="10 Digit phone number" require>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="form-group">
                        <label>Profile Image</label>
                        <div class="controls">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;"
                                    data-trigger="fileinput">

                                    <img src="<?php echo base_url() . 'assets/images/profile/default.png'; ?>"
                                        alt="No Image">

                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail"
                                    style="max-width: 200px; max-height: 150px"></div>
                                <div>
                                    <span class="btn btn-white btn-file">
                                        <span class="fileinput-new">Select image</span>
                                        <span class="fileinput-exists">Change</span>
                                        <input type="file" name="image" accept="image/*">
                                    </span>
                                    <a href="#" class="btn btn-orange fileinput-exists"
                                        data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="submit">Save
                        Profile</button></div>
            </form>
        </div>
    </div>
</div>