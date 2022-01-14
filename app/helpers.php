<?php

if (! function_exists('some')) {
    function some(...$predicates) : bool
    {
        foreach ($predicates as $predicate) {
            if ($predicate) {
                return true;
            }
        }

        return false;
    }
}

if (! function_exists('every')) {
    function every(...$predicates) : bool
    {
        foreach ($predicates as $predicate) {
            if (! $predicate) {
                return false;
            }
        }

        return true;
    }
}

if (! function_exists('none')) {
    function none(...$predicates) : bool
    {
        foreach ($predicates as $predicate) {
            if ($predicate) {
                return false;
            }
        }

        return true;
    }
}
