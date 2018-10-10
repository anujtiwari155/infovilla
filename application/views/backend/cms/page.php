<div class="main main-raised">
    <div class="profile-content" style="padding:3%">
        <div class="container">
            <div class="row">
                <div class="profile">
                    <h3>Manage Web Content (CMS)</h3>
                </div>
                <div class="col-md-12">
                    <div class="col-md-12">
                        <?php $this->load->view('backend/includes/error_message'); ?> 
                    </div>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Page Menu</th>
                                <th>Page Title</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!$pages) {
                                ?>
                                <tr><td colspan="4">No Record</td></tr>
                                <?php
                            } else {
                                foreach ($pages as $page) {
                                    ?>
                                    <tr>
                                        <td><?php echo $page->id; ?></td>
                                        <td><?php echo $page->page_menu; ?></td>
                                        <td><?php echo $page->title; ?></td>
                                        <td><?php echo $page->slug; ?></td>
                                        <td>
                                            <?php if ($page->status == 1) { ?>
                                                <a href="<?php echo base_url() . 'backend/admin/cms?status=false&id=' . $page->id; ?>" onclick="return alertForChangeStatus()">
                                                    <span class="label label-success">
                                                        <i class=" fa fa-check"></i> 
                                                    </span>
                                                </a>
                                            <?php } else { ?>
                                                <a href="<?php echo base_url() . 'backend/admin/cms?status=true&id=' . $page->id; ?>" onclick="return alertForChangeStatus()">
                                                    <span class="label label-danger">
                                                        <i class=" fa fa-times"></i>  
                                                    </span>
                                                </a>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo base_url().'backend/admin/cms/update/'.$page->id;?>" title="Edit">
                                                <span class="label label-info">
                                                <i class="fa fa-pencil"></i> 
                                                </span>
                                            </a> &nbsp;
                                            
                                            <a href="<?php echo base_url().'backend/admin/cms/delete/'.$page->id;?>" title="delete" onclick="return alertForDelete()">
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
            <div class="row text-center">
                <a href="<?php echo base_url().'backend/admin/cms/add' ?>" class="btn btn-link"> Add More </a>
            </div>
        </div>

    </div>

