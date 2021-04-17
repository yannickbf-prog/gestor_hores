<?php

function setActive($routeName) {
    return request()->routeIs($routeName) ? 'active' : '';
}

function setLang() {
    if (\Request::is('en/*')) {
        App::setLocale('en');
        return "en";
    } else if (\Request::is('es/*')) {
        App::setLocale('es');
        return "es";
    }
    else if (\Request::is('ca/*')) {
        App::setLocale('ca');
        return "ca";
    }
}
