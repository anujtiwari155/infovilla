<style type="text/javascript">
  section#contact {
    background-color: #222222;
    background-image: url('assets/img/map-image.png');
    background-position: center;
    background-repeat: no-repeat;
}
</style>
<section>
    <div class="container">
      <h1>Contact Address</h1><br>
        <div class="row text-center">
          <div class="col-sm-3 col-xs-6 first-box">
              <h1><span class="fa fa-phone" aria-hidden="true"></span></h1>
              <h3>Phone</h3>
              <p>
                  <?php if ($this->data['current_page']) { ?>   
                  <?php echo $this->data['current_page']->phone; ?>    
                  <?php } ?> 
              </p><br>
          </div>
          <div class="col-sm-3 col-xs-6 second-box">
              <h1><span class="fa fa-home" aria-hidden="true"></span></h1>
              <h3>Location</h3>
              <p>
                  <?php if ($this->data['current_page']) { ?>   
                  <?php echo $this->data['current_page']->location; ?>    
                  <?php } ?> 
              </p><br>
          </div>
          <div class="col-sm-3 col-xs-6 third-box">
              <h1><span class="fa fa-paper-plane" aria-hidden="true"></span></h1>
              <h3>E-mail</h3>
              <p>
                  <?php if ($this->data['current_page']) { ?>   
                  <?php echo $this->data['current_page']->email; ?>    
                  <?php } ?> 
              </p><br>
          </div>
          <div class="col-sm-3 col-xs-6 fourth-box">
            <h1><span class="fa fa-leaf" aria-hidden="true"></span></h1>
              <h3>Web</h3>
              <p>
                  <?php if ($this->data['current_page']) { ?>   
                  <?php echo $this->data['current_page']->web; ?>    
                  <?php } ?> 
              </p><br>
          </div>
        </div>
      </div>

  <section id="contact" style="">
            <div class="container">
                <div class="row">
                    <div class="about_our_company" style="margin-bottom: 20px;">
                        <h1 style="color:#fff;">Cheers With Us</h1>
                        <div class="titleline-icon"></div>
                        <p style="color:#fff;">Contact us for your query. we will respond you soon </p>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-md-10 message">
                        <form name="sentMessage" action="<?= base_url('save_data') ?>" id="contactForm"  method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Your Name *" name="name" id="name" required="" data-validation-required-message="Please enter your name.">
                                        <p class="help-block text-danger"></p>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="Your Email *" name="email" id="email" required="" data-validation-required-message="Please enter your email address.">
                                        <p class="help-block text-danger"></p>
                                    </div>
                                    <div class="form-group">
                                        <input type="tel" class="form-control" placeholder="Your Phone *" id="phone" name="phone" required="" data-validation-required-message="Please enter your phone number.">
                                        <p class="help-block text-danger"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <textarea class="form-control" placeholder="Your Message *" id="message" name="message" required="" data-validation-required-message="Please enter a message."></textarea>
                                        <p class="help-block text-danger"></p>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-lg-12 text-center">
                                    <div id="success"></div>
                                    <button type="submit" class="btn btn-primary btn-md get">Send Message</button>

                                </div>
                            </div>
                        </form>
                    </div>
                   
                </div>
            </div>
        </section>
   </section>
