
<section>
   <div class="container" style="margin: 0 20px;">
      <div class="row">
         <div class="col-sm-2 col-sm-2 nopr">
            <div class="center_column">
            <?php if (is_array($products) && count($products) > 0) {?>
               <div class="centerColumn" id="indexDefault">
                  <h4 class="centerBoxHeading">Filters</h4>
                  <form action="" method="get">
                     <div class="filter">
                        <div class="brand_filters">
                           <label>Brands</label>
                           <?php foreach ($brands as $brand) { ?>
                              <div class="checkbox">
                                <label><input type="checkbox" <?php if(isset($default_brands) && in_array($brand->id ,$default_brands)) { echo 'checked';} ?> name="filter_brand[]" value="<?= $brand->id ?>"><?= $brand->name ?></label>
                              </div>
                           <?php } ?>
                        </div>
                        <hr/>
                        <?php foreach ($attributes as $attribute) { ?>
                           <label><?= $attribute->name ?></label>
                           <?php foreach ($attribute_values as $attribute_value) { 
                              if($attribute_value->attribute_id == $attribute->id) {?>
                              <div class="checkbox">
                                <label><input type="checkbox" <?php if(isset($default_attributes) && in_array($attribute_value->id,$default_attributes)) { echo 'checked'; } ?> name="attribute_value[]" value="<?= $attribute_value->id ?>"><?= $attribute_value->value ?></label>
                              </div>
                           <?php } } ?>
                        <?php } ?>
                     </div>
                     <input type="submit" class="btn btn-primary" value="Search">
                  </form>
               </div>
               <?php } ?>
            </div>
         </div>
         <div class="main-col col-sm-10 col-sm-10" style="border-left: 1px solid #dcdcdc;">
            <div class="row">
               <div class="center_column col-xs-12 col-sm-12 with_col">
                  <div class="centerColumn" id="indexDefault">
                     <div id="indexDefaultMainContent"></div>
                     <div class="centerBoxWrapper clearfix" id="featuredProducts">
                        <h2 class="centerBoxHeading">Featured Products</h2>
                        <div class="row">
                        <div class="container">
                         <div class="col-md-12">
                         <?php $counter = 0; ?>
                         <?php if (is_array($products) && count($products) > 0) { ?>       
                         <?php foreach ($products as $key => $product) { ?>
                            <div class="col-md-3 col-xs-12 col-sm-4 prohyt">
                                <div class="thumbnail">
                                    <div class="img">
                                       <a href="<?= base_url('product/'.$product->slug) ?>"><img src="<?php if(isset($product->product_images[0])) { echo base_url('image/display_image?im='.base_url().'assets/products/').'/'.$product->product_images[0]->product_image->image_url.'&w=250&h=250'; } ?>" class="img-responsive" alt="Burnett's Pineapple Vodka" title=" Burnett's Pineapple Vodka "/></a>
                                    </div>
                                    <div class="product_drtails">
                                       <div class="product-name name">
                                       <a class="product-name name" href="<?= base_url('product/'.$product->slug) ?>"><?= ucwords($product->name); ?></a></div>
                                       <div class="add_cart" onclick="Cart.add_product('<?= $product->id ?>');"><span class="pull-left">Add to Cart: <i class="fa fa-shopping-cart" aria-hidden="true"></i></span>
                                       <span class="pull-right">Price: $<?= $product->mrp ?></span>
                                       <div class="clearfix"></div>
                                    </div></div>
                               </div>                         
                            </div> 
                            <?php } }else { ?>
                              <h3>Sorry No Product To show...</h3>
                           <?php } ?>
                          </div>
                        </div>
                     </div>
                    </div>
                    <?php echo $this->pagination->create_links(); ?>
                  </div>
               </div>
            </div>
         </div>
         <aside class="column left_column col-xs-12 col-sm-3"></aside>
      </div>
      <div class="clearfix"></div>
   </div>
</section>