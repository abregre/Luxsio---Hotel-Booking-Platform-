
(function($){
  //Favorite room ajax
  $(document).on('submit', 'form.favoriteForm', function(e){
    e.preventDefault();
    //Get form data
    const formData = $(this).serialize();
    //Request
    $.ajax('http://localhost/public/ajax/room_fav.php',
            {
            type: "POST",       
            dataType: "json",
            data: formData            
            })
            .done(function(result){
              if(result.status){
                $('input[name=is_favorite').val(result.is_favorite ? 1: 0);
                $('#fav').toggleClass('selected', result.is_favorite);
              }else{
                $('#fav').toggleClass('selected', !result.is_favorite);
              }
            })
  });
  //Room review ajax
  $(document).on('submit', 'form.review-add-body', function(e){
    e.preventDefault();
    //Get form data
    const form = $(this).serialize();
    //Request
    $.ajax('http://localhost/public/ajax/room_review.php',
            {
            type: "POST",       
            dataType: "html",
            data: form            
            })
            .done(function(result){     
              $("#reviewSubmit").hide();
              $("#loadingGif").show();
              setTimeout(()=>{
                $('#reviews-container').html(result);                
                $('#loadingGif').removeAttr("style").hide();
                $("#reviewSubmit").show();
                //Reset form
                $('form.review-add-body').trigger('reset');
              },3000);           
            })
  });
 
})(jQuery);