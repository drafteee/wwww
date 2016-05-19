/**
 * Created by Сергей on 24.04.2016.
 */
var name="";
$(document).ready(function(){
    $.ajax({
        method: "POST",
        url: "data.php",
        data: {page: "home"},
        success: function (data) {
            name = data;
        }
    });
    UpdateUsers();
    setInterval('UpdateUsers()',15000);
    UpdateMsg();
    setInterval('UpdateMsg()',500);
});

function UpdateMsg(){
    $.ajax({
        method: "POST",
        url: "data.php",
        async:false,
        data: {page:"update_msg"},
        success: function (data) {
            console.log(data);
            $('#id_chat').html(data);
        }
    });
}

function UpdateUsers(){
    $.ajax({
        method: "POST",
        url: "data.php",
        async:false,
        data: {page:"update_users"},
        success: function (data) {
            console.log(data);
            $('#id_list_users').html(data);
        }
    });
}

$('#id_Send').on('click',function() {

    var text = $('#id_text_box').val();
    $('#id_text_box').val('');
    if (text =="") {
        return false;
    }
    $.ajax({
        method: "POST",
        url: "data.php",
        data: {page: "chat",author:name,text:text},
        success: function (data) {
        }
    });

});
