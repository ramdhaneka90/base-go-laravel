function initMenu() {
    var active = $('ul.nav').find('a.nav-link.active');
    var parent = $(active).parent().parent().parent()
    var children = $(parent).children();
    if (parent.length > 0) {
        $(parent).addClass('menu-is-opening menu-open')
        $(children).addClass('active');

        var level3 = $('ul.nav').find('a.nav-link.active.level3').parent().parent().parent().parent().parent()
        if (level3.length > 0) {
            $(level3).addClass('menu-is-opening menu-open')
            $(level3).children('a').addClass('active');
        }

    } else {
        var parent = $(active).parent().parent().parent().parent()
        var children = $(parent).children();

        if (parent.length > 0) {
            $(parent).addClass('menu-is-opening menu-open')
            $(children).addClass('active');
        }
    }
}