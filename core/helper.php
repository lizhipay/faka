<?php
declare (strict_types=1);
# install symfony/var-dump to your project
# composer require symfony/var-dumper

// use namespace
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\HtmlDumper as SymfonyHtmlDumper;

/**
 * Class HtmlDumper
 */
class HtmlDumper extends SymfonyHtmlDumper
{
    /**
     * Colour definitions for output.
     *
     * @var array
     */
    protected $styles = [
        'default' => 'background-color:#fff; color:#222; line-height:1.2em; font-weight:normal; font:12px Monaco, Consolas, monospace; word-wrap: break-word; white-space: pre-wrap; position:relative; z-index:100000',
        'num' => 'color:#a71d5d',
        'const' => 'color:#795da3',
        'str' => 'color:#df5000',
        'cchr' => 'color:#222',
        'note' => 'color:#a71d5d',
        'ref' => 'color:#a0a0a0',
        'public' => 'color:#795da3',
        'protected' => 'color:#795da3',
        'private' => 'color:#795da3',
        'meta' => 'color:#b729d9',
        'key' => 'color:#df5000',
        'index' => 'color:#a71d5d',
    ];
}

/**
 * Class Dumper
 */
class Dumper
{
    /**
     * Dump a value with elegance.
     *
     * @param  mixed  $value
     * @return void
     */
    public function dump($value)
    {
        if (class_exists(CliDumper::class)) {
            $dumper = 'cli' === PHP_SAPI ? new CliDumper : new HtmlDumper;
            $dumper->dump((new VarCloner)->cloneVar($value));
        } else {
            var_dump($value);
        }
    }
}

if (! function_exists('dd')) {
    /**
     * Dump the passed variables and end the script.
     *
     * @param  mixed
     * @return void
     */
    function dd(...$args)
    {
        foreach ($args as $x) {
            (new Dumper)->dump($x);
        }
        die(1);
    }
}

if (! function_exists('dda')) {
    /**
     * Dump the passed array variables and end the script.
     *
     * @param  mixed
     * @return void
     */
    function dda(...$args)
    {
        foreach ($args as $x) {
            (new Dumper)->dump($x->toArray());
        }
        die(1);
    }
}