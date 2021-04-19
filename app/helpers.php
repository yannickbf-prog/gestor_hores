<?php

function setActive($routeName) {
    return request()->routeIs($routeName) ? 'active' : '';
}

function setActiveLang($lang){
    if(\Request::is($lang.'/*')){
        return 'selected';
    }
    else{
        return '';
    }
}

function setGetLang() {
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

function getLang(){
    if (\Request::is('en/*')) {
        return "en";
    } else if (\Request::is('es/*')) {
        return "es";
    }
    else if (\Request::is('ca/*')) {
        return "ca";
    }
}