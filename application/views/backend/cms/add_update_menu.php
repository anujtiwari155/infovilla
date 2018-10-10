<div class="main main-raised">
    <div class="profile-content" style="padding:3%">
        <div class="container">
            <div class="row">
                <div class="profile">
                    <h3>Add Menu</h3>
                </div>
                <form action="" method="post">
                    <div class="col-md-12">
                        <?php $this->load->view('backend/includes/error_message'); ?> 
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Parent</label>
                            <select name="parent" class="form-control">
                                <option value="0"> Root</option>
                                <?php
                                if (isset($menus) && $menus != null) {
                                    foreach ($menus as $menu) {
                                        ?>                      
                                        <option value="<?php echo $menu->id ?>" <?php if (isset($menu_update) && $menu_update->parent == $menu->id) echo 'selected'; ?>> <?php echo $menu->menu ?></option>   
                                    <?php }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Menu Name</label>
                            <input type="text" name="menu" class="form-control" value="<?php if (isset($menu_update)) echo $menu_update->menu?>">
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="col-md-12">
                            <div class="form-group">                                                                
                                <button class="btn btn-link" type="submit">Save</button>
                                <a href="<?php echo base_url() . 'backend/admin/menus' ?>" class="btn btn-danger" >Cancel</a>
                            </div>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>

</div>

