<div class="main main-raised">
    <div class="profile-content" style="padding:3%">
        <div class="container">
            <div class="row">
                <div class="profile">
                    <h3>Contact</h3>
                </div>
                <div class="col-md-12">
                    <div class="col-md-12">
                        <?php $this->load->view('backend/includes/error_message'); ?> 
                    </div>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>phone</th>
                                <th>locations</th>
                                <th>web</th>
                                <th>email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                                    <tr>
                                        <td><?php if ($this->data['current_page']) { ?>   
                  <?php echo $this->data['current_page']->id; ?>    
                  <?php } ?></td>
                                        <td><?php if ($this->data['current_page']) { ?>   
                  <?php echo $this->data['current_page']->phone; ?>    
                  <?php } ?></td>
                                        <td><?php if ($this->data['current_page']) { ?>   
                  <?php echo $this->data['current_page']->location; ?>    
                  <?php } ?></td>
                                        <td><?php if ($this->data['current_page']) { ?>   
                  <?php echo $this->data['current_page']->web; ?>    
                  <?php } ?></td>
                                         <td><?php if ($this->data['current_page']) { ?>   
                  <?php echo $this->data['current_page']->email; ?>    
                  <?php } ?></td>
                                        <td>
                                            <a href="<?php echo base_url() . 'backend/admin/update_address/' . $this->data['current_page']->id; ?>" title="Edit">
                                                <span class="label label-info">
                                                    <i class="fa fa-pencil"></i> 
                                                </span>
                                            </a> 
                                        </td>
                                    </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- <div class="row text-center">
                <a href="<?= base_url('backend/admin/add_address') ?>" class="btn btn-link"> Add More </a>
            </div> -->
        </div>

    </div>

