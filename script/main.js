$(document).ready(function () {
    // For Handlebars compile
    var source = $('#event-template').html();
    var eventTemplate = Handlebars.compile(source);

    var panel = {
        self: '#panel',
        dateBlock: null,
        eventId: null,
        open: function(isNew, e, id){
            panel.clean();

            panel.eventId = id;

            $(panel.self).addClass('open').css({
                top: e.pageY+'px',
                left: e.pageX+'px'
            }).find('.title [contenteditable]').focus();

            if(isNew){
                $(panel.self).addClass('new').removeClass('update');
                panel.dateBlock = $(e.currentTarget);
            }else{
                $(panel.self).addClass('update').removeClass('new');
                panel.dateBlock = $(e.currentTarget).closest('.date-block');
            }
            
            panel.updateDate(e);

            console.log(panel.eventId);
        },
        close: function(){
            $(panel.self).removeClass('open');
            panel.clean();
        },
        updateDate: function(e){
            var year = $('#month-year').data('year');
            var month = $('#month-year').data('month');
            var date = panel.dateBlock.data('date');

            $(panel.self).find('.month').text(month);
            $(panel.self).find('.date').text(date);
            $(panel.self).find('[name="year"]').val(year);
            $(panel.self).find('[name="month"]').val(month);
            $(panel.self).find('[name="date"]').val(date);
        },
        createEvent: function(e){
            var data = $(panel.self).find('form').serializeArray();
            if(panel.validate(data)){
                data = $(panel.self).find('form').serialize();    
                console.log(data)            ;
                $.post('./service/create.php', data, function(json, textStatus, xhr){
                    var eventDOM = eventTemplate($.parseJSON(json));
                    console.log(eventDOM);
                    panel.dateBlock.find('.events').append(eventDOM);
                    panel.close();
                });
            }
        },
        updateEvent:function(e){
            //TODO - update event by id using AJAX
            console.log(panel.eventId);
        },
        deleteEvent: function(e){
            //TODO - delete event by id using AJAX
            console.log(panel.eventId);
        },
        clean: function(){
            $(panel.self).find('form').trigger("reset");
            $(panel.self).find('input').removeClass("red-border");
            $(panel.self).find('textarea').removeClass("red-border");
        },
        validate: function(data){
            let error = 0;
            data.map(datum => {
                if(datum.value.length === 0){
                    error++;
                    let dom = '[name="'+datum.name+'"]';
                    $(dom).addClass("red-border");
                    $(dom).attr("placeholder","This field is required!")
                }
            });
            let start_h = parseInt(data[3].value.split(":")[0]);
            let start_m = parseInt(data[3].value.split(":")[1]);
            let end_h = parseInt(data[4].value.split(":")[0]);
            let end_m = parseInt(data[4].value.split(":")[1]);
            let start = start_h + (start_m/60);
            let end = end_h + (end_m/60);
            if(end<start){
                error++;
                $('[name="start"]').addClass("red-border");
                $('[name="end"]').addClass("red-border");
            }
            return error === 0;
        }
    }

    $('.date-block')
        .dblclick(function (e) {
            panel.open(true,e, -1);        
        })
        .on('click','.event',function(e){
            e.stopPropagation();
            let id = $(this).data('id');
            panel.open(false,e, id);
        })
        .on('click',function(e){
            panel.close();
        });

    $(panel.self)
        .on('click', 'button', function (e) {
            if ($(this).is('.create')){
                panel.createEvent(e);
            }
            if($(this).is('.update')){
                panel.updateEvent(e);
            }
            if($(this).is('.cancel')){
                panel.close();
            }
            if($(this).is('.delete')){
                panel.deleteEvent(e);
            }
        })
        .on('click', '.close', function (e) {
            $('button.cancel').click();
    });  
});