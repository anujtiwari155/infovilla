<div class="main main-raised">
    <div class="profile-content" style="padding:3%">
        <div class="container">
            <div class="row">
                <div class="profile">
                    <h3>Address</h3>
                </div>
                <form action="<?php echo $action; ?>" method='post'  enctype="multipart/form-data">
                    <div class="col-md-12">
                        <?php $this->load->view('backend/includes/error_message'); ?> 
                    </div>
                    <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" name="phone" class="form-control" value="<?php if(set_value('phone'))  echo set_value('phone'); elseif(isset ($data->phone)) echo $data->phone;?>">
                            </div>
                    </div>
                    
                    <div class="col-md-6">
                            <div class="form-group">
                                <label>E-mail</label>
                                <input type="text" name="email" class="form-control" value="<?php if(set_value('email'))  echo set_value('email'); elseif(isset ($data->email)) echo $data->email;?>" >
                            </div>
                    </div>
                   
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Location</label>
                            <input type="text" name="location" class="form-control" value="<?php if(set_value('location'))  echo set_value('location'); elseif(isset ($data->location)) echo $data->location;?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Web</label>
                            <input type="text" name="web" class="form-control" value="<?php if(set_value('web'))  echo set_value('web'); elseif(isset ($data->web)) echo $data->web;?>">
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="col-md-12">
                            <div class="form-group">                                                                
                                <button class="btn btn-link" type="submit">Save</button>
                                <a href="<?php echo base_url() . 'backend/admin/cms' ?>" class="btn btn-danger" >Cancel</a>
                            </div>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>

</div>

