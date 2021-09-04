<?php

use Hive\View;

View::addFunction('abort', function ($code=403, $detail='') {
    return abort($code, $detail);
});

View::addFunction('env', function ($key) {
    return env($key);
});

View::addFunction('session', function ($key) {
    return session($key);
});

View::addFunction('cookie', function ($key) {
    return cookie($key);
});

View::addFunction('redirect', function ($slug) {
    return redirect($slug);
});

View::addFunction('public_dir', function ($file) {
    return public_dir($file);
});


View::addFunction('__', function ($key,$arguments=[]) {
    return __($key,$arguments);
});


View::addFunction('___', function ($key) {
    return _($key);
});
