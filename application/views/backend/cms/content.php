<div class="main main-raised">
    <div class="profile-content" style="padding:3%">
        <div class="container">
            <div class="row">
                <div class="profile">
                    <h3>Content</h3>
                </div>
                <div class="col-md-12">
                    <div class="col-md-12">
                        <?php $this->load->view('backend/includes/error_message'); ?> 
                    </div>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                
                                <th>New </th>
                                <th>New Image</th>
                                <th>Upcomming</th>
                                <th>Upcomming Image</th>
                                <th>Most Wanted</th>
                                <th>Most Wanted Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <tr>
                            <td><?php if ($this->data['current_page']) { ?>   
                              <?php echo $this->data['current_page']->new; ?>    
                              <?php } ?></td>
                            <td>
                            <img src="<?php echo base_url().'assets/img/adevetiesment/'.$this->data['current_page']->new_img ?>" class="thumb" width="100" height="100"/>

                            <!-- <?php if ($this->data['current_page']) { ?>   
                              <?php echo $this->data['current_page']->new_img; ?>    
                              <?php } ?> --></td>
                            <td><?php if ($this->data['current_page']) { ?>   
                              <?php echo $this->data['current_page']->upcomming; ?>    
                              <?php } ?></td>
                            <td><img src="<?php echo base_url().'assets/img/adevetiesment/'.$this->data['current_page']->upcomming_img ?>" class="thumb" width="100" height="100"/>   
                              </td>
                            <td><?php if ($this->data['current_page']) { ?>   
                              <?php echo $this->data['current_page']->most; ?>    
                              <?php } ?></td>
                            <td><img src="<?php echo base_url().'assets/img/adevetiesment/'.$this->data['current_page']->most_img ?>" class="thumb" width="100" height="100"/>    
                              </td>  
                            <td>
                                <a href="<?php echo base_url() . 'backend/admin/update_content/' . $this->data['current_page']->id; ?>" title="Edit">
                                    <span class="label label-info">
                                        <i class="fa fa-pencil"></i> 
                                    </span>
                                </a>&nbsp;
                            </td>
                        </tr>
                    </tbody>
                    </table>
                </div>
            </div>
           <!--  <div class="row text-center">
                <a href="<?= base_url('backend/admin/add_content') ?>" class="btn btn-link"> Add More </a>
            </div> -->
        </div>

    </div>
