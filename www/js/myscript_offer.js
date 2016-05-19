  $(function() {


        var $activeCheck = false;

        function set_modal(e){
          $(e).css('background-color',"rgba(0,0,0,0.5)");
          $(e).css("opacity", 0);
          $(e).css("display", "block");
          $(e).animate({'opacity': 1}, 500, "swing", function() {
            var doc_w = $(document).width();
            var doc_h = $(document).height();
            $(this).css("width",doc_w);
            $(this).css("height",doc_h);
            $(this).css("display", "block");
        });
        }

      $('.modal-footer').on('click','button',function(event){
          if($(this).html() == "Sign in") {
              var login = $('#id_text_login').val();
              var mail = $('#id_text_mail').val();
              var pass = $('#id_text_password').val();
              var name = $('#id_text_name').val();
              var city = $('#id_text_city').val();
              var old = $('#id_text_old').val();
              if ((login != "") && (mail != "") && (pass != "") && (name != "") && (city != "") && (old != ""))
                  $.ajax({
                      method: "POST",
                      async:false,
                      url: "data.php",
                      data: {page: "registr", login: login, mail: mail, pass: pass, name: name, old: old, city: city},
                      success: function (data) {
                          console.log(data);
                      }
                  })
          }
      });
      function set_content(e,qe,s){
          if($(s).hasClass("btn btn_registration")){
              $(qe).html("Registration");
              $(e + '> p').html('<div style="width: 50%;float: left"><p><b>Логин:</b><br><input id="id_text_login" type="text" size="40"></p></div><div style="width: 50%;float: right"><p><b>@mail:</b><br><input id="id_text_mail" type="text" size="40"></p></div><div style="width: 50%;float: left"><p><b>Ваш пароль:</b><br><input id="id_text_password" type="text" size="40"></p></div><div style="width: 50%;float: right"><p><b>Возраст:</b><br><input id="id_text_old" type="text" size="40"></p></div><div style="width: 50%;float: left"><p><b>Ваше имя:</b><br><input id="id_text_name" type="text" size="40"></p></div><div style="width: 50%;float: right"><p><b>Город:</b><br><input id="id_text_city" type="text" size="40"></p></div>');
              $('.modal-footer').html('<button class="btn btn-default btn_close" id="id_Sign_in" type="button">Sign in</button>');
          }else
          {
              var se  = $(s).children('a').html();
              $(qe).html("Новость");
              $(e + '> p').html('<span>'+se+'</span>');
              $('#id_Sign_in').html("Close");
          }
      }

//сделать модальное окно,все дивы для всех случаев
      $('#btn_registr').on('click','button', function (event) {
          console.log("h");
          set_modal('.modal');

          set_content('.modal-body','.modal-title',this);
      });

        $('.btn.btn_News').on('click', function(event){

          if(!$activeCheck){
            $('.side_bar_type_news').animate({'width': 250}, 250, "swing");
        
            $('.content_body_list_news').animate({'width': 750}, 250, "swing");
            $activeCheck = true;
            console.log("gdfg");
          }
          else
          {
            $('.side_bar_type_news').animate({'width': 0}, 250, "swing");
        
            $('.content_body_list_news').animate({'width': 1000}, 250, "swing");
            $activeCheck = false;
          }
          });
        $('.btn_close,.btn_close_pict').on('click', function (event) {
            $('.modal').animate({'opacity': 0}, 500, "swing", function() {
                $(this).css("display", "none");
            });
         });


        $('#id_Checkbox_1,#id_Checkbox_2').on('click',function(event){
            
            if(this.id=="id_Checkbox_1"){
              $('.content_middle').animate({'height':100},100,"swing",function(){
                $(this).css("display","block");
              });
              
            }else{
              $('.content_middle').animate({'height':0},100,"swing",function(){
                $(this).css("display","none");
              });
            }
        });

        var array_types = {};

        function updateTotal(e) {
          if(this.checked){
            array_types[this.value] =(this.value);
          }
          else{
            delete array_types[this.value];
          }
        }
        function attachCheckboxHandlers() {

          var el = document.getElementById('id_content_middle');

          var tops = el.getElementsByTagName('input');
    
          for (var i=0, len=tops.length; i<len; i++) {
              if ( tops[i].type === 'checkbox' ) {
                  tops[i].onclick = updateTotal;
              }
          }
        }
  
        $('#id_Check').on('change', function() {
          attachCheckboxHandlers();
        });

        $('#id_btnOffer').on('click', function(){
          var info_text_area  = $('.text_box').val();
          var date = new Date();
          var author_id = Math.floor((Math.random() * 1000) + 1);
          var category_id = JSON.stringify(array_types);
          $.ajax({
              method: "POST",
              url: "data.php",
              data: {page: "offer", text : info_text_area, date: date, author: author_id, category : category_id },
              success : function(data){
                console.log(data);
              }
            })

        })
  });

