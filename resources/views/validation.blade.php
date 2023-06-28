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

function dateValid(start_date,end_date)
{
    const startDateInput = document.getElementById(start_date);
    const endDateInput = document.getElementById(end_date);
    const startDate = new Date(startDateInput.value);
    const endDate = new Date(endDateInput.value);
    if(startDateInput.value!='' && endDateInput.value!='')
    {
        if (isNaN(startDate.getTime()) || isNaN(endDate.getTime())) {
            alert('Invalid date format');
            startDateInput.value = '';
            endDateInput.value ='';
            event.preventDefault();
        } else if (startDate > endDate) {
            alert('Start date must be before or equal to end date');
            endDateInput.value ='';
            event.preventDefault();
        }
    }
}
$('.alpha').keyup(function(){
    var textPattern = /^[a-zA-Z\s]+$/;
    if (!textPattern.test(this.value)) {
      this.value = '';
    }
});
</script>

