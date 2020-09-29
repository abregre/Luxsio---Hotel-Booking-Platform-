(function($){
  
  $(document).on('submit', 'form.filters', function(e){
    e.preventDefault();
    
    //Get form data
    const formData = $(this).serialize();
    
    //Request
    $.ajax('http://localhost/public/ajax/search_results.php',
            {
            type: "GET",
            dataType: "html",
            data: formData            
            })
            .done(function(result){
              $('#results').html(result);
              history.pushState({},'',`http://localhost/public/results.php?${formData}`)
            })
  });
})(jQuery);