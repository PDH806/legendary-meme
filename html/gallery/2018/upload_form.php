<script src="https://use.fontawesome.com/0ec13dcd55.js"></script>
 <script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script>
<style type="text/css">
    .imgs_wrap	{
        border: 2px solid #A8A8A8;
		min-height:400px;
        margin-top: 30px;
        margin-bottom: 30px;
        padding-top: 10px;
        padding-bottom: 10px;
    }
    .imgs_wrap img {
        max-width: 150px;
		margin-left:8px;
		margin-top:8px;
    }
	.AClass{
		font-size: 17px;
	    position: absolute;
	    opacity: 1;
		color:red;
	}
	.wrap_div_img{
		max-width: 150px;
        margin-left: 10px;
        margin-right: 10px;
	}
	.btn-_default{
		padding: 10px 16px;
	    font-size: 18px;
	    line-height: 1.3333333;
	    border-radius: 6px;
	    color: #333;
	    background-color: #fff;
	    border-color: #ccc;
	    border: 1px solid transparent;
	}
</style>
<br>

<div class = 'container-fluid' style = 'font-size:24pt;color:#404040;text-align:center;'>
		(사)한국스키장경영협회 갤러리용 이미지 대량 업로드 프로그램
</div>

<div style="width:90%; margin:auto;">
	<div>
	    <div class="imgs_wrap" style="text-align:center;">
	    	<h2 class="imgs_wrap_h2" style="color: #aaa;top: 50px;position: relative;"><b>(사)한국스키장경영협회<br>갤러리 이미지 미리보기 (다중 업로드 가능)</b></h2>
		</div>
	</div>
	<div class="input_wrap" style="text-align:center;">
	    <a href="javascript:" onclick="file_upload();" class="btn-_default" style="width: 150;height: 45px;">사진선택</a>
	    <input type="file" id="input_imgs" multiple style="display:none" />
		&nbsp;&nbsp;&nbsp;
		<a href="javascript:" class="btn-_default" style="width: 150;height: 45px;" onclick="file_submit();">전송하기</a>
	</div>
</div>
<script type="text/javascript">

var sel_files = new Array();
var h2_html = "<h2 class=\"imgs_wrap_h2\" style=\"color: #aaa;top: 50px; position: relative;\"><b>이미지 미리보기</b></h2>";

$(document).ready(function() {
    $("#input_imgs").on("change", file_handler);
}); 

function file_upload() 
{
    $("#input_imgs").trigger('click');
}

function file_handler(e) 
{

    var files = e.target.files;
    var filesArr = Array.prototype.slice.call(files);

    filesArr.forEach(function(file) {
        if(!file.type.match("image.*"))
		{
            alert("확장자는 이미지 파일만 가능합니다.");
            return;
        }

        var f_reader = new FileReader();
    	var index = sel_files.length;
        f_reader.onload = function(e) {
			var delete_html = "<div class=\"wrap_div_img\" id=\"img_id_"+index+"\" style=\"display: inline-block\">" +
								"<button type=\"button\" class=\"close AClass\" style=\"\" onclick=\"delete_img("+index+")\"><span><i class=\"fa fa-times-circle-o\" aria-hidden=\"true\"></i></span></button>"+
		   						"<img src=\"" + e.target.result + "\" ></a>"+
								"</div>";
            $(".imgs_wrap").append(delete_html);
			$(".imgs_wrap_h2").remove();
			$(".imgs_wrap").css("text-align", "");
        }
        sel_files.push(file);
        f_reader.readAsDataURL(file);
    });
}

function delete_img(index) 
{
    sel_files.splice(index, 1);
    $("#img_id_"+index).remove();
	if( sel_files.length == 0 )
	{
		$(".imgs_wrap").append(h2_html);
		$(".imgs_wrap").css("text-align", "center");
	}
}

function file_submit() 
{
    var data = new FormData();

    for(var i=0; i<sel_files.length; i++) 
	{	
		var name = i;
        data.append(name, sel_files[i]);
	}

    data.append("image_count", sel_files.length);
    if(sel_files.length < 1) 
	{
		alert("파일을 선택해주세요.")
        return;
    }
	$.ajax({
		url: "upload_cnt.php",
        type: 'POST',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) { alert(response); },
        error: function () { fx_alert("서버와의 연결에 문제가 있습니다. 잠시후 다시 시도해 주세요."); }
    });
}

</script>
