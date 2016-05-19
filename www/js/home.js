/**
 * Created by Сергей on 25.04.2016.
 */
$(function(){
    var name = "";
    var pass = "";
    $(document).ready(function(){
        $.ajax({
            method: "POST",
            url: "data.php",
            data: {page: "home"},
            success: function (data) {
                console.log(data);
                name = data;
            }
        });
    });

    function set_modal(e) {
        $(e).css('background-color', "rgba(0,0,0,0.5)");
        $(e).css("opacity", 0);
        $(e).css("display", "block");
        $(e).animate({'opacity': 1}, 500, "swing", function () {
            var doc_w = $(document).width();
            var doc_h = $(document).height();
            $(this).css("width", doc_w);
            $(this).css("height", doc_h);
            $(this).css("display", "block");
        });
    }

    $('.modal-footer').on('click','button', function (event) {
        $('.modal').animate({'opacity': 0}, 500, "swing", function() {
            $(this).css("display", "none");
        });
    });

    var flag = false;

    $('.modal-footer').on('click','button',function() {
        if ($(this).html() == "Log In") {
            var login = $('#id_text_login').val();
            var pass = $('#id_text_password').val();
            if ((login != "") && (pass != ""))
                $.ajax({
                    async:false,
                    method: "POST",
                    url: "data.php",
                    data: {page: "login", login: login, pass: pass},
                    success: function (data) {
                        name = data;
                        console.log(name);
                    }
                });

        }else if($(this).html() == "Сохранить"){
            var login = $('#id_text_login').val();
            var mail = $('#id_text_mail').val();
            var pass = $('#id_text_password').val();
            var name = $('#id_text_name').val();
            var city = $('#id_text_city').val();
            var old = $('#id_text_old').val();
            if ((login != "") && (mail != "") && (pass != "") && (name != "") && (city != "") && (old != ""))
                $.ajax({
                    method: "POST",
                    url: "data.php",
                    data: {page: "Save", login: login, mail: mail, pass: pass, name: name, old: old, city: city},
                    success: function (data) {
                        // console.log(data);
                    }
                })
        }else if($(this).html() == "Выход"){
            name = null;
            $.ajax({
                async:false,
                method: "POST",
                url: "data.php",
                data: {page: "Exit"},
                success: function (data) {
                    // console.log(data);
                }
            });
            JSON.stringify()
        }else if($(this).html() == "Забыли пароль?"){
            var login = $('#id_text_login').val();
            $.ajax({
                async:false,
                method: "POST",
                url: "data.php",
                data: {page: "Recovery",login:login},
                success: function (data) {
                    pass = data;
                }
            });
            //console.log(pass);
            //console.log(pass);
        }
    });

    var arr ={};
    var flagInfo = false;

    $('#id_btn_Save').trigger('click',function(){
       console.log("1");
    });

    function set_content(e, qe) {
        if (name!="") {
            $(qe).html("Home");
            $(e + '> p').html('<div style="width: 50%;float: left"><p><b>Логин:</b><br><input id="id_text_login" type="text" size="40"></p></div><div style="width: 50%;float: right"><p><b>@mail:</b><br><input id="id_text_mail" type="text" size="40"></p></div><div style="width: 50%;float: left"><p><b>Ваш пароль:</b><br><input id="id_text_password" type="text" size="40"></p></div><div style="width: 50%;float: right"><p><b>Возраст:</b><br><input id="id_text_old" type="text" size="40"></p></div><div style="width: 50%;float: left"><p><b>Ваше имя:</b><br><input id="id_text_name" type="text" size="40"></p></div><div style="width: 50%;float: right"><p><b>Город:</b><br><input id="id_text_city" type="text" size="40"></p></div>');
            $('.modal-footer').html('<button class="btn btn-default" id="id_btn_Sign_out">Выход</button><button class="btn btn-default" id="id_btn_Save">Сохранить</button>');
            var n = name;
            $.ajax({
                    async:false,
                    method: "POST",
                    url: "data.php",
                    data: {page: "home_info", login: n},
                    success: function (data) {
                        arr = JSON.parse(data);
                    }
                });

            $('#id_text_login').val(arr['nick_name']);
            $('#id_text_mail').val(arr['e-mail']);
            $('#id_text_name').val(arr['name_user']);
            $('#id_text_city').val(arr['city']);
            $('#id_text_old').val(arr['old']);
        } else {
            $(qe).html("Вход");
            $(e + '> p').html('<div style="width: 50%;float: left"><p><b>Логин:</b><br><input id="id_text_login" type="text" size="40"></p></div><div style="width: 50%;float: right"><p><b>Ваш пароль:</b><br><input id="id_text_password" type="text" size="40"></p></div>');
            $('.modal-footer').html('<button class="btn btn-default" id="id_btn_recovery">Забыли пароль?</button><button class="btn btn-default btn_close" id="id_inputt"">Log In</button>')
        };
    };

    $('#id_btn_author').on('click', function (event) {
        $.ajax({
            method: "POST",
            async:false,
            url: "data.php",
            data: {page: "home"},
            success: function (data) {
                name = data;
            }
        });
        set_modal('.modal');

        set_content('.modal-body','.modal-title',this);
    });

});