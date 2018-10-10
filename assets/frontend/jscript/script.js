$(document).on('click', '.show-modal', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');
    $.get(url, function (data) {
        $('#sys_modal').modal();
        $('#sys_modal').html(data);
        //$.material.init();
        //$(document).find('.date-field').datepicker({format: "yyyy-mm-dd"});
    }).success(function () {
        //$('input:text:visible:first').focus();
    });
});

var options = {
    success: showResponse  // post-submit callback
};

// bind form using 'ajaxForm'
$(document).on('submit', '.modal-form', function () {
    $(this).find('input[type="submit"]').attr('disabled', 'disabled').val('Please wait..');
    $(this).ajaxSubmit(options);
    return false;
});
// post-submit callback
function showResponse(responseText, statusText, xhr, form) {
    console.log(responseText);
    data = $.parseJSON(responseText);
    console.log(data);
    if (data.type === 'success') {
        if(typeof(data.url) != "undefined") {
          models = '';
          if(typeof(data.is_product) != "undefined" && data.is_product == 'product') {
            $.each(data.response, function (key, value) {
                  models += '<option value="' + value.id + '">' + value.name + '</option>';
              });
            $('#sys_modal').modal('hide');
              $('#parent_id_1').html('');
              $('#parent_id_1').append(models);
          } else {
            $('#sys_modal').modal('hide');
            $('#page_content').load(data.url+'#page_content');
          }
        } else {
          alert(data.message);
          location.reload();
        }
    } else if (data.type === 'error') {
        alert(data.message);
        $(form).find('input[type="submit"]').removeAttr('disabled').val('Update');
    }
}


var Product = {
	setCurrentImage: (src) => {
		//alert(src);
		$('#displayImg').attr('src',src);
		$('#zoom_img').attr('href',src);
		
	}
}

function updateCart(value,rowid,product_id) {
	//alert(product_id);
	$.post(base_url+"frontend/Checkout/updatecart",
		{
			rowid: rowid,
			value: value,
      product_id: product_id
		},
		function(response) {
			var result = JSON.parse(response);
			if(result.status === 'success') {
				location.reload();
			} else {
        $("[rowid = '"+rowid+"']").val(result.cur_qty);
        alert(result.description);
      }
		});
}

var Cart = {
	remove: (rowid) => {
		$.ajax({
			url: base_url+"frontend/Checkout/remove_product/"+rowid,
			success: (response) => {
				var result = JSON.parse(response);
				if(result.status === 'success') {
					location.reload();
				}
			}
		})
	},
  	add_product: (product_id) => {
  		$.ajax({
  			url: base_url+"frontend/Checkout/add_product/"+product_id,
  			success: (response) => {
  				var result = JSON.parse(response);
  				if(result.status === 'success') {
  					$('#cart_count').html('( '+result.products+' )')
  					$('#add_cart').attr('href', base_url+'basket')
  				}
  			}
  		})
  	}
}

function setBillingAddress(id) {
	if($('#'+id).prop("checked") == true) {
		$('#first_name').val($('#fname').html());
		$('#last_name').val($('#lname').html());
		$('#address1').val($('#daddress1').html());
		$('#city').val($('#dcity').html());
		$('#zip').val($('#dzip').html());
		$('#state').val($('#dstate').html());
		$('#country').val($('#dcountry').html());
		$('#phone').val($('#dphone').html());
		$('#email').val($('#demail').html());
	} else {
		$('#first_name').val("");
		$('#last_name').val("");
		$('#address1').val("");
		$('#city').val("");
		$('#zip').val("");
		$('#state').val("");
		$('#country').val("");
		$('#phone').val("");
		$('#email').val("");
	} 
}

var Validate = {
  zip: (product_id,zip) => {
    $.ajax({
      url: base_url+"frontend/Checkout/validate_pin?product_id="+product_id+"&zip="+zip,
      success: (response) => {
        var result = JSON.parse(response);
        if (result.status === 'success') {
          $('#buy_now').removeAttr('disabled');
          $('#zip_check').removeClass('text-danger').addClass('text-success').html("Available");
        } else {
          $('#buy_now').attr('disabled',true);
          $('#zip_check').removeClass('text-success').addClass('text-danger').html("Currently out of stock in this area.");
        }
      }
    })
  },
  cartProduct: (zip) => {
    $.ajax({
      url: base_url+"frontend/Checkout/validate_cart_products?zip="+zip,
      success: (response) => {
        var result = JSON.parse(response);
        var flag = 1;
        var check_one = 0;
        if (result.status === 'success') {
          var vendors = [];
          $.each(result.report, function (key, value) {
            console.log('product_id :-'+ value.product_id);
            if (value.vendor != '') {
              vendors.push(value.vendor+'-'+value.product_id);
              check_one = 1;
              $('#val_pr'+value.product_id).removeClass('text-danger').addClass('text-success').html('Available');
            } else {
              console.log(value.status);
              flag = 0;
              $('#val_pr'+value.product_id).removeClass('text-success').addClass('text-danger').html('Not Available');
            }            
          });
          $('#asso_vendors').val(vendors);
          $('#validated_pro').attr('href','#validated_products');
          if (flag && check_one) {
            $('#proceed_btn').show();
            $('#cart_alert').removeClass('text-danger').addClass('text-success').html("All Products are Available at your area")
          } else if(check_one) {
            $('#proceed_btn').show();
            $('#cart_alert').removeClass('text-success').addClass('text-danger').html("Some Products are Not Available at your area")
          } else {
            $('#proceed_btn').hide();
            $('#cart_alert').removeClass('text-success').addClass('text-danger').html("Sorry No Products Available at your area please try other location")
          }
          $('#zip').val(zip);
          $('#validated_pro').trigger('click');
        }
      }
    });
    //alert(zip);
  },
  processCart: (zip) => {
    if ($('#cart_alert').hasClass('text-danger')) {
      var res = confirm("Only Available products will be ordered. Do you want to continue..?");
      if(res) {
        $.ajax({
          url: base_url+"frontend/Checkout/process_cart?zip="+zip,
          success: (response) => {
            $('#f_product').attr('href','#final_product');
            $("#final_product").load( base_url+'frontend/Checkout/load_final_product' + "#final_product");
            $('#f_product').trigger('click');
          }
        })
      } else {
        alert('order cancel');
      }
    } else {
      $('#address_details').attr("href","#input_addr");
      $('#address_details').trigger('click');
    }
  },
  process_final_pro: () => {
    $('#address_details').attr("href","#input_addr");
    $('#address_details').trigger('click');
  }
}

function set_zip_code(zip) {
  if (zip == '') {
    alert("please enter Zip Code")
    return false;
  }
  $.ajax({
    url: base_url+"Main/set_zip_code/"+zip,
    success: (response) => {
      $('#myModal').modal('toggle');
      location.reload();
    }
  });
    
}
/*=========================================================*/
