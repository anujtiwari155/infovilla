$key = 1;
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

var Category = {
  category_select: function(dataValue,dataId,new_category,sub_category) {
    //console.log($('#'+dataId).index());
    $('#cat_img input').attr('disabled','disabled');
    $('#product_attribute').html('<label for="parent_id_1" id="attr_label" style="display:none;float:left">Attributes</label>');
    $('.new_category_'+new_category).each( function(){
      if($key > $(this).find('#'+dataId).attr('key')) {
        for(var m = parseInt($('#'+dataId).attr('key')) ; m < $key ; m++) {
          n= m+1;
          $('#parent_id_'+n).parent().parent().remove();
        }
      }
    }); 
    $key = $('#'+dataId).attr('key');
    $.ajax({
      url: base_url+"backend/commonfunction/test/"+dataValue,
      success: function (response) {
        var result = JSON.parse(response);
        var models = '';
        if(result.status === 'success') {
          $key++;
          $.each(result.response, function (key, value) {
              models += '<option value="' + value.id + '">' + value.name + '</option>';
          });
          $('#sub_category_'+sub_category).append('<div class="col-md-3 new_category_'+new_category+'"><div class="form-group"><label for="parent_id_'+$key+'">Sub Parent Category</label><select id="parent_id_'+$key+'" key="'+$key+'" name="parent_id[]" onchange="Category.category_select(this.value,this.id,'+String(new_category)+','+String(sub_category)+')" class="form-control"><option value="'+dataValue+'">New Category</option>'+models+'</select></div></div>');
          $('.add_category').attr('id', $key);
          $('#cat_num').val($key);
        } else {
          $.ajax({
            url: base_url+"backend/commonfunction/get_attr/"+dataValue,
            success: function(response) {
              var result = JSON.parse(response);
              var attributes = [];
              console.log(result);
              if (result.status === 'success') {
                $.each(result.attribute_details, function (key, value){
                      attributes[value.attr_name] = '';
                  });
                  /*$.each(result.attribute_details, function (key, value){
                      //attributes[value.attr_name] += '<li><input type="checkbox" name="category_attributes[]" value="'+value.attr_value_id+'"/> '+value.attr_value+'</label></li>';
                      attributes[value.attr_name] += value.attr_value_id+' '+value.attr_value;
                  });*/
              //var cat_list = new Array();
              $.each(result.attribute , function (key, value){
                attributes[value.attr_name] = '';
                $.each(result.attribute_details , function (key1, val ){
                   if(val.attr_name == value)
                    attributes[value.attr_name] += '<li><input type="radio" name="'+value+'_attributes" value="'+val.attr_value_id+'"/> '+val.attr_value+'</label></li>';
                 });
                //console.log(cat_list);
                $('#attr_label').show();
                $('#product_attribute').append('<div class="col-md-3"><div class="form-group"><label for="parent_id_1">'+value+'</label>'+
                '<ul>'+attributes[value.attr_name]+'</ul></div></div>');
                //attributes[value.attr_name] = '';
              });
              }
              
            }
          });
        }
      }
    });
  },
  vendor_category_select: (dataValue,dataId,new_category,sub_category) => {
    //console.log($('#'+dataId).index());
    $('#product_attribute').html('<label for="parent_id_1" id="attr_label" style="display:none;float:left">Attributes</label>');
    $('.new_category_'+new_category).each( function(){
      if($key > $(this).find('#'+dataId).attr('key')) {
        for(var m = parseInt($('#'+dataId).attr('key')) ; m < $key ; m++) {
          n= m+1;
          $('#parent_id_'+n).parent().parent().remove();
        }
      }
    }); 
    $key = $('#'+dataId).attr('key');
    $.ajax({
      url: base_url+"vendor/CommonVfunction/test/"+dataValue,
      success: function (response) {
        var result = JSON.parse(response);
        var models = '';
        if(result.status === 'success') {
          $key++;
          $.each(result.response, function (key, value) {
              models += '<option value="' + value.id + '">' + value.name + '</option>';
          });
          $('#sub_category_'+sub_category).append('<div class="col-md-3 new_category_'+new_category+'"><div class="form-group"><label for="parent_id_'+$key+'">Sub Parent Category</label><select id="parent_id_'+$key+'" key="'+$key+'" name="parent_id[]" onchange="Category.vendor_category_select(this.value,this.id,'+String(new_category)+','+String(sub_category)+')" class="form-control"><option value="'+dataValue+'">New Category</option>'+models+'</select></div></div>');
          $('.add_category').attr('id', $key);
          $('#cat_num').val($key);
        } else {
          $.ajax({
            url: base_url+"vendor/CommonVfunction/get_attr/"+dataValue,
            success: function(response) {
              var result = JSON.parse(response);
              var attributes = [];
              if (result.status === 'success') {
                $.each(result.attribute_details, function (key, value){
                      attributes[value.attr_name] = '';
                  });
                  /*$.each(result.attribute_details, function (key, value){
                      attributes[value.attr_name] += '<li><input type="checkbox" name="category_attributes[]" value="'+value.attr_value_id+'"/> '+value.attr_value+'</label></li>';
                  });*/
              $.each(result.attribute , function (key, value){
                attributes[value.attr_name] = '';
                $.each(result.attribute_details , function (key1, val ){
                   if(val.attr_name == value)
                    attributes[value.attr_name] += '<li><input type="radio" name="'+value+'_attributes" value="'+val.attr_value_id+'"/> '+val.attr_value+'</label></li>';
                 });
                $('#attr_label').show();
                $('#product_attribute').append('<div class="col-md-3"><div class="form-group"><label for="parent_id_1">'+value+'</label>'+
                '<ul>'+attributes[value.attr_name]+'</ul></div></div>');
              });
              }
            }
          });
        }
      }
    });
  }
}

