$(document).ready(function(){    
    $.timeago.settings.allowFuture = true;
    $("abbr.timeago").timeago();
    simpleTalk_.loadMsg("first");
    setInterval('simpleTalk_.loadMsg("")',1000);
    simpleTalk_.sendMsg();
    simpleTalk_.showEmoticons();
    $("#usermsg").keyup(function(event){
        if(event.keyCode == 13){
            $("#submitmsg").click();
        }
    });
    $("#signup").click(function(){
        window.location.href = "register.php";
    });

    $("#signin").click(function(){

        $.ajax({
                url : "index.php",
                type : "POST",
                dataType : "html",
                data : {
                        action : 'userLogin',
                        email : $("[name=email]").val(),
                        pword : $("[name=pword]").val(),
                        signin : $("#signin").val()
                       },
                success: function(data){
                    alert(data)
                   window.location.href = "simpleTalk.php";
                }
        });
    });
    
    $("#a_emoticons").click(function(){
        simpleTalk_.showEmoticons();
    });			

    $(".pane_emoticons").click(function(){
        $(".pane_emoticons").attr('class', 'pane_emoticons active');
        $(".pane_font").attr('class', 'pane_font');
        $("#pane1").attr('class', 'tab-pane');
        $("#pane2").attr('class', 'tab-pane active');
    });	

    $(".pane_font").click(function(){
        $(".pane_emoticons").attr('class', 'pane_emoticons');
        $(".pane_font").attr('class', 'pane_font active');
        $("#pane1").attr('class', 'tab-pane active');
        $("#pane2").attr('class', 'tab-pane');
    });		

    //Font family 
    $("#font-family").live("click", function(){$(".font-family").toggle();$(".font-size").hide();});
    $("#arial").live("click", function(){$("#usermsg").css("font-family", "Arial");$(".font-family").toggle();});
    $("#calibri").live("click", function(){$("#usermsg").css("font-family", "Calibri");$(".font-family").toggle();});
    $("#courier").live("click", function(){$("#usermsg").css("font-family", "Courier");$(".font-family").toggle();});
    $("#timesNewRoman").live("click", function(){$("#usermsg").css("font-family", "Times New Roman");$(".font-family").toggle();});
    $("#verdana").live("click", function(){$("#usermsg").css("font-family", "Verdana");$(".font-family").toggle();});

    //Font size
    $("#font-size").live("click", function(){$(".font-size").toggle();$(".font-family").hide();});
    $("#sz10").live("click", function(){$("#usermsg").css("font-size", "10px");$(".font-size").toggle();$("#sz-picked").html("10");});
    $("#sz12").live("click", function(){$("#usermsg").css("font-size", "12px");$(".font-size").toggle();$("#sz-picked").html("12");});
    $("#sz16").live("click", function(){$("#usermsg").css("font-size", "16px");$(".font-size").toggle();$("#sz-picked").html("16");});
    $("#sz18").live("click", function(){$("#usermsg").css("font-size", "18px");$(".font-size").toggle();$("#sz-picked").html("18");});
    $("#sz24").live("click", function(){$("#usermsg").css("font-size", "24px");$(".font-size").toggle();$("#sz-picked").html("24");});

    //Font style
    $("#stBold").live("click", function(){
            if($("#usermsg").css("font-weight") == "400"){
                    $("#usermsg").css("font-weight", "700");
            }else{
                    $("#usermsg").css("font-weight", "400");
            }
    });
    $("#stItalic").live("click", function(){
            if($("#usermsg").css("font-style") == "normal"){
                    $("#usermsg").css("font-style", "italic");
            }else{
                    $("#usermsg").css("font-style", "normal");
            }
    });
    $("#stUnderline").live("click", function(){
            if($("#usermsg").css("text-decoration") == "none"){
                    $("#usermsg").css("text-decoration", "underline");
            }else{
                    $("#usermsg").css("text-decoration", "none");
            }
    });

   $("#colorpicker-drop").live("click", function(){
          if($("#colorpicker").css("display") == "none"){
              $("#colorpicker").css("display","block");
          }
          else{
              $("#colorpicker").css("display","none");
          }
            $(".font-family").hide();
            $(".font-size").hide();
    });
    var picker = new YAHOO.widget.ColorPicker("colorpicker", {
            showhsvcontrols: false,
            showhexcontrols: true,
            showrgbcontrols: false,
            showhexsummary: false,
            images: {
                    PICKER_THUMB: "img/picker_thumb.png",
                    HUE_THUMB: "img/hue_thumb.png"
            }
    });
    
    $("#colorpicker").live("mouseup",function(){
        var setInt = setInterval(function() {
                $("#color-picked").css("background-color", "#"+$("#yui-picker-hex").val());
                $("#usermsg").css("color", "#"+$("#yui-picker-hex").val());
                clearInterval(setInt);
                $("#colorpicker").toggle();
        }, 500);
    });
    
    //Scrollbar
    $('#chatbox_wrapper').slimscroll({
              railVisible: true,
              railColor: '#aaa',				  
              allowPageScroll: true,
              size: '10px',
              height: '300px',
              wheelStep: 10,
              distance: '0px',
              color: '#0088CC'
    });

    $('#emoticons_wrapper').slimscroll({
              railVisible: true,
              railColor: '#aaa',				  
              allowPageScroll: true,
              size: '10px',
              height: '80px',
              wheelStep: 10,
              distance: '0px',
              color: '#0088CC'
    });
});

