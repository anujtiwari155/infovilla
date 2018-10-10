<div class="main main-raised">
    <div class="profile-content" style="padding:3%">
        <div class="container">
            <div class="row">
                <div class="profile">
                    <h3>Content</h3>
                </div>
                <form action="<?php echo $action; ?>" method='post'  enctype="multipart/form-data">
                    <div class="col-md-12">
                        <?php $this->load->view('backend/includes/error_message'); ?> 
                    </div>
                    <div class="col-md-9">
                            <div class="form-group">
                                <label>New</label>
                                <input type="text" name="new" class="form-control" value="<?php if(set_value('new'))  echo set_value('new'); elseif(isset ($data->new)) echo $data->new;?>">
                            </div>
                    </div>
                   

                     <div class="form-group col-md-3">
                        <label>New Image</label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <span class="btn btn-default btn-file">
                                    Browse… <input type="file" name="new_img" class="form-control">
                                </span>
                            </span>
                            <img src="<?php echo base_url().'/assets/img/adevetiesment/'.$data->new_img ?>" class="thumb" width="50" height="50"/>
                        </div>
                    </div>
                   
                    <div class="col-md-9">
                        <div class="form-group">
                            <label>Upcomming</label>
                            <input type="text" name="upcomming" class="form-control" value="<?php if(set_value('upcomming'))  echo set_value('upcomming'); elseif(isset ($data->upcomming)) echo $data->upcomming;?>">
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <label>Upcomming Image</label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <span class="btn btn-default btn-file">

                                    Browse… <input type="file" name="upcomming_img" class="form-control">
                                    
                                </span>
                            </span>
                            <img src="<?php echo base_url().'assets/img/adevetiesment/'. $data->upcomming_img ?>" class="thumb" width="50" height="50"/>
                        </div>
                    </div>
                    
                    <div class="col-md-9">
                        <div class="form-group">
                            <label>Most Wanted</label>
                            <input type="text" name="most" class="form-control" value="<?php if(set_value('most'))  echo set_value('most'); elseif(isset ($data->most)) echo $data->most;?>">
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Most Wanted Image</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file">
                                        Browse… <input type="file" name="most_img" class="form-control" >
                                        
                                    </span>
                                </span>
                                <img src="<?php echo base_url().'assets/img/adevetiesment/'. $data->most_img ?>" class="thumb" width="50" height="50"/>
                            </div> 
                             
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

