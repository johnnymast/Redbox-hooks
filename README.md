![redbox-hooks-logo-klein](https://cloud.githubusercontent.com/assets/121194/21081963/afe99cc8-bfd1-11e6-9ac6-25922c8b58b2.png)

# Redbox-hooks

[![Build Status](https://travis-ci.org/johnnymast/Redbox-hooks.svg?branch=master)](https://travis-ci.org/johnnymast/Redbox-hooks)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/johnnymast/redbox-hooks/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/johnnymast/redbox-hooks/?branch=master)
[![Twitter URL](https://img.shields.io/twitter/url/http/shields.io.svg?style=social&label=Contact%20author)](https://twitter.com/intent/tweet?text=@mastjohnny)

Redbox-hooks allow you use Wordpress actions and filters in your own code. The syntax is easy to use as you expect it to be after seeing it in Wordpress it self.

If you want to look at some demo's in details then read the manual for:
 
* [Filters](FILTERS.md)
* [Actions](ACTIONS.md)

# Why was this package created?
This package was created because i am building a new modulair cms. I figured i could use a package like this and started building.


#Fun fact
I a am not a TDD guy but 50% of this code was written with the TDD concept in mind. Actually i was pretty much surprised on how it worked out and the speed the development came in.


## Requirements

The following versions of PHP are supported by this version.

+ PHP 5.6
+ PHP 7.0
+ PHP 7.1
+ HHVM

## Known issues

If you come across a bug/issue you can always report them to the [issue tracker](https://github.com/johnnymast/Sandbox/issues). While developing this package this is something things
i noticed. Those things are listed below.

### Filter/Action function callback is not called
If you have functions inside a namespace. So should add the full namespace to the callback function like this example here.

```php
namespace Sandbox\Demos;

use Sandbox\Filters;

function func_first($text = '')
{
    return '!!' . $text;
}
Filters::addFilter('prepend_at', 'Sandbox\Demos\func_first', 0);
```
 
## Author

This package is created and maintained by [Johnny Mast](https://github.com/johnnymast).

## License

The MIT License (MIT)

Copyright (c) 2017 Johnny Mast

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

