<section>
   <div class="container">
      <div class="row">
         <div class="col-xs-12"></div>
      </div>
   </div>
   <div class="row">
      <div class="container">
       <div class="col-md-12">
       <?php $counter = 0; if (is_array($products)) {
           foreach ($products as $key => $product) { ?>
            <div class="col-md-3 col-sm-4 col-xs-12 prohyt">
                <div class="thumbnail">
                    <div class="img">
                       <a href="<?= base_url('product/'.$product->slug) ?>"><img src="<?php if(isset($product->product_images[0])) { echo base_url('image/display_image?im='.base_url().'assets/products/').'/'.$product->product_images[0]->product_image->image_url.'&w=250&h=250'; } ?>" class="img-responsive" alt="Burnett's Pineapple Vodka" title=" Burnett's Pineapple Vodka " /></a>
                    </div>
                    <div class="product_drtails">
                       <div class="product-name name">
                       <a class="product-name name" href="<?= base_url('product/'.$product->slug) ?>"><?= ucwords($product->name); ?></a></div>
                       <div class="add_cart" onclick="Cart.add_product('<?= $product->id ?>');"><span class="pull-left">Add to Cart: <i class="fa fa-shopping-cart" aria-hidden="true"></i></span>
                      <?php if (isset($this->session->user_area_zip) && $this->session->user_area_zip != 0) { ?>
                        <span class="pull-right">Price: $<?= $product->product_min_price($this->session->user_area_zip)->mrp ?></span>
                      <?php } else { ?>
                        <span class="pull-right">Price: $<?= $product->mrp ?></span>
                      <?php } ?>
                       <div class="clearfix"></div>
                    </div>
                  </div>
               </div>                         
            </div> 
             <?php $counter++; ?>
             <?php if($counter == 4) $counter = 0; ?>       
             <?php } 
       } else {
          print_r("<div style='padding:4%;'><h3>".$products."</h3></div>");
        } ?>       
  
       </div>
     </div> 
   </div>
    <div class="tm_custom_block" class="img-responsive"> 
      <div class="container">
         <ul class="row">
            <li data-match-height="items-a" class="col-xs-12 col-md-4 item1">
               <div data-match-height="items-a" class="inner">
                  <h2>Upcomming</h2>
                  <p><?php echo $contents->upcomming; ?></p>
               </div>
            </li>
            <li data-match-height="items-a" class="col-xs-12 col-md-4 item2">
               <div data-match-height="items-a" class="inner">
                  <h2>New</h2>
                  <p><?php echo $contents->new; ?></p>
               </div>
            </li>
            <li data-match-height="items-a" class="col-xs-12 col-md-4 item3">
               <div data-match-height="items-a" class="inner">
                  <h2>Most Wanted</h2>
                  <p><?php echo $contents->most; ?></p>
               </div>
            </li>
         </ul>
          <ul class="row">
            <li data-match-height="items-a" class="col-xs-12 col-md-4 item1">
               <div data-match-height="items-a" class="inner">
                  <img class="img-responsive" src="<?= base_url('assets/img/adevetiesment/'.$contents->upcomming_img) ?>" alt="no image found">
               </div>
            </li>
            <li data-match-height="items-a" class="col-xs-12 col-md-4 item2">
               <div data-match-height="items-a" class="inner">
                  <img class="img-responsive" src="<?= base_url('assets/img/adevetiesment/'.$contents->new_img) ?>" alt="no image found">
               </div>
            </li>
            <li data-match-height="items-a" class="col-xs-12 col-md-4 item3">
               <div data-match-height="items-a" class="inner">
                  <img class="img-responsive" src="<?= base_url('assets/img/adevetiesment/'.$contents->most_img) ?>" alt="no image found">
               </div>
            </li>
         </ul>
      </div>
   </div>
</section>