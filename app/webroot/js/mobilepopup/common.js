$().ready(function(){
	$("body").on("click",".popup-demo",function(){
		$.mobilepopup({
			targetblock:".pop-up1",
			width:"500px",
			height:"300px"
		});
		return false;
	});

	$("body").on("click",".get-demopopup2",function(){
		$.mobilepopup('reload',{
			targetblock:".pop-up2",
			height:"400px"
		});
		return false;
	});

	$("body").on("click",".confirm-action",function(){
		$.mobilepopup({
			type:"confirm",
			width:"500px",
			height:"auto",
			closeonoverflowclick: false,
			fullscreeninmobile: false,
			onconfirmed: function(el){
				alert("Action confirmed");
			}
		});
		return false;
	});

	$("body").on("click",".confirm-goto-link",function(e){
		e.preventDefault();
		var link = $(this);
		$.mobilepopup({
			type:"confirm",
			width:"500px",
			height:"auto",
			closeonoverflowclick: false,
			fullscreeninmobile: false,
			onconfirmed: function(el){
				location.href = link.attr("href");
			}
		});
		return false;
	});

	$("body").on("click",".popup-form",function(){
	    $.mobilepopup({
			targetblock:".pop-up-form",
			width:"500px",
			height:"auto",
			onformsubmited: function(data, el){
				$.mobilepopup('reload',{html:data});
			}
		});
	    return false;
	});
});