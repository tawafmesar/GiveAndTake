$(function() {
'use strict';

// Trigger the selectBoxIt

//$("select").selectBoxIt({
  //theme :"bootstrap"

//});

// dashboard

  $('.toggle-info').click(function (){

      $(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);



  });

// Hide placeholder on form focus

    $('[placeholder]').focus( function () {

 // this placeholder
                        //what hapind win focus
    $(this).attr('data-text' , $(this).attr('placeholder'));

    $(this).attr('placeholder' , '');

      }).blur( function(){

          $(this).attr('placeholder', $(this).attr('data-text'));

      });

 // add astreisk on required field

  $('input').each(function () {

    if ($(this).attr('required') === 'required') {

        $(this).after('<span class="asterisk">*</span>');

    }

  });

  // CONVERT password field to text field on hover

    var passField = $('.password');

      $('.show-pass').hover(function(){

        passField.attr('type' , 'text');

      }, function() {

        passField.attr('type' , 'password');


      });

    // confirmation message on button

    $('.confirm').click(function (){

      return confirm('Are you sure');

    });


    // category view operation

        $('.cat h3').click(function (){

          $(this).next('.full-view').fadeToggle();

        });


        $('.option span').click(function (){

          $(this).addClass('active').siblings('span').removeClass('active');


          if($(this).data('view') == 'full'){

            $('.cat .full-view').fadeIn(200);

          }else {

            $('.cat .full-view').fadeOut(200);

}

        });

        //show delete button on child cats

        $('.child-link').hover(function (){

          $(this).find('.show-delete').fadeIn();

        }, function () {

          $(this).find('.show-delete').fadeOut();



        });


});