var idxList = "";

var simpleTalk_ = {	

    sendMsg : function()
    {
            $("#submitmsg").live("click", function(){
                    var msg = $("#usermsg").val();
                    $.ajax({
                            url : "index.php",
                            dataType : "JSON",
                            type : "POST",
                            data : {action : 'saveMsg' , usermsg : msg},
                            success : function(response){  
                                $("input#usermsg").val("");
                            }
                    });               
            });
    },

    loadMsg : function(type)
    {
        var bLive = type == "first" ? "true" : "false";

        $.ajax({
                url : "index.php",
                dataType : "JSON",
                type : "POST",
                data : {
                    action : 'loadMsg', 
                    bLive : bLive,
                    idxList : idxList

            },
            success : function(response){  
               
                    var data = JSON.parse(response);
                    if (data){

                        $.each(data, function(key, val){
                            if(val.fmessage){
                                //var fmessage = simpleTalk_.insertSmiley(val['fmessage']);
                                var date = simpleTalk_.realtime(val['fdateCreate'].replace(/-/g,'/'));
                                var user = val.fusername ? val.fusername : "Guest";
                                $("#chatbox1").append("<li><img src='img/user_profile_icon.gif'><b style='color:red;'>"+user+" :</b> "+val.fmessage+"<span class='timeago' style='float:right;margin-top:5px;visibility:visible' title='"+date+"' >"+date+"</span></li>");
                                idxList += "," + val.idx.$id;
                            }
                           


                      });

                    }
            }
        });              

    },
    realtime : function (time_value)
    {
        //$.timeago(new Date()); 
        time_value = time_value.replace(/(\+[0-9]{4}\s)/ig,"");
        var parsed_date = Date.parse(time_value);
        var relative_to = (arguments.length > 1) ? arguments[1] : new Date();
        var timeago = parseInt((relative_to.getTime() - parsed_date) / 1000);
        if (timeago < 60) return 'less than a minute ago';
        else if(timeago < 120) return 'about a minute ago';
        else if(timeago < (45*60)) return (parseInt(timeago / 60)).toString() + ' minutes ago';
        else if(timeago < (90*60)) return 'about an hour ago';
        else if(timeago <= (24*60*60)) return 'about ' + (parseInt(timeago / 3600)).toString() + ' hour/s ago';
        else if(timeago < (48*60*60)) return '1 day ago';
        else return (parseInt(timeago / 86400)).toString() + ' days ago';


    },
    showEmoticons : function()
    {
        var div_emoticons = "";
        var main_path = "./smileys/";

        var text_smiley = new Array(':)',':(',';)',':D',';;)','>:D<',':-/',':x',':>',':-p', ':-*','=((',':-o','x-(',':->','b-)',':-s','#:-s','>:)',':((',':))',
                                    ':|','/:)','=))','o:-)',':-b','=;','i-)','8-|','l-)',':-&',':-$','[-(',':o)','8-}','<:-p','(:|','=p~',':-?','=d>','#-o',':-ss','@-)',':^o',
                                    ':-w',':-<','>:p','<):)',':)]',':-c','~x(',':-h',':-t','8->','x_x',':!!',':-q',':-bd','^#(^','star'
                                    );

        div_emoticons = simpleTalk_.placeEmoticons(main_path,text_smiley);

        $('#wrapper_emoticons').html(div_emoticons); 
    },

    placeEmoticons : function(path, string)
    {
        var div = "<table>";
        div += "<tr>";
        for(var i = 0;i<string.length;i++){
                if(i == 10 || i == 20 || i == 30 || i == 40|| i == 50){
                        div +='<tr></tr>';					
                }
                div += '<td><img src="'+path+(i+1)+'.gif'+'" onclick="simpleTalk_.getSmiley(\''+string[i]+'\')" alt="'+string[i]+'" title="'+string[i]+'"/></td>';				
        } 
        div += "</tr>";
        div += "</table>";
        return div;
    },
    getSmiley : function(smiley) 
    { 
            var smileyWithPadding = " " + smiley + " "; 
            $('#usermsg').val($("#usermsg").val() + smileyWithPadding); 
    }  
}