// My Script
// ===============================================

  $(function () {
    'use strict';

/************** Remove Flash Messages ***************/
    $('.alert').each(function(){
      $(this).show().delay(2000).hide(400).children().remove();
    })
/************** Delete Confirmation *****************/
    $('.delete-item').click(function(e) {
      e.preventDefault();
      $(this).siblings('.popup-container').fadeIn(700);
    });
    $('.cancel-delete-item').click(function(e) {
      e.preventDefault();
      $('.popup-container').fadeOut(700);
    });
    $('.message-container').click(function(e) {
      $('.popup-container').fadeOut(700);
    });
    $('.confirmation-message').click(function(e) {
      e.stopPropagation();
    });
    $(window).keyup(function(e) {
      var code = e.which;
      if(code == 27) {
        $('.popup-container').fadeOut(700);
      }
    });
/************** Image Preview *************** */
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
          $('#img-preview').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]);
      }
    }
    
    $(".image_file").change(function() {
      readURL(this);
    });

/************** Remove Product Image ****************** */
    $('body').on('change','#remove_image', function () {
      $(this).addClass('remove_image-checked');
      $('.choose-image').slideUp(700);
    });
    $('body').on('change','.remove_image-checked', function () {
      $(this).removeClass('remove_image-checked');
      $('.choose-image').slideDown(700);
    });
/***************** Orders *********************************************** */
    var orderIndex = 0;
    var totalPrice = 0;
//-------------------- Create Orders -----------------------//
    $('body').on('click', '.add_order', function(e) {   //add order
      e.preventDefault();  
      $(this).removeClass('add_order').attr('disabled','disabled');
      var order_row = orderRowView($(this).data('id'), orderIndex, $(this).data('name'), $(this).data('price'));

      //--- This condition to prevent append another same order ----/
      for(var i=0; i < $('.order-list').children().length + 1; i = i+1)
      {
        if($('#order_'+$(this).data('id')).attr('id') == ('order_'+($(this).data('id')))){
          console.log("You Can't Do This Job ...!!!");
          return false;
        }
      }
      //
      orderIndex = orderIndex + 1;
      $('.order-list').append(order_row);

      finalTotal();
        
    });//End of Create_order
//************** Order View Function *************************/*/
    function orderRowView(data_id,orderIndex,data_name,data_price) {
      return `<tr class="row order-row" id="order_${data_id}">
                <input type="hidden" value="${data_id}" name="products_id[]"/>
                <td class="col-md-1 number order-number-${orderIndex+1}">
                  ${orderIndex+1}
                </td>
                <td class="col-md-3">
                  ${data_name}
                </td>
                <td class="col-md-2">
                  <input type="number" min="1" value="1" step="1" style="width: 100%" class="quantity" name="quantity[]" />
                </td>
                <td class="col-md-3">${data_price}</td>
                <td class="total-of-row">${data_price}</td>
                <td class="col-md-3">
                  <i class="delete-order fa fa-trash btn btn-danger" data-id="${data_id}" data-price="${data_price}"></i>
                </td>
              </tr>`;
    }
//-------------------- Delete Orders -----------------------//
    $('body').on('click', '.delete-order', function() {
      $('a[data-id="'+ $(this).data('id')+'"]').removeAttr('disabled').addClass('add_order');
      $(this).parents('.order-row').remove();
      
      totalPrice -= parseFloat($(this).data('price'));
      $('.total').text(totalPrice.toFixed(2));

      for(var i =1; i <= orderIndex; i++) {
        $('.order-number-'+i).removeClass('order-number-'+i);
      }
      finalTotal();
      orderIndex = orderIndex - 1;
      var j=1;
      $('.number').each(function() {
        $(this).addClass('order-number-'+j).text(j);
        j++;
      });
    });//End of delete order
//--------------- Adjust Order Index in Edit Orders Page -------------//
    $('body').one('click','.adjust-index', function() {
      orderIndex = parseInt($(this).data('order-index')) - 1;
      removeClass();
    });
    function removeClass() {
      $('.adjust-index').each(function() {
        $(this).removeClass('adjust-index');
      });
    }
//--------------- Change Order By Changing quantities  ---------------//
    $('body').on('change', '.quantity', function() {
      // if($(this).val()%1 === 0) { // To prevent user to put a double value in quantity
        finalTotal();
      // } else {
      //   return false;
      // }
    });
    function finalTotal() {
      totalPrice = 0;
      $('.quantity').each(function() {
        var rowPrice = $(this).parent('td').siblings().find('i').data('price') * $(this).val();
        totalPrice += rowPrice;
        $(this).parent('td').siblings('.total-of-row').text(rowPrice);
      });
      if(totalPrice > 0) {
        $('.confirm-order').removeAttr('disabled');
      } else {
        $('.confirm-order').attr('disabled','disabled');
      }
      $('.total').text(totalPrice.toFixed(2));
    }

/**************** Show Order Products using Ajax ********************/
    $('.show-order-products').on('click', function(e) {
      e.preventDefault();
      var url = $(this).data('url');
      var productsDiv =  $('.show-products');
      $('.show-orders').removeClass('col-md-12').addClass('col-md-8'); 
      $.ajax({
        url: url,
        method: 'get',
        success: function(data) {
         productsDiv.children().remove();
         productsDiv.hide();
         productsDiv.append(data);
         productsDiv.fadeIn();
        }
      });
    });

});