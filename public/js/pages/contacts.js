$(document).ready(function(){

    //Guests

    var Guests = (function() {

        this.updateCounters = function (callback)
        {
            $.ajax({
                'type': 'GET',
                'url': '/ajax/getGuestNumbers',
                'success': function (data) {
                    callback(data);
                }
            })
        };

        this.set = function(sender, callback )
        {
            var data = {
                gender: $(sender).attr('gender'),
                status: $(sender).attr('status'),
                new: $(sender).hasClass('new'),
                guestid: typeof $(sender).attr('guestid') !== typeof undefined && $(sender).attr('guestid') !== false ? $(sender).attr('guestid') : 0,
                text: $(sender).val()
            };

            /* Adjust the csrf token */

            data._token = window.laravel.csrfToken;

            /* Posting it to the server */

            $.ajax({
                'type': 'POST',
                'url': '/ajax/setContact',
                'data': data,
                'success': function(data){
                    console.log(data);

                    var remove = null,
                        guestid = null;

                    if(typeof data.removed !== 'undefined')
                        remove = true;

                    if(typeof data.guestid !== 'undefined')
                        guestid = data.guestid;

                    if(callback != null)
                            callback(remove, guestid);
                }
            });
        };

        return this;
    })();


   /* Event handling for guests */

    $(document).on('focus', '.guests-input', function () {
        if($(this).attr('status') != 'married')
        {
            window.outsender = this;
        }
    });

    $(document).on('focusout', '.guests-input', function(){

        if(!isAuth){
            $("#register_modal").modal();
            return false;
        }
        
        Guests.set(this,
            function (remove, guestid)
            {
                if($(this.sender).hasClass('new'))
                    $(this.sender).removeClass('new');

                if(remove === true)
                {
                    if($(this.sender).parent().parent().find('.input-holder').length > 1)
                        $(this.sender).parent().fadeOut(400, function(){
                            $(this).remove();
                        });
                    else
                        $(this.sender).addClass('new');
                }

                if(guestid !== null)
                {
                    $(this.sender).attr('guestid', guestid);
                }

                Guests.updateCounters(function(data){
                    $("#total-guest-count").html(data.total);
                    $("#male-guest-count").html(data.total_male);
                    $("#female-guest-count").html(data.total_female);
                });

            }.bind({'sender': this}));



        delete window.outsender;
    });

    $(document).on('click', '.add', function(){
        var cloned = $(this).parent().clone();
        cloned.find('input').attr('value', '').val('').addClass('new');
        $(this).parent().parent().append(cloned);
        return false;
    });

    $(window).on('keyup', function(e){
        if(e.keyCode == 13)
        {
            if(typeof window.outsender !== 'undefined')
            {
                if($(window.outsender).val() == '') return false;
                var cloned = $(window.outsender).parent().clone();
                cloned.find('input').attr('value', '').val('').addClass('new');
                $(window.outsender).parent().parent().append(cloned);
                $(window.outsender).parent().parent().find('.input-holder:last-of-type').find('input').focus();
            }
        }
    });


    //Contacts

    var Contacts = (function(){

        this.getContacts = function(guestid, callback)
        {
            var data = {
                    'guestid' : guestid
                };

            $.ajax({
                'type': 'GET',
                'url': '/ajax/getContacts',
                'data': data,
                'success': function(data){
                    console.log(data);

                    if(typeof callback !== 'undefined')
                        callback(data);
                }
            });
        };

        this.updateContacts = function(guestid, data, callback)
        {
            //append some stuff
            data['guestid'] = guestid;
            data['_token'] = window.laravel.csrfToken;

            //Make the query
            $.ajax({
                'type': 'POST',
                'url': '/ajax/updateContacts',
                'data': data,
                'success':
                    function(data){
                        if(typeof callback !== 'undefined')
                            callback(data);
                    }
            });
        };

        return this;
    })();

    //Event handling for conacts

    $(document).on('click', '.contactsModalOpener', function () {
        var guestid = $(this).parent().find('input').attr('guestid'),
            guest_name = $(this).parent().find('input').val();

        if (typeof guestid === 'undefined') return false;

        $('#contacts-popup').modal({
            'guestid': guestid,
            'guest_name': guest_name
        });

        return false;
    });


    $('#contacts-popup').on($.modal.BEFORE_OPEN, function(event, modal) {
        Contacts.getContacts(modal.options.guestid, function(data){
            $('.form-row.phone > input').val(data.contacts.contacts_cell !== null ? data.contacts.contacts_cell : '');
            $('.form-row.email > input').val(data.contacts.contacts_email !== null ? data.contacts.contacts_email : '');
            $('.form-row.insta > input').val(data.contacts.contacts_instagram !== null ? data.contacts.contacts_instagram : '');
            $('.form-row.facebook > input').val(data.contacts.contacts_facebook !== null ? data.contacts.contacts_facebook: '');
            $('.form-row.vkontakte > input').val(data.contacts.contacts_vk !== null ? data.contacts.contacts_vk: '');
            $('.form-row.od > input').val(data.contacts.contacts_ok !== null ? data.contacts.contacts_ok: '');
            $('.form-row.viber > input').val(data.contacts.contacts_viber !== null ? data.contacts.contacts_viber: '');
            $('.form-row.telegram > input').val(data.contacts.contacts_telegram !== null ? data.contacts.contacts_telegram: '');

            $('#contacts-popup .name').html(modal.options.guest_name);
        });
    });

    $('#contacts-popup').on($.modal.BEFORE_CLOSE, function(event, modal) {
        var data = {
            'contacts': {
                'contacts_cell': $('.form-row.phone > input').val(),
                'contacts_email': $('.form-row.email > input').val(),
                'contacts_instagram': $('.form-row.insta > input').val(),
                'contacts_facebook': $('.form-row.facebook > input').val(),
                'contacts_vk': $('.form-row.vkontakte > input').val(),
                'contacts_ok': $('.form-row.od > input').val(),
                'contacts_viber': $('.form-row.viber > input').val(),
                'contacts_telegram': $('.form-row.telegram > input').val()
            }
        };

       Contacts.updateContacts(modal.options.guestid, data,
           function(data){
                if(typeof data.success === 'undefined')
                    alert(data.error);
           });
    });
});