var Attribute = {
  add_attr: function(id) {
    id++;
    $('#attribute_value').append('<div class="form-group" id="'+id+'" style="margin-top:0"><input type="text" style="width: 95%;float: left;" class="form-control" name="attr_value[]" id="value_'+id+'"><div onclick="Attribute.remove_attr(this.parentNode.id)" style="height:32px;position:relative;top:10px;float:right">&cross;</div></div>');
    $('.arttibute_add').attr('id',id);
  },
  remove_attr: (his) => {
    $('#'+his).remove();
  },
  list_attributes: function() {
    $.ajax({
      url: base_url+"backend/commonfunction/list_attributes",
      success: function (response) {
        var result = JSON.parse(response);
        var models = '';
        if(result.status === 'success') {
          $.each(result.response, function (key, value) {
              models += '<option value="' + value.id + '">' + value.name + '</option>';
          });
      }
      $('#add_attribute').append('<div class="col-md-3"><div class="form-group"><select name="category_attributes[]" class="form-control category_attribute">'+models+'</select><span onclick="$(this).parent().parent().remove()" >&cross;</span></div></div>');
    }
    });
  }
}

var ajax = {
  brand_add: (is_product) => {
    var brand_name = $('#brand_name').val();
    var brand_code = $('#brand_code').val();
    $('#brand_loader').show();
    $.ajax({
      url: base_url+"backend/commonfunction/brand/add?brand_name="+brand_name+"&brand_code="+brand_code,
      success: function (response) {
        var result = JSON.parse(response);
        var models = '';
        if(result.status === 'success') {
          $.each(result.response, function (key, value) {
              models += '<option value="' + value.id + '">' + value.name + '</option>';
          });
          $('#sys_modal').modal('hide');
          if(is_product == '8989') {
            $('#brands').html('');
            $('#brands').append(models);
          } else {
            location.reload();
          }
        }
      }
    });
  },
  brand_update: (id) => {
    var brand_name = $('#brand_name').val();
    var brand_code = $('#brand_code').val();
    $.ajax({
      url: base_url+"backend/commonfunction/brand/update/"+id+"?brand_name="+brand_name+"&brand_code="+brand_code,
      success: (response) => {
        var result = JSON.parse(response);
        if(result.status === 'success') {
            location.reload();
        }
      }
    });
  },
  brand_delete: (id) => {
    var res = confirm("Want to Delete This Brand!");
    if(res == true) {
      $.ajax({
        url: base_url+"backend/commonfunction/brand/delete/"+id,
        success: (response) => {
          var result = JSON.parse(response);
          if(result.status === 'success') {
              location.reload();
          }
        }
      });
    }
  },
  category_add: function(key,attribute_no,is_product) {
    var attribute_list = [];
    $('.category_attribute').each(function(){
      attribute_list.push(this.value);
    });
    console.log(attribute_list);
    var category_name = $('#category_name').val();
    var category_code = $('#category_code').val();
    var parent_id = $('#parent_id_'+key).val();
    $.post(base_url+"backend/commonfunction/category_add",
      {
        n_category: category_name,
        c_category: category_code,
        parent: parent_id,
        attributes: attribute_list
      },
      function(response) {
        var result = JSON.parse(response);
        var models = '';
        if(result.status === 'success') {
          $.each(result.response, function (key, value) {
              models += '<option value="' + value.id + '">' + value.name + '</option>';
          });
        $('#sys_modal').modal('hide');
        if(is_product == 'product') {
          $('#parent_id_1').html('');
          $('#parent_id_1').append(models);
        } else {
          location.reload();
        }
      }
      });
    /*$.ajax({
      url: base_url+"backend/commonfunction/category_add?category_name="+category_name+"&category_code="+category_code+"&parent_id="+parent_id,
      success: function (response) {
        $('#sys_modal').modal('hide');
        //location.reload();
      }
    }); */
  },
  attribute_delete: (id) => {
    var res = confirm("Want to Delete This Attribute!");
    if(res == true) {
      $.ajax({
        url: base_url+"backend/commonfunction/attribute/delete/"+id,
        success: (response) => {
          var result = JSON.parse(response);
          if(result.status === 'success') {
              location.reload();
          }
        }
      });
    }
  },
  category_delete: (id) => {
    var res = confirm('Want to Delete This Category');
    if(res == true) {
      $.ajax({
        url: base_url+"backend/Allfunction/category/delete/"+id,
        success: (response) => {
          var result = JSON.parse(response);
          if(result.status === 'success') {
              location.reload();
          }
        }
      });
    }
  }

}

