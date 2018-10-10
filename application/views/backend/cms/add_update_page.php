<div class="main main-raised">
    <div class="profile-content" style="padding:3%">
        <div class="container">
            <div class="row">
                <div class="profile">
                    <h3>Add Pages</h3>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="col-md-12">
                        <?php $this->load->view('backend/includes/error_message'); ?> 
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Page Menu</label>
                            <select name="menu_id" class="form-control">
                                <option value="">Select Menu</option>
                                <?php if (isset($menus) && $menus!=null) {
                                        foreach ($menus as $menu) { ?>                      
                                            <option value="<?php echo $menu->id ?>" <?php if(set_value('menu_id')&& set_value('menu_id')==$menu->id)  echo 'selected'; elseif(isset($pages->menu_id) && $pages->menu_id==$menu->id) echo 'selected'; ?>> <?php echo $menu->menu ?></option>   
                                <?php }} ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                            <div class="form-group">
                                <label>Page Title</label>
                                <input type="text" name="title" class="form-control" value="<?php if(set_value('title'))  echo set_value('title'); elseif(isset ($pages->title)) echo $pages->title;?>">
                            </div>
                    </div>
                    <?php if(isset ($pages->slug) && $pages->slug!=''){?>
                    <div class="col-md-6">
                            <div class="form-group">
                                <label>Url Rewrite</label>
                                <input type="text" name="slug" class="form-control" value="<?php if(set_value('slug'))  echo set_value('slug'); elseif(isset ($pages->slug)) echo $pages->slug;?>" placeholder="Url Rewrite">
                            </div>
                    </div>
                    <?php }?>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Meta Keywords</label>
                            <input type="text" name="meta_keywords" class="form-control" value="<?php if(set_value('meta_keywords'))  echo set_value('meta_keywords'); elseif(isset ($pages->meta_keywords)) echo $pages->meta_keywords;?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Meta Description</label>
                            <input type="text" name="meta_description" class="form-control" value="<?php if(set_value('meta_description'))  echo set_value('meta_description'); elseif(isset ($pages->meta_description)) echo $pages->meta_description;?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Upload Image</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file">
                                        Browse… <input type="file" name="image1" id="image1">
                                    </span>
                                </span>
                                <input type="text" class="form-control" readonly>
                            </div>
                            <img id='img-upload'/>
                        </div>
                    </div>
                  
                    <div class="col-md-12">
                        <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" id="editor"  class="ckeditor" ><?php if(set_value('description'))  echo set_value('description'); elseif(isset ($pages->description)) echo $pages->description;?></textarea>
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

