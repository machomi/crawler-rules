<?php
namespace OW\Rules\Filter;

class FilterManager
{

    private static $preFilters = [
        'modify' => 'OW\Rules\Filter\Pre\ModifyPreFilter'
    ];

    private static $postFilters = [
        'strip_tags' => 'OW\Rules\Filter\Post\StripTagsPostFilter',
        'html' => 'OW\Rules\Filter\Post\HtmlPostFilter',
        'text' => 'OW\Rules\Filter\Post\TextPostFilter',
        'attr' => 'OW\Rules\Filter\Post\AttributePostFilter',
    ];

    public static function exists($alias)
    {
        return isset(self::$preFilters[$alias]) || isset(self::$postFilters[$alias]);
    }

    public static function clazz($alias)
    {
        if (isset(self::$postFilters[$alias])) {
            return self::$postFilters[$alias];
        } elseif (isset(self::$preFilters[$alias])) {
            return self::$preFilters[$alias];
        } else {
            throw new \InvalidArgumentException('There is no registered filter for an alias '.$alias);
        }
    }
    
    public static function alias($class)
    {
        $alias = array_search($class, self::$postFilters);
        if ($alias) {
            return $alias;
        } else {
            $alias = array_search($class, self::$preFilters);
            if ($alias) {
                return $alias;
            }
        }
    }

//     public static function createChain()
//     {
//         $aliases = func_get_args();
        
//         if (! empty($aliases)) {
//             $filters = [];
//             foreach ($aliases as $alias) {
//                 $filters[] = self::create($alias);
//             }
//             return new FilterChain($filters);
//         }
//     }

    public static function register($className, $alias)
    {
        $refl = new \ReflectionClass($className);
        if ($refl->isInterface('OW\Rules\Filter\PostRuleFilter')) {
            self::$postFilters[$alias] = $className;
        } else {
            self::$preFilters[$alias] = $className;
        }
    }

    public static function unregister($className)
    {
        $alias = array_search($className, self::$postFilters);
        if ($alias) {
            unset(self::$postFilters[$alias]);
        } else {
            $alias = array_search($className, self::$preFilters);
            if ($alias) {
                unset(self::$preFilters[$alias]);
            }
        }
    }
}