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
                               
                                <th>Name</th>
                                <th>E-mail</th>
                                <th>Phone</th>
                                <th>Message</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!$list_contacts) {
                                ?>
                                <tr><td colspan="4">No Record</td></tr>
                                <?php
                            } else {
                                foreach ($list_contacts as $list) {
                                    ?>
                                    <tr>
                                        
                                        <td><?php echo $list->name; ?></td>
                                        <td><?php echo $list->email; ?></td>
                                        <td><?php echo $list->phone; ?></td>
                                        <td><?php echo $list->message; ?></td>
                                        <td>
                                            
                                        </td>
                                        <td>
                                            <a href="<?php echo base_url().'backend/admin/delete_contact/'.$list->id;?> " title="delete" onclick="return alertForDelete()">
                                                <span class="label label-danger">
                                                <i class="fa fa-trash-o"></i>
                                                </span>
                                            </a> 
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                              ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class='pagination_link'>
                <?php echo $this->pagination->create_links(); ?>
            </div>
        </div>

    </div>

