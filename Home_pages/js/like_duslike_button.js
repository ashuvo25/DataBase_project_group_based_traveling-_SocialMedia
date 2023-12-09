$(document).ready(function(){
    $('.like-btn').on('click' , function(){
          var post_id = $(this).data('id');
          alter(post_id);
    });
});