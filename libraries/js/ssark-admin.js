jQuery(document).ready(function($){
    if( $('#server-details p').first().attr('id') == 'initialServer' ){
        var $genNewID = makeid();
        $('#server-details p').first().attr('id','server-' + $genNewID);
        $('#server-details p').first().children('input.ssark_server_identifyer').val($genNewID);
    }

    $('#selected-server a').on('click', function(e){
        e.preventDefault();

        $('#selected-server a.selected').removeClass('selected').css('background','#cc3f2b');
        $(this).addClass('selected').css('background','#23282d');

        var restHTML = '<li class="clearfix"><div style="width:50%; float:left;"><strong>PLAYER NAME</strong></div><div style="width:50%; float:left;"><strong>STEAMID</strong></div></li>';

        $('#currentplayers').find('.list ul').html(restHTML);
        $('#allplayers').find('.list ul').html(restHTML);
        
        retreivePlayerLists()
    });

    if($('#playerlists').length > 0 ){
        retreivePlayerLists();
    }

    function retreivePlayerLists(){
        var $serverselect = $('#selected-server'),
            $selectedserver = $serverselect.find('a.selected'),
            apikey = $serverselect.attr('data-apikey'),
            serverip = $selectedserver.attr('data-serverip'),
            serverport = $selectedserver.attr('data-serverport');

        var apiQueryData = {
            action: 'gatherPlayerData', 
            apikey: apikey,
            serverip: serverip,
            serverport: serverport
        };

        serverAPICall(apiQueryData, function(result){
            var activeplayer = result.response.activeplayers,
                allplayers = result.response.allplayers;

            $.each(activeplayer, function(id,data){
                if(data){
                    $('#playerlists').find('#currentplayers ul').append('<li class="clearfix"><div style="width:50%; float:left;">' + data.player_name + '</div><div style="width:50%; float:left;">' + data.steamID + '</div></li>');
                }
            });

            $.each(allplayers, function(id,data){
                if(data){
                    $('#playerlists').find('#allplayers ul').append('<li class="clearfix"><div style="width:50%; float:left;">' + data.player_name + '</div><div style="width:50%; float:left;">' + data.steamID + '</div></li>');
                }
            });
        });
    }

    $('#addserver').on('click', function(e){
        e.preventDefault();
        if( $('#server-details p').length <= 4 ){
            var $genNewID = makeid();
            var serverHTML = '<p id="server-' + $genNewID + '"> ID:  #<input class="ssark_server_identifyer" type="text" name="ssark_server_identifyer[]" value="' + $genNewID + '" size="10"> Server Connection Details: <input class="ssark_server_ip" type="text" name="ssark_server_ip[]" value="" size="20"> : <input class="ssark_server_port" type="text" name="ssark_server_port[]" value="" size="10"> Rcon Port: <input class="ssark_server_rcon_port" type="text" name="ssark_server_rcon_port[]" value="" size="10"> Rcon Password: <input class="ssark_server_rcon" type="password" name="ssark_server_rcon[]" value="" size="10"> <a href="#" data-server="' + $genNewID + '" style="display:inline-block; padding: 5px; text-decoration: none; background:#cc3f2b; float: right; border-radius:3px; color:white;" class="wpd_pro_btn deleteserver"><span class="dashicons dashicons-dismiss"></span></a></p>';
            $(serverHTML).appendTo('#server-details');
        }else{

        }
        return false;
    });

    $('#send_chat_command, #send_console_command, #broadcastmessageoftheday, #setmessageoftheday, #broadcastmessage, #settimeofday, #saveworld').on('click', function(e){
        e.preventDefault();
        var consolecommand = '',
            protection = false;

        switch( $(this).attr('id') ){
            case 'broadcastmessageoftheday': 
                consolecommand = 'Broadcast ' + $('#motd').val();
            break;
            case 'setmessageoftheday': 
                consolecommand = 'SetMessageOfTheDay ' + $('#motd').val();
            break;
            case 'broadcastmessage': 
                consolecommand = 'Broadcast ' + $('#messagebroadcast').val();
            break;
            case 'settimeofday': 
                consolecommand = 'SetTimeOfDay ' + $('#timeofday').find(":selected").text() + ':00';
            break;
            case 'send_chat_command': 
                consolecommand = 'ServerChat ' + $('.rconchat_command').val();
            break;
            case 'send_console_command': 
                consolecommand = $('.console_command').val();
            break;
            case 'saveworld': 
                consolecommand = 'SaveWorld';
                protection = true;
            break;
            case 'doexit': 
                consolecommand = 'DoExit';
                protection = true;
            break;
            case 'destroywilddinos': 
                consolecommand = 'DestroyWildDinos';
                protection = true;
            break;
            case 'destroystructures': 
                consolecommand = 'DestroyStructures';
                protection = true;
            break;
        }

        if( protection === true ){
            var r = confirm("WARNING: You are now about to run a command that may cause none reversable events or your server may crash. If you are happy to proceed click OK, if you are not sure click CANCEL");
            if (r == true) {
                runCommand( consolecommand )
            }
        }else{
            runCommand( consolecommand );
        }
    });

    function runCommand( consolecommand ){
        var $serverselect = $('#selected-server'),
            $selectedserver = $serverselect.find('a.selected'),
            apikey = $serverselect.attr('data-apikey'),
            serverip = $selectedserver.attr('data-serverip'),
            serverport = $selectedserver.attr('data-serverport');

        var apiQueryData = {
            action: 'sendrconcommand', 
            apikey: apikey,
            serverip: serverip,
            serverport: serverport,
            rconcommand: consolecommand
        };

        serverAPICall(apiQueryData, function(result){
            console.log( result );
            $('.consolelog ul').prepend('<li>COMMAND RUN: ' + consolecommand  + '</li>');
            $('.consolelog ul').prepend('<li>SERVER RESPONSE: ' + result.response  + '</li>');
        });
    }

    $('body').on('click', '.deleteserver', function(e){
        e.preventDefault();
        $(this).parent().remove();
        return false;
    });

    $('body').on('click','.verifyserver', function(e){
        e.preventDefault();
        var rcon_api = $('#ssark_token').val(),
            $this = $(this),
            rcon_ip = $(this).siblings('.ssark_server_ip').val(),
            server_port = $(this).siblings('.ssark_server_port').val(),
            rcon_port = $(this).siblings('.ssark_server_rcon_port').val(),
            rcon_password = $(this).siblings('.ssark_server_rcon').val();
            verification = $('.server_verification').val();

        if( rcon_port != '' && rcon_password != '' ){
            var apiQueryData = {
                action: 'verifyrcon', 
                apikey: rcon_api,
                serverip: rcon_ip,
                serverport: server_port,
                rconport: rcon_port,
                rcon: rcon_password
            };

            serverAPICall(apiQueryData, function(result){
                if( result ){
                    if( result.status === true ){
                        var data ={
                            'action': 'verification_callback',
                            'server_verification': verification
                        };
                        $.post(ajax_object.ajax_url, data, function(response) {
                            $this.css('background','green').find('span').removeClass('dashicons-flag').addClass('dashicons-yes');
                        });

                    }else{
                        $this.css('background','red').find('span').removeClass('dashicons-flag').addClass('dashicons-no');
                    }
                }else{
                    $this.css('background','red').find('span').removeClass('dashicons-flag').addClass('dashicons-no');
                }
            });
        }else{
            if( rcon_port == '') $(this).siblings('.ssark_server_rcon_port').css('border','1px solid red');
            if( rcon_password == '') $(this).siblings('.ssark_server_rcon').css('border','1px solid red');
            alert('WARNING: To verify your server can be accessed by the API you need to suppy the RCON PORT & RCON PASSWORD. Please enter both these to continue!');
        }
    });
});

function serverAPICall(apidata, callback) {
    jQuery.ajax({
        url: 'http://api.knowyourenemy.co.uk/',
        crossDomain: true,
        dataType:'jsonp',
        async: false,
        data: apidata
    }).done(function( data ) {
        callback( data );
    });
}

function makeid(){
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    for( var i=0; i < 8; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}