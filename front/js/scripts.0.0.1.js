/*****************************************************/
/*** custom script for this project ***/
/*****************************************************/

$('.main-slider .owl-carousel').owlCarousel({
    rtl:true,
    loop:true,
    autoplay:false,
    autoplayTimeout:6000,
	smartSpeed:1000,
	items:1,
    margin:0,
    nav:true,
	navText: [
      "<i class='fa fa-angle-left'></i>",
      "<i class='fa fa-angle-right'></i>"
      ]
    
});

// Pretty Photo LightBox
$("a[rel^='prettyPhoto']").prettyPhoto({
	social_tools: false
});

$('.clients .owl-carousel').owlCarousel({
    rtl:true,
    loop:true,
    margin:10,
    nav:true,
	navText: [
      "<i class='fa fa-angle-left'></i>",
      "<i class='fa fa-angle-right'></i>"
      ],
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:6
        }
    }
});