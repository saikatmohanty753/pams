<script type="text/javascript">
$('.numbers').keypress(function (e) {
   if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) return false;
});
$('.numbers').blur(function (e) {
   if (e.target.value.length != 10) e.target.value = ''; return false;
});
$('input[type="text"]').blur(function(){
   var reg =/<(.|\n)*?>/g; 
   if (reg.test($('#'+this.id).val()) == true) {
      var ErrorText ='Invalid text';
      toastr.options =
      {
         "closeButton" : true,
         "progressBar" : false
      }
      toastr.warning(ErrorText);
      $('#'+this.id).val('');
   }
});
</script>