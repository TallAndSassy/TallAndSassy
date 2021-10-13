<?php
declare(strict_types=1);
namespace TallAndSassy\PageGuideAdmin\Commands;



final class FileUtils
{
    public static function makeDirIfNotAlreadyThere(string $dirThatNeedsToBeMadeIfNotAlreadyThere): void {
        if (! is_dir($dirThatNeedsToBeMadeIfNotAlreadyThere)) {
            mkdir(directory: $dirThatNeedsToBeMadeIfNotAlreadyThere, recursive: true);
        }
    }
    public static function makeDirForFileIfDirNotAlreadyThere(string $fileThatNeedsDirToBeMadeIfNotAlreadyThere): void {
        $longDir = pathinfo($fileThatNeedsDirToBeMadeIfNotAlreadyThere, PATHINFO_DIRNAME);
        FileUtils::makeDirIfNotAlreadyThere($longDir);
    }
}