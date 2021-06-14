if (window.location.href.includes('books')) {

    var nav = document.getElementById('nav-books');
    nav.classList.add('active');

} else if (window.location.href.includes('login')) {

    var nav = document.getElementById('nav-login');
    nav.classList.add('active');

} else if (window.location.href.includes('register')) {

    var nav = document.getElementById('nav-register');
    nav.classList.add('active');

} else if (window.location.href.includes('rentals')) {

    var nav = document.getElementById('nav-rentals');
    nav.classList.add('active');

} else if (window.location.href.includes('profile')) {

    var nav = document.getElementById('navbarDropdown');
    nav.classList.add('active');

}

if (window.location.href.includes('pending')) {

    var tab = document.getElementById('rentals-pending');
    tab.classList.add('active');

} else if (window.location.href.includes('rejected')) {

    var tab = document.getElementById('rentals-rejected');
    tab.classList.add('active');

} else if (window.location.href.includes('accepted')) {

    var tab = document.getElementById('rentals-accepted');
    tab.classList.add('active');

} else if (window.location.href.includes('returned')) {

    var tab = document.getElementById('rentals-returned');
    tab.classList.add('active');

} else if (window.location.href.includes('delay')) {

    var tab = document.getElementById('rentals-delay');
    tab.classList.add('active');

}
