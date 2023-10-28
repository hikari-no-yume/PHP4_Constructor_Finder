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

For normal use:
```console
composer global require ajf/PHP4_Constructor_Finder
```

Command line usage is `finder file1.php file2.php ...`.

Example:

```console
$ find sites/all/modules/ -name '*.inc' -exec finder '{}' ';'
Found PHP4 constructor in class "content_profile_theme_variables" in sites/all/modules/content_profile/content_profile.theme_vars.inc on line 11
Found PHP4 constructor in class "ctools_context" in sites/all/modules/ctools/includes/context.inc on line 31
Found PHP4 constructor in class "ctools_context_required" in sites/all/modules/ctools/includes/context.inc on line 94
Found PHP4 constructor in class "ctools_context_optional" in sites/all/modules/ctools/includes/context.inc on line 183
Found PHP4 constructor in class "ctools_math_expr" in sites/all/modules/ctools/includes/math-expr.inc on line 87
Found PHP4 constructor in class "panels_allowed_layouts" in sites/all/modules/panels/includes/common.inc on line 45
Found PHP4 constructor in class "panels_cache_object" in sites/all/modules/panels/includes/plugins.inc on line 116
Found PHP4 constructor in class "views_many_to_one_helper" in sites/all/modules/views/includes/handlers.inc on line 513
Found PHP4 constructor in class "views_tab" in sites/all/modules/views/includes/tabs.inc on line 142
Found PHP4 constructor in class "views_query" in sites/all/modules/views/includes/query.inc on line 11
Found PHP4 constructor in class "webform_exporter_delimited" in sites/all/modules/webform/includes/webform.export.inc on line 96
Found PHP4 constructor in class "webform_exporter_excel" in sites/all/modules/webform/includes/webform.export.inc on line 156
```

Example to scan all files containing classes:

```console
$ grep -rl '<?php' sites/all/modules/ | grep -vi '\.md' | xargs grep -l 'class ' | xargs -n1 finder
```


Contributing
============

For developing, run `composer install` in the checked-out repo.

Run the tests with `vendor/bin/phpunit --bootstrap vendor/autoload.php src/tests.php`.
