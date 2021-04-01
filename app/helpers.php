<?php

function setActive($routeName){
    request()->routeIs($routeName) ? 'active' : '';
}