<?php


namespace TallAndSassy\PageGuide;

abstract class RenderWrangler
{

    #abstract protected static array $asrProviders; // I only want to share at the leaf
    #abstract public static function wrangleMe(string $key, $asrPackageOrCloser): void;

    public static function wrangleMe(string $key, $asrPackageOrCloser): void
    {
        assert(static::payloadValidates($asrPackageOrCloser));
        static::$asrProviders[$key] = $asrPackageOrCloser;
    }

    protected static function payloadValidates($asrPackageOrCloser): bool
    {
        if (is_object($asrPackageOrCloser)) {
            return true;// we're assuming it is a closure.
        }
        assert(is_array($asrPackageOrCloser));
        assert(isset($asrPackageOrCloser['name']));
        assert(isset($asrPackageOrCloser['routeIs']));
        assert(in_array(gettype($asrPackageOrCloser['routeIs']), ['string','object']));
        assert(isset($asrPackageOrCloser['url']));
        assert(isset($asrPackageOrCloser['classes']));

        return true;
    }

//    public static function renderKey(string $key): string {
//
//
//    }


    /* Return list of packages that registered for grokking */
    public static function wranglees(): array
    {
        return get_called_class()::$asrProviders;
    }

    public static function keyExits(string $key): bool
    {
        return key_exists($key, static::$asrProviders);
    }

    abstract public static function getActiveKey(): ?string;


    public static function getPackage_byKey(string $key): array
    {
        assert(key_exists($key, static::$asrProviders));

        return static::$asrProviders[$key];
    }

    public static function isActive(string $key): bool
    {
        return static::getActiveKey() == $key;
    }
}