var Validate = {
  attribute: function(attribute) {
    $.ajax({
      url: base_url+"backend/commonfunction/attribute_validate?attribute="+attribute,
      success: function(response) {
        if(response == 1) {
          alert('attribute alredy added');
          $('#add_attr').attr('disabled','true');
        } else {
          $('#add_attr').removeAttr('disabled');
        }
      }
    });
  },
  brand: function(brand) {
    $.ajax({
      url: base_url+"backend/commonfunction/brand_validate?brand="+brand,
      success: function(response) {
        if(response == 1) {
          alert('Brand alredy added');
          $('#add_brand').attr('disabled','true');
        } else {
          $('#add_brand').removeAttr('disabled');
        }
      }
    });
  },
  product: function(product) {
    $.ajax({
      url: base_url+"backend/commonfunction/product_validate/"+product,
      success: (response) => {
        if(response == 1) {
          //alert('Product Already Exist if you want to add please update quantity in Inventory');
          $('#product_error').show();
          $('#add_product').attr('disabled','true');
          $form_validate = 1;           // Global variable to check validation at submission Time
          return false;
        } else {
          $('#product_error').hide();
          $('#add_product').removeAttr('disabled');
          $form_validate = 0;           // Global variable to check validation at submission Time
          return true;
        }
        
      }
    });
  },
  category: (category) => {
    $.ajax({
      url: base_url+"backend/commonfunction/category_validate/"+category,
      success: (response) => {
        if(response == 1) {
          //alert('Product Already Exist if you want to add please update quantity in Inventory');
          $('#product_error').show();
          alert('Category Already Exist');
          $('#add_product').attr('disabled','true');
          $form_validate = 1;           // Global variable to check validation at submission Time
          return false;
        } else {
          $('#product_error').hide();
          $('#add_product').removeAttr('disabled');
          $form_validate = 0;           // Global variable to check validation at submission Time
          return true;
        }
        
      }
    });
  }
}

var Image = {
  delete_product : (image_id,display_id) => {
    var res = confirm('Really want to delete this image');
    if(res) {
      $.ajax({
            url: base_url+"backend/commonfunction/delete_img/"+image_id,
            success: function(response) {
              var result = JSON.parse(response);
              $('#'+display_id).remove();
              }
          });
    } else {
    }
  }
}

