$(document).ready(function(){
		var sliderBottom_1 = 0;
		var sliderBottom_2 = 0;
		var sliderBottom_description = 0;
		var src_img_div;
		var valor;
/*
		$(".slider_1").click(function(){
			$('.down_1').slideToggle('fast');
			if(sliderBottom_1 % 2 == 0){
				valor = "/tw_practica/img/arrow-down-orange.gif";
				$('.arrow_1 img').attr("src",valor);
			}else{
				valor = "/tw_practica/img/arrow-up-orange.gif";
				$('.arrow_1 img').attr("src",valor);
			}
			sliderBottom_1++;
  		});
  		$(".slider_2").click(function(){
			$('.down_2').slideToggle('fast');
			if(sliderBottom_2 % 2 == 0){
				valor = "/tw_practica/img/arrow-down-orange.gif";
				$('.arrow_2 img').attr("src",valor);
			}else{
				valor = "/tw_practica/img/arrow-up-orange.gif";
				$('.arrow_2 img').attr("src",valor);
			}
			sliderBottom_2++;
  		});
  		$(".description_th").click(function () {
  			$(".description_div").slideToggle('fast');
  			if(sliderBottom_description % 2 == 0){
				valor = "/tw_practica/img/arrow-up-orange.gif";
				$('.arrow_description img').attr("src",valor);
			}else{
				valor = "/tw_practica/img/arrow-down-orange.gif";
				$('.arrow_description img').attr("src",valor);
			}
			sliderBottom_description++;
  		});

					
*/
		$(".slider_1").click(function(){
			$('.down_1').slideToggle('fast');
			if(sliderBottom_1 % 2 == 0){
				valor = "/tw_practica/img/arrow-down.gif";
				$('.arrow_1 img').attr("src",valor);
			}else{
				valor = "/tw_practica/img/arrow-up.gif";
				$('.arrow_1 img').attr("src",valor);
			}
			sliderBottom_1++;
  		});
  		$(".slider_2").click(function(){
			$('.down_2').slideToggle('fast');
			if(sliderBottom_2 % 2 == 0){
				valor = "/tw_practica/img/arrow-down.gif";
				$('.arrow_2 img').attr("src",valor);
			}else{
				valor = "/tw_practica/img/arrow-up.gif";
				$('.arrow_2 img').attr("src",valor);
			}
			sliderBottom_2++;
  		});
  		$(".description_th").click(function () {
  			$(".description_div").slideToggle('fast');
  			if(sliderBottom_description % 2 == 0){
				valor = "/tw_practica/img/arrow-up.gif";
				$('.arrow_description img').attr("src",valor);
			}else{
				valor = "/tw_practica/img/arrow-down.gif";
				$('.arrow_description img').attr("src",valor);
			}
			sliderBottom_description++;
  		});
  	
});