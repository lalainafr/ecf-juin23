//  --- JQUERY  --- 

// ANIMATION PAGE ACCUEIL

$('.homeContent').hide();
$('.homeImage').hide();

$('.homeTitle').click(()=> {
    $('.homeContent').fadeToggle();
})
$('.homeContent').click(()=> {
    $('.homeImage').fadeToggle();
})

$('.homeImage').click(()=> {
    $('.homeContent').slideToggle();
    $('.homeImage').slideUp()
})


// ANIMATION PAGE MENU

$('.formulaTitle').hide();
$('.plat').hide();

$('.menuTitle').click(()=> {
    $('.formulaTitle').fadeToggle();
})

$('.formulaTitle').click(()=> {
    $('.plat').fadeToggle().animate ({opacity : .6, margin :30}) ;
})

$('.plat').click(()=> {
    $('.plat').slideUp();
})


// ANIMATION PAGE CARTE

$('.dishContent').hide();
$('.dishPhoto').hide();

$('.dishCategory').click(()=> {
    $('.dishContent').fadeToggle().animate ({opacity : .6, margin :30}) ;
})

$('.dishContent').click(()=> {
    $('.dishPhoto').fadeToggle();
    $('.dishContent').animate ({
        opacity : .6,
        margin :10
    }); 
});
