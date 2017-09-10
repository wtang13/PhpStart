
$(document).ready(function() {
 /* Handler 1:
 * When click submit, 1.go to doUpdate.php to store data in DB to 
 * 2. show printPdf button
 */ 
    $('.s').on('click',function(event) {
        event.preventDefault();
        var values = $(this).closest('.table').serialize();
        alert(values);
        $(this).closest('.UserInfo').find('.print').css({'display':'inline'});
        
        $.ajax({
           type:"POST",
           url:"http://localhost:8081/UserInfoUpdate/app/doUpdate.php",
           data: values,
           success: function(data) {
               alert(data);
           }
        });
        
        event.preventDefault();
    });

});

