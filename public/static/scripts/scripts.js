$(document).ready(function(){


    //$("#smoothly_2").change(function(){
    //    $(".setperiod").removeClass("invisible");
    //});

    var now = new Date();


    $('#date').datetimepicker({
        format:'Y-m-d H:i:s',
        onShow:function( ct ){
            this.setOptions({
                minDate: now
            })
        },
        lang : 'ru'
    });







});