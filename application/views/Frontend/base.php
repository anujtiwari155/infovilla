<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en">
   <!-- Mirrored from livedemo00.template-help.com/zencart_54720/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 13 Sep 2016 06:30:06 GMT -->
   <!-- Added by HTTrack -->
   <meta http-equiv="content-type" content="text/html;charset=utf-8" />
   <!-- /Added by HTTrack -->
   <head>
      <title><?php if(isset($title)) { echo $title; } else { echo "Alcoholic"; }?></title>
      <meta charset="utf-8">
      <meta name="keywords" content="Accessories Beer Bourbon Cognac Gin Spirits Tequila Vodka Whiskey Wine ecommerce, open source, shop, online shopping, store ">
      <meta name="description" content="">
      <meta name="author" content="Softgators&reg; Team and others"/>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="generator" content=""/>
      <link rel="icon" href="http://static.livedemo00.template-help.com/zencart_54720/favicon.ico" type="image/x-icon"/>
      <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900&amp;subset=latin,cyrillic-ext,greek-ext,greek,vietnamese,latin-ext,cyrillic' rel='stylesheet' type='text/css'/>
      <link href='http://fonts.googleapis.com/css?family=Grand+Hotel&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'/>
      <link rel="canonical" href="index.html"/>
      <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" />
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
      <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
      <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" />
      <link rel="stylesheet" type="text/css" href="<?= base_url('assets/frontend/css/stylesheet_categories.css') ?>"/>
      <link rel="stylesheet" type="text/css" href="<?= base_url('assets/frontend/css/stylesheet_custom.css') ?>"/>
      <link rel="stylesheet" type="text/css" href="<?= base_url('assets/frontend/css/stylesheet_font-awesome.min.css') ?>"/>
      <link rel="stylesheet" type="text/css" href="<?= base_url('assets/frontend/css/stylesheet_lightbox-0.5.css') ?>"/>
      <link rel="stylesheet" type="text/css" href="<?= base_url('assets/frontend/css/stylesheet_mega_menu.css') ?>"/>
      <link rel="stylesheet" type="text/css" href="<?= base_url('assets/frontend/css/stylesheet_product_list.css') ?>"/>
      <link rel="stylesheet" type="text/css" href="<?= base_url('assets/frontend/css/stylesheet_responsive.css') ?>"/>
      <link rel="stylesheet" type="text/css" href="<?= base_url('assets/frontend/css/stylesheet_suggestionbox.css') ?>"/>
      <link rel="stylesheet" type="text/css" href="<?= base_url('assets/frontend/css/index_home.css') ?>"/>
      <link rel="stylesheet" type="text/css" href="<?= base_url('assets/frontend/css/style.css') ?>"/>
      <script src="<?= base_url() ?>assets/js/jquery.min.js" type="text/javascript"></script>
      <link rel="stylesheet" type="text/css" href="<?= base_url('assets/select/select2.css') ?>"/>
      <script src="<?= base_url() ?>assets/select/select2.js" type="text/javascript"></script>
      <script type="text/javascript" src="<?= base_url('assets/frontend/jscript/jscript_jquery.elevateZoom-3.0.8.min.js') ?>"></script>

      <?php if ($user_area_zip == 0) { ?>
        <script type="text/javascript">
          $(document).ready(function(){
            $("#myModal").modal({
                backdrop: 'static',
                keyboard: false
            });
          });
        </script>
      <?php } ?>
      <script>
        function getLocation() {
            if (navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(showPosition);
            } else { 
              x.innerHTML = "Geolocation is not supported by this browser.";
            }
        }

        function showPosition(position) {
          
          $.ajax({
            url: "https://maps.googleapis.com/maps/api/geocode/json?latlng="+ position.coords.latitude +","+ position.coords.longitude+"&key=AIzaSyBVlsQAXrdVlCsw6PhjNffS1j52XCognHE",
            success: (response) => {
              console.log(response);
              $.each(response.results, function(){
                $.each(this.address_components,function() {
                  if(this.types == 'postal_code') {
                    $zip_code = this.long_name;
                  console.log($zip_code)
                  }
                });
              });
              set_zip_code($zip_code);
            }
          });
            /*x.innerHTML = "Latitude: " + position.coords.latitude + 
            "<br>Longitude: " + position.coords.longitude;*/
        }
      </script>
      
      <script type="text/javascript">
         var base_url = "<?php echo base_url() ?>";
           var lastScrollTop = 0;
           $(window).scroll(function(event){
              var st = $(this).scrollTop();
              if (st > 250){
               $('.stickUpTop1.fix').css('position','relative');
              } else {
               $('.stickUpTop1.fix').css('position','relative');
              }
              lastScrollTop = st;
           });
      </script>
      <script type="text/javascript">
         $(document).ready(function(){
             // Defining the local dataset
             var search_key = ['<?= $key_words ?>'];
             
             // Constructing the suggestion engine
             var search_key = new Bloodhound({
                 datumTokenizer: Bloodhound.tokenizers.whitespace,
                 queryTokenizer: Bloodhound.tokenizers.whitespace,
                 local: search_key
             });
             
             // Initializing the typeahead
             $('.typeahead').typeahead({
                 hint: true,
                 highlight: true, /* Enable substring highlighting */
                 minLength: 1 /* Specify minimum characters required for showing result */
             },
             {
                 name: 'search_key',
                 source: search_key
             });
         });  
      </script>
      <style type="text/css">
         .typeahead {
            color: #000;
         }
         .typeahead_bg:not([name = search]) {
            background-color: #fff !important;
         }
      </style>
   </head>
    <body id="indexHomeBody">
      <div id="page">
        <header>
           <div class="header_bg">
              <div class="nav">
                 <div class="stickUpTop1 ">
                    <div class="container">
                       <div class="row">
                          <nav class="navbar navbar-findcond navbar-fixed-top">
                             <div class="container">
                                <div class="navbar-header">
                                   <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
                                      <span class="sr-only">Toggle navigation</span>
                                      <span class="icon-bar"></span>
                                      <span class="icon-bar"></span>
                                      <span class="icon-bar"></span>
                                   </button>
                                   <button type="button" class="brand navbar-toggle collapsed"  data-target="#navbar">
                                   <span class="brand"><a class="brand1" href="<?= base_url('more') ?>">Brands</a></span>
                                   </button>
                                   <button type="button" class="brand navbar-toggle collapsed"  data-target="#navbar">
                                   <span class="Category"><a class="brand1" href="<?= base_url('categories') ?>">Categories</a></span>
                                   </button>
                                   <a class="navbar-brand" href="<?= base_url() ?>">Wine Shop</a>
                                </div>
                                <div class="collapse navbar-collapse" id="navbar">
                                   <ul class="nav navbar-nav navbar-right">
                                      <li class="dropdown">
                                         <a id="add_cart" style="padding: 10px;" href="<?= $this->cart->total_items() > 0 ? base_url('basket') : '#'?>"  aria-expanded="false">
                                            <div class="cart_1"><i class="fa fa-shopping-cart"></i>  Cart <span class="badge" id="cart_count">( <?= $this->cart->total_items() ?> )</span></div>
                                         </a>
                                      </li>
                                      <li class="dropdown">
                                         <div >
                                            <div id="currencies-block-top" class="top_dropdown_menu">
                                               <form name="currencies" id="currencies_form" action="" style="padding: 10px;" method="get">
                                                  <?php if($login_user != 'Guest') { ?>
                                                  <div class="btn-group">
                                                     <span class="trigger_down dropdown-toggle" data-toggle="dropdown">
                                                     <span class="lbl"><?= $login_user->first_name ." ". $login_user->last_name ?></span>
                                                     </span>
                                                     <ul class="dropdown-menu" role="menu">
                                                        <li class='current_cur'><a href="<?= base_url('edit_profile') ?>">Edit Profile</a></li>
                                                        <li class='current_cur'><a href="<?= base_url('my_order') ?>">My Order</a></li>
                                                        <li class='current_cur'><a href='<?= base_url('logout/home') ?>' >Logout</a></li>
                                                     </ul>
                                                  </div>
                                                  <?php } else { ?>
                                                  <ul class="header_user_info customer_links login">
                                                     <li><?php echo "<a href='" . base_url('login') . "' class='show-modal'> Log In </a>"; ?></li>
                                                     &nbsp&nbsp&nbsp
                                                     <li><a style="display: inline;" class="" href="<?= base_url('sign_up')?>">Sign Up</a></li>
                                                  </ul>
                                                  <?php } ?>
                                               </form>
                                            </div>
                                         </div>
                                      </li>
                                   </ul>
                                   <form class="navbar-form navbar-right search-form" role="search" action="<?= base_url('Main/search_main') ?>" method="get">
                                      <div class="input-group search">
                                         <input type="text" name="search" class="form-control typeahead typeahead_bg" placeholder="Search Product, Brand, Category ..." autocomplete="off" spellcheck="false" />
                                         <span class="input-group-btn srchbtn">
                                         <input class="btn btn-success main_search" type="submit" value="&#128269;" />
                                         </span>
                                   </form>
                                   </div>
                                </div>
                          </nav>
                        </div>
                    </div>
                 </div>
              </div>
              <div class="bottom">
                <div class="container">
                  <div class="row clearfix">
                    <div class="col-xs-12 col-md-8">
                      <div id="header_logo">
                        <a href="<?= base_url() ?>"><img src="<?= base_url('assets/frontend/images/logo.png') ?>" alt=""/></a>
                      </div>
                    </div>
                    <?php if(isset($user_area_zip) && $user_area_zip != 0) { ?>
                      <div class="col-md-4 current_loacation">
                        Current Zip Code: <?= $user_area_zip ?>&nbsp;&nbsp;
                        <button type="button" class=" btn-sm btn btn-primary" onclick="$('#myModal').modal();">Change Zip</button>
                      </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              </div>
              <div class="cat-title">Menu</div>
              <div class="stickUpTop ">
                 <div class="stickUpHolder">
                    <div id="mega-wrapper" class="stickUpTop">
                       <div class="container">
                          <ul class="mega-menu col-sm-12">
                             <?php $width = (int)100/sizeof($categories_0); foreach ($categories_0 as $category) { ?>
                             <li class="categories-li" style="width:<?php echo $width.'%'; ?> !important; text-align:center;">
                                <a class="drop"><?= $category->name ?></a> 
                                <div class="dropdown col-9">
                                   <div class="levels">
                                      <ul class="level2">
                                         <li>
                                            <div class="drdpimg"><img src="<?= base_url('assets/frontend/images/menu-wine.jpg') ?>" alt="" />
                                            </div>
                                         </li>
                                         <?php foreach ($categories_1 as $category1) { 
                                            if($category1->parent_id == $category->id) { ?>
                                         <li data-match-height="cat-ul-gen" class="submenu col-inner">
                                            <a href="<?= base_url('category/'.$category1->slug) ?>" ><i class="fa fa-angle-double-right" aria-hidden="true">&nbsp<?= $category1->name ?></i></a>
                                            <!-- <ul class="level3">
                                               <?php foreach ($categories_2 as $category2) { 
                                                  if($category2->parent_id == $category1->id) { ?>
                                               <li>
                                                  <a href="<?= base_url('category/'.$category2->slug) ?>"><?= $category2->name ?></a>
                                               </li>
                                               <?php } } ?>
                                            </ul> -->
                                         </li>
                                         <?php } }  ?>
                                      </ul>
                                   </div>
                                   <div class="clearfix"></div>
                                   <div class="categories-banners"></div>
                                </div>
                             </li>
                             <?php } ?>
                          </ul>
                       </div>
                    </div>
                 </div>
                 <ul class="col-md-12 header_user_info customer_links" >
                    <?php foreach ($brand_list as $brand) { ?>
                    <li style="line-height: 30px !important;">
                       <a href="<?= base_url('brand/'.$brand->slug) ?>"><?php echo ucfirst($brand->name); ?></a>
                    </li>
                    <?php }  ?> 
                    <li style="line-height: 30px !important">
                       <a href="<?= base_url('more') ?>">more &gt;&gt;</a>
                    </li>
                 </ul>
              </div>
        </header>
        <?= $contents; ?>
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <footer>
           <div class="footer" id="footer">
              <div class="container">
                 <div class="row">
                    <div class="col-lg-2  col-md-2 col-sm-4 col-xs-6">
                       <h3> Useful Info </h3>
                       <ul>
                          <?php foreach ($pages as $page) { ?>
                             <li>
                                <a href="<?= base_url('page/'.$page->slug) ?>"> <?php echo ucfirst($page->menu->menu); ?> </a>
                             </li>
                          <?php } ?>
                          <li> <a href="<?= base_url('contact') ?>"> Contact us </a> </li>
                          <li> <a href="<?= base_url('vendor') ?>"> Sell on InfoVilla </a> </li>
                       </ul>
                    </div>
                    <div class="col-lg-3  col-md-3 col-sm-4 col-xs-6">
                       <h3> About us</h3>
                       <p style="color: #78828D;">At Infoville Inc, our mission is - To continuously add value to our global clients by leveraging our best people, processes, technology and exceed their expectations</p>
                    </div>
                    <div class="col-lg-3  col-md-3 col-sm-4 col-xs-6">
                       <h3> Head Office</h3>
                       <p style="color: #78828D;">
                          2162 Route 206<br>
                          2nd Floor<br>
                          Montgomery NJ 08502
                          USA<br>
                          Phone: (732) 331-5282<br>
                          Fax: 610-956-3550<br>
                          E-mail: info@infovilleinc.com
                       </p>
                    </div>
                    <div class="col-lg-4  col-md-4 col-sm-6 col-xs-12 get-in-touch">
                       <ul>
                          <span class ="need-help">Need help ? get in touch</span>
                          <span class="number"><h2>1-800-542-1021</h2></span>
                       </ul>
                       <ul class="social">
                          <li> <a href="#"> <i class=" fa fa-facebook">   </i> </a> </li>
                          <li> <a href="#"> <i class="fa fa-twitter">   </i> </a> </li>
                          <li> <a href="#"> <i class="fa fa-google-plus">   </i> </a> </li>
                          <li> <a href="#"> <i class="fa fa-pinterest">   </i> </a> </li>
                          <li> <a href="#"> <i class="fa fa-youtube">   </i> </a> </li>
                       </ul>
                    </div>
                 </div>
              <!--/.row--> 
              </div>
              <!--/.container--> 
           </div>
           <!--/.footer-->
           <div class="footer-bottom">
              <div class="container">
                 <p class="pull-left"> Copyright © infovilleinc 2014. All right reserved. </p>
                 <div class="pull-right">
                    <ul class="nav nav-pills payments">
                       <li><i class="fa fa-cc-visa"></i></li>
                       <li><i class="fa fa-cc-mastercard"></i></li>
                       <li><i class="fa fa-cc-amex"></i></li>
                       <li><i class="fa fa-cc-paypal"></i></li>
                    </ul> 
                 </div>
              </div>
           </div>
           <!--/.footer-bottom--> 
        </footer>
      </div>

      <!-- Modal to get Area PIN  -->
      <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h3 class="modal-title">Share Your Location</h3>
            </div>
            <div class="modal-body text-center">
              <img src="<?= base_url('assets/img/deliver_beer.jpg') ?>">
              <h4>Let Us Know Where to deliver Your Product</h4>
              <div class="row" style="padding: 20px 0">
                <div class="col-md-5">
                  <input type="text" class="form-control" id="zip_code_user" value="<?= (isset($user_area_zip) && $user_area_zip != 0) ? $user_area_zip : '' ?>" placeholder="Zip Code" name="area_zip">
                </div>
                <div class="col-md-2"><span class="text-primary" style="font-size: 20px;">OR</span></div>
                <div class="col-md-5">
                  <button type="button" class="btn btn-sm btn-primary" onclick="getLocation();" >Use your Current Location</button>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" onclick="set_zip_code($('#zip_code_user').val());">Submit</button>
            </div>
          </div>
          
        </div>
      </div>

      <div class="modal fade" id="sys_modal" role="dialog" aria-labelledby="sys_modal_label" aria-hidden="true"></div>
      <script src="<?= base_url() ?>assets/js/bootstrap.min.js" type="text/javascript"></script>
      <script src="<?= base_url() ?>assets/js/material.min.js"></script>
      <script type="text/javascript" src="<?= base_url('assets/frontend/jscript/jscript_jquery.equalheights.js') ?>"></script>
      <script type="text/javascript" src="<?= base_url('assets/frontend/jscript/jscript_jquery.matchHeight.js') ?>"></script>
      <script type="text/javascript" src="<?= base_url('assets/frontend/jscript/jscript_jquery.nivo.slider.pack.js') ?>"></script>
      <script type="text/javascript" src="<?= base_url('assets/frontend/jscript/jscript_jquery.ui.totop.js') ?>"></script>
      <script src="<?= base_url('assets/js/jquery.form.js') ?>"></script>
      <script type="text/javascript" src="<?= base_url('assets/frontend/jscript/script.js') ?>"></script>
    </body>
</html>