var Vandor = {
  inputfield: "<div class='col-md-8'>"+
                "<input type='password' name='password' id='store_password' placeholder='Please enter password for your Store' class='form-control'>"+
              "<p>&nbsp;</p></div>"+
              "<div class='col-md-8'>"+
                "<input type='password' onchange='Vandor.validatePassword(this.value)' name='cnf_password' id='store_password_chk' placeholder='Please Re-enter the Password' class='form-control'>"+
              "<p id='true_pass' style='text-align: right;display:none;color:green'>&nbsp;</p><p id='false_pass' style='text-align: right;color:red'>&nbsp;</p></div>",
  submit_btn: "<div class='col-md-8' id='submit_row'>"+
                "<input type='submit' class='btn btn-primary'>"+
              "</div>",
  validateAddress: (email) => {
    if(email != '') {
      $('#brand_loader').show();
      $.ajax({
        url: base_url+"vendor/Vendorfunction/validate_address?email="+email,
        success: (response) => {
          var result = JSON.parse(response);
          $('#main_form_page').html('');
          if (result.status == 'success') {
            $('#alert_msg_fail').html(result.response).hide();
            $('#alert_msg').html(result.response).show();
            $('#vendor_check_email_btn').hide();
            $('#main_form_page').append(Vandor.inputfield);
          } else if(result.status == 'fail') {
            $('#main_form_page').html('');
            $('#vendor_check_email_btn').show();
            $('#alert_msg').html(result.response).hide();
            $('#alert_msg_fail').html(result.response).show();
          }
        }
      });
    } else {
      $('#alert_msg').hide();
      $('#alert_msg_fail').hide();
    }
  },
  validatePassword: (cnf_password) => {
    password = $('#store_password').val();
    if (cnf_password != '') {
      if (password == cnf_password) {
        $('#true_pass').html('Matched').show();
        $('#false_pass').hide();
        $('#main_form_page').append(Vandor.submit_btn);
      } else {
        $('#false_pass').html('Not Matched').show();
        $('#true_pass').hide();
        $('#submit_row').remove();
      }
    }
  },
  deleteVendor: (vendor_id) => {
    var res = confirm('Really want to Delete this Vendor...?');
    if (res) {
      if (vendor_id != '') {
        $.ajax({
          url: base_url+"backend/Commonfunction/delete_vendor/"+vendor_id,
          success: (response) => {
            var result = JSON.parse(response);
            alert(result.description);
          }
        });
      }
    }
  }
}

var Validate_vendor = {
  product: function(product) {
    $.ajax({
      url: base_url+"vendor/CommonVfunction/product_validate/"+product,
      success: (response) => {
        var result = JSON.parse(response);
        console.log(result);
        if(result.is_vendor == 2) {
          //alert('Product Already Exist if you want to add please update quantity in Inventory');
          $('#product_error').show();
          var res = confirm('Product has been already added by different vendor Do you want to your own..??')
          if (res) {
            $('#validate_btn').hide();
            $('#valid_pro').hide();
            $('#add_product').append(
                '<div  id="qty_add">'+
                //'<p class="text-info">Product Already Added by different Vender, <b>Cost Price : '+result.cost_price+'</b> AND <b>MRP : '+result.mrp+'</b><p>'+
                  '<div class="form-group label-floating">'+
                    '<label for="product_num" class="control-label">Quantity</label>'+
                    '<input type="number" class="form-control" name="quantity" id="product_num">'+
                  '</div>'+
                '</div>'+
                  '<div class="col-md-6">'+
                    '<div class="form-group label-floating">'+
                      '<label for="cost_price" class="control-label">Cost Price</label>'+
                      '<input type="number" class="form-control" name="cost_price" id="cost_price">'+
                    '</div>'+
                  '</div>'+
                  '<div class="col-md-6">'+
                    '<div class="form-group label-floating">'+
                      '<label for="mrp" class="control-label">MRP</label>'+
                      '<input type="number" class="form-control" name="mrp" id="mrp">'+
                    '</div>'+
                  '</div>'+
                '<input type="hidden" value="'+result.product_id+'" name="product_id"></div>'
              );
            $('#submit').show();
          }
          //$('#add_product').attr('disabled','true');
          $form_validate = 1;           // Global variable to check validation at submission Time
          return false;
          } else if(result.is_vendor == 1) {
            alert('You Already Added this Product. Navigate to Product listing page to Edit or Add Product ')
          } else {
          $('#product_error , #submit').hide();
          $('#validate_btn').show();
          $('#qty_add').remove();
          $('#valid_pro').show();
          $('#add_nw_product').attr('href',base_url+'vendor/Vendorfunction/product/add/'+product);
          //$('#add_product').removeAttr('disabled');
          $form_validate = 0;           // Global variable to check validation at submission Time
          return true;
        }
        
      }
    });
  }
}

var Product = {
  status : (status,product) => {
    var res = confirm('Really want to Change Status...?');
    if(res) {
      if (status != '' && product != '') {
        $.ajax({
          url: base_url+"backend/commonfunction/product_status/"+status+"/"+product,
          success: (response) => {
            var result = JSON.parse(response);
            alert(result.description);
          }
        });
      }
    }
  }
}