jQuery(document).ready(function($){

    var body = $('body');
    var siteHeader = $('#site-header');
    var titleContainer = $('#title-container');
    var toggleNavigation = $('#toggle-navigation');
    var menuPrimaryContainer = $('#menu-primary-container');
    var menuPrimary = $('#menu-primary');
    var menuPrimaryItems = $('#menu-primary-items');
    var toggleDropdown = $('.toggle-dropdown');
    var socialMediaIcons = siteHeader.find('.social-media-icons');
    var menuLink = $('.menu-item').children('a');
    var loop = $('#loop-container');

    $(window).resize(function(){
        removeToggleDropdownKeyboard();
    });

    $('.post-content').fitVids({
        customSelector: 'iframe[src*="dailymotion.com"], iframe[src*="slideshare.net"], iframe[src*="animoto.com"], iframe[src*="blip.tv"], iframe[src*="funnyordie.com"], iframe[src*="hulu.com"], iframe[src*="ted.com"], iframe[src*="vine.co"], iframe[src*="wordpress.tv"]'
    });

    // Jetpack infinite scroll event that reloads posts. Reapply fitvids to new featured videos
    $( document.body ).on( 'post-load', function () {

        // move any posts in infinite wrap to loop-container
        $('.infinite-wrap').children('.entry').detach().appendTo( loop );
        $('.infinite-wrap, .infinite-loader').remove();

    } );

    toggleNavigation.on('click', openPrimaryMenu);

    function openPrimaryMenu() {

        if( menuPrimaryContainer.hasClass('open') ) {
            menuPrimaryContainer.removeClass('open');

            menuPrimaryContainer.css('max-height', '');

            // change screen reader text
            $(this).children('span').text(objectL10n.openMenu);

            // change aria text
            $(this).attr('aria-expanded', 'false');

        } else {
            menuPrimaryContainer.addClass('open');

            var menuHeight = menuPrimary.outerHeight(true) + socialMediaIcons.outerHeight(true);

            menuPrimaryContainer.css('max-height', menuHeight);

            // change screen reader text
            $(this).children('span').text(objectL10n.closeMenu);

            // change aria text
            $(this).attr('aria-expanded', 'true');
        }
    }

    // display the dropdown menus
    toggleDropdown.on('click', openDropdownMenu);

    function openDropdownMenu() {

        // get the buttons parent (li)
        var menuItem = $(this).parent();

        // if already opened
        if( menuItem.hasClass('open') ) {

            // remove open class
            menuItem.removeClass('open');

            // remove max-height added by JS when opened
            $(this).siblings('ul').css('max-height', 0);

            // change screen reader text
            $(this).children('span').text(objectL10n.openChildMenu);

            // change aria text
            $(this).attr('aria-expanded', 'false');
        } else {

            // add class to open the menu
            menuItem.addClass('open');

            // set var for current height
            var ulHeight = 0;

            // get all dropdown children and use their height to set the new max height
            $(this).siblings('ul').find('li').each(function () {
                ulHeight = ulHeight + $(this).height() + ( $(this).height() * 1.5 );
            });

            // set the new max height (for smoother transitions)
            $(this).siblings('ul').css('max-height', ulHeight);

            // expand entire menu for dropdowns
            // doesn't need to be precise. Just needs to allow the menu to get taller
            menuPrimaryContainer.css('max-height', 'none');

            // change screen reader text
            $(this).children('span').text(objectL10n.closeChildMenu);

            // change aria text
            $(this).attr('aria-expanded', 'true');
        }
    }

    function removeToggleDropdownKeyboard() {

        if( window.innerWidth > 799 ) {
            toggleDropdown.attr('tabindex', -1);
        } else {
            toggleDropdown.attr('tabindex', '');
        }
    }
    removeToggleDropdownKeyboard();

    /* allow keyboard access/visibility for dropdown menu items */
    menuLink.focus(function(){
        $(this).parents('ul, li').addClass('focused');
    });
    menuLink.focusout(function(){
        $(this).parents('ul, li').removeClass('focused');
    });
});

/* fix for skip-to-content link bug in Chrome & IE9 */
window.addEventListener("hashchange", function(event) {

    var element = document.getElementById(location.hash.substring(1));

    if (element) {

        if (!/^(?:a|select|input|button|textarea)$/i.test(element.tagName)) {
            element.tabIndex = -1;
        }

        element.focus();
    }

}, false);