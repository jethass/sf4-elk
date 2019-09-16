$("document").ready(function(){

    $('.js-datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });

    /*$(".tags").select2({
        tags: true,
        tokenSeparators: [',', ' ']
    });*/

    /*var $input = $('input[data-toggle="tagsinput"]');
    if ($input.length) {
        var source = new Bloodhound({
            local: $input.data('tags'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            datumTokenizer: Bloodhound.tokenizers.whitespace
        });
        source.initialize();

        $input.tagsinput({
            tagClass: function() {
               return 'label label-primary'

            },
            trimValue: true,
            focusClass: 'focus',
            typeaheadjs: {
                name: 'tags',
                source: source.ttAdapter()
            }
        });
    }*/
    var $input = $('input[data-role="tagsinput"]');
    $input.tagsinput({
        focusClass: 'focus',
        tagClass: function() {
            return 'label label-primary'

        },
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