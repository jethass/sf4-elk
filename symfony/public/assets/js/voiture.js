$("document").ready(function(){
    $('.js-datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });

    $(".marques").change(function(){
        $.ajax({
            type:'get',
            url:Routing.generate('modeles_for_marque', { id_marque: $(this).val()}),
            beforeSend: function(){
                $(".modeles option").remove();
            },
            success:function(data){
                $.each(data.modeles,function(index,value){
                    $(".modeles").append($('<option>',{value:index,text:value}));
                });
            }
        });

    });

});