<?php if ($this->session->flashdata("success")){?>  
    <div class="text-success"><?php echo $this->session->flashdata("success") ;?></div>
<?php }?>
<?php if (validation_errors()){ ?>
<div class="text-danger"><?php echo validation_errors();?></div>
<?php }?>
<?php if ($this->session->flashdata("error")){?>
    <div class="text-danger"><?php echo $this->session->flashdata("error") ;?></div>
<?php }?>
<?php if ($this->session->flashdata("warning")){?>
    <div class="text-warning"><?php echo $this->session->flashdata("warning") ;?></div>
<?php }?>