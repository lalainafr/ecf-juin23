//  --- JQUERY  --- 

// ANIMATION PAGE ACCUEIL

$('.homeContent').hide();
$('.homeImage').hide();

$('.homeTitle').click(()=> {
    $('.homeContent').fadeToggle(2000);
})
$('.homeContent').click(()=> {
    $('.homeImage').fadeToggle(2000);
})

$('.homeImage').click(()=> {
    $('.homeContent').slideToggle();
    $('.homeImage').slideUp()
})


// ANIMATION PAGE MENU

$('.formulaTitle').hide();
$('.plat').hide();

$('.menuTitle').click(()=> {
    $('.formulaTitle').fadeToggle(2000);
})

$('.formulaTitle').click(()=> {
    $('.plat').fadeToggle(2000).animate ({opacity : .7, margin :30}) ;
})

$('.plat').click(()=> {
    $('.plat').slideUp();
})


// ANIMATION PAGE CARTE

$('.dishContent').hide();
$('.dishPhoto').hide();

$('.dishCategory').click(()=> {
    $('.dishContent').fadeToggle(2000).animate ({opacity : .7, margin :30}) ;
})

$('.dishContent').click(()=> {
    $('.dishPhoto').fadeToggle(2000);
    $('.dishContent').animate ({
        opacity : .7,
        margin :10
    }); 
});
