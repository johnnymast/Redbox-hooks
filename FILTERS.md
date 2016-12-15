# Filters callback functions

```php
function func_prepend_at($text='') {
    return '@@'.$text;
}
Sandbox\Filters::add_filter('prepend_at', 'func_prepend_at');

$out = Sandbox\Filters::apply_filter('prepend_at', 'This is a text');
echo "Output: ".$out."\n";
```
***Output***

```bash
$ php ./functions.php
Output: @@This is a text
```

# Filters with closures

```php
Sandbox\Filters::add_filter('prepend_at', function($text='') {
    return '@@'.$text;
});

$out = Sandbox\Filters::apply_filter('prepend_at', 'This is a text');
echo "Output: ".$out."\n";
```

***Output***

```bash
$ php ./functions.php
Output: @@This is a text
```


# Filters with priority

```php
function func_second($text='') {
    return '@@'.$text;
}
Sandbox\Filters::add_filter('prepend_at', 'func_second',1);

function func_first($text='') {
    return '!!'.$text;
}
Sandbox\Filters::add_filter('prepend_at', 'func_first', 0);

$out = Sandbox\Filters::apply_filter('prepend_at', 'This is a text');
echo "Output: ".$out."\n";
```
***Output***

```bash
$ php ./functions.php
Output: @@!!This is a text
```

# Filters in classes

```php
class Filter {

    public function prepend_chars($text='') {
        return '@@'.$text;
    }

    public function append_chars($text='') {
        return $text.'@@';
    }

    public function execute() {

        Sandbox\Filters::apply_filter('manipulate_string', [$this, 'prepend_chars']);
        Sandbox\Filters::apply_filter('manipulate_string', [$this, 'append_chars']);

        return Sandbox\Filters::apple_filter('manipulate_string', 'This is a text');
    }
}

$instance = new Filter;
$out = $instance->execute();

echo "Output: ".$out."\n";
```
***Output***

```bash
$ php ./functions.php
Output: @@This is a text@@

```