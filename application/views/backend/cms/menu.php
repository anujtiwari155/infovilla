<div class="main main-raised">
    <div class="profile-content" style="padding:3%">
        <div class="container">
            <div class="row">
                <div class="profile">
                    <h3>List of Menus</h3>
                </div>
                <div class="col-md-12">
                    <div class="col-md-12">
                        <?php $this->load->view('backend/includes/error_message'); ?> 
                    </div>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Menus</th>
                                <th>Parent</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!$menus) {
                                ?>
                                <tr><td colspan="4">No Record</td></tr>
                                <?php
                            } else {
                                foreach ($menus as $menu) {
                                    ?>
                                    <tr>
                                        <td><?php echo $menu->id; ?></td>
                                        <td><?php echo $menu->menu; ?></td>
                                        <td>
                                            <?php
                                            if ($menu->parent_name != '')
                                                echo $menu->parent_name;
                                            else
                                                echo 'Root';
                                            ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo base_url() . 'backend/admin/menus/update/' . $menu->id; ?>" title="Edit">
                                                <span class="label label-info">
                                                    <i class="fa fa-pencil"></i> 
                                                </span>
                                            </a>&nbsp;
                                            <a href="<?php echo base_url() . 'backend/admin/menus/delete/' . $menu->id; ?>" title="delete" onclick="return alertForDelete()" >
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
                <a href="<?= base_url('backend/admin/menus/add') ?>" class="btn btn-link"> Add More </a>
            </div>
        </div>

    </div>

