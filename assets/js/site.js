
/**
 * Kun sivu ladataan, verrataan sivun osoitteen loppuosaa 
 * (viimeisen "/"-merkin jalkeinen osa) 
 * kunkin valilehtilinkin osoitteen loppuosaan ja asetetaan 
 * aktiiviseksi se linkki, jonka 
 * loppuosa on sama kuin nykyisella osoitteella. 
 */

$(document).ready(function () {

    var pathItems = window.location.pathname.split("/");
    var lastItem = pathItems[pathItems.length - 1];

    $("nav li a").filter(function(index) {
        var items = this.href.split("/");
        var item = items[items.length - 1];
        return item === lastItem;
    }).parent().addClass("active");
});
