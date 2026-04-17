
$(function(){

	$('#mainSlider').nivoSlider();
	//$('.productSlider').nivoSlider();
	var sliderOptions = {
		'height' : 300,
		'width' : 900,
		animtype : 'slide',
		automatic : false,
		showcontrols : true,
		centercontrols : false,
		showmarkers : false,
		nexttext : '', 
		prevtext : '',
		centermarkers : false,
		'responsive' : false
	}
	$(".productSlider").each(function(a,b){
		$(this).bjqs(sliderOptions);
	});
	//saco click a los productos
	$(".productSlider a ").click(function(e){e.preventDefault})
	$("ul#menu li a").smoothScroll({});

	$(".menues a ").click(function(e){
		console.log(this,"hola",$(this).parent().parent().find("li"))
		e.preventDefault();
		var link = this;
		$(this).parent().parent().parent().parent().find(".productSlider").each(function(a,b){
			if($(this).is(":visible"))
				$(this).fadeOut(null, function(){
					console.log("heyyyy"+console.log("heyyyy"))
					$($(link).attr("href")).fadeIn();
				});
		});
		
		
		$(this).parent().parent().find("li").removeClass("active");
		$(this).parent().addClass("active");

	})

	$(window).scroll(function(e){
		var scroll = $(window).scrollTop();
		var id=null,page=null;
		$("div.seccion").each(function(){
			//console.log((scroll >= $(this).position().top  && scroll <= ($(this).position().top+$(this).height())),$(this).position().top,scroll, ($(this).position().top+$(this).height()));
			if(scroll >= $(this).position().top-50 ) { //  && scroll <= ($(this).position().top+$(this).height())){
				id=this.id;
				page=$(this)
			}
		});

		if(id&&!$("#menu a[href=#"+id+"]").parent().hasClass("active")){
			$("#menu li").removeClass("active");
			$("#menu a[href=#"+id+"]").parent().addClass("active")
		}
		if(id=="contactoPage"){
			$("#mainHeader").addClass("contact");
		} else {
			$("#mainHeader").removeClass("contact");
		}
	})



	//tooltips:

	$(".productSlider > div > ul > li > ul li a").tooltip({ 
    bodyHandler: function() { 
        return $($(this).parent().find(".tooltopContainer")).html(); 
    }, 
    track: true, 
    delay: 0, 
    showURL: false,
    top:-100
});
})