PHP 4 Constructor Finder
========================

Name says it all. It's a tiny little PHP script that uses Nikita Popov's [PHP-Parser](https://github.com/nikic/PHP-Parser) to find PHP 4 constructors.

What are PHP 4 constructors? These:

    class Bar {
        public function Bar() {
        }
    }

If you didn't know (oh dear god), the modern way to make a constructor is `public function __construct()` - but for backwards-compatibility, we keep around this thing where a function with the same name of the class is magically a constructor. Yuck.

This is a problem, because what if you make a class called `Filter` with a method called `filter`? Uh-oh.

So, Levi Morrison [wrote an RFC to get rid of this](https://wiki.php.net/rfc/remove_php4_constructors), and I wrote this at his request. It finds PHP4 constructors. That's it, really.

Installation and Usage
----------------------

For development, `composer install` in the checked-out repo. For normal use, `composer install -g ajf/PHP4_Constructor_Finder`.

Command line usage is `finder file1.php file2.php ...`.

To scan multiple files in a directory `finder /path/to/dir ...`.

Run the tests with `vendor/bin/phpunit --bootstrap vendor/autoload.php src/tests.php`.
