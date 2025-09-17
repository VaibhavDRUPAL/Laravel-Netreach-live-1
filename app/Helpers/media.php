<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\{File, Storage};

// Extenstions
const EXT_JSON = '.json';

// Storage Disk
const STD_LOCAL = 'local';
const STD_PUBLIC = 'public';

// Media Type
const MDT_FILE = 0;
const MDT_STORAGE = 1;

// File Action
const FL_CHECK_EXIST = 0;
const FL_CREATE = 1;
const FL_APPEND = 2;
const FL_READ = 3;
const FL_GET_URL = 4;
const FL_DELETE = 5;

// Path
const LANGUAGE_PATH = F_SLASH . 'language' . F_SLASH;
const GREETINGS_IMAGES_PATH = F_SLASH . 'greetings' . F_SLASH . 'images' . F_SLASH;
const GREETINGS_AUDIO_PATH = F_SLASH . 'greetings' . F_SLASH . 'audio' . F_SLASH;
const ANSWER_IMAGES_PATH = F_SLASH . 'answer' . F_SLASH . 'images' . F_SLASH;
const ANSWER_AUDIO_PATH = F_SLASH . 'answer' . F_SLASH . 'audio' . F_SLASH;
const BACKUP_PATH = F_SLASH . 'backup' . F_SLASH;
const CENTER_CLEAN_PATH = F_SLASH . 'center' . F_SLASH . 'clean' . F_SLASH;
const EVIDENCE_PATH = F_SLASH . 'evidence';
const FOLLOWUP_PATH = F_SLASH . 'followup';

if (!function_exists('getFileName')) {
    /**
     * Get File Name
     * 
     * @return string
     */
    function getFileName(): string
    {
        return currentDateTime(FOR_FILE_NAME_FORMAT) . rand(0, 9999);
    }
}

if (!function_exists('mediaOperations')) {
    /**
     * Media Operations
     * 
     * @param string|array|null $destinationPath
     * @param mixed $content
     * @param int|null $action
     * @param int $type
     * @param string|null $disk
     * @param string|null $fileName
     * 
     * @return mixed
     */
    function mediaOperations(string|array|null $destinationPath, mixed $content = null, int|null $action = FL_CREATE, int $type = MDT_STORAGE, string|null $disk = null, string|null $fileName = null): mixed
    {
        if ($action == FL_CHECK_EXIST && empty($destinationPath)) return false;

        if ($content instanceof UploadedFile) return $content->storeAs($destinationPath, $fileName, $disk);

        $diskStatus = $type == MDT_STORAGE ? true : false;

        $content = is_array($content) ? json_encode($content) : $content;

        $media = $type == MDT_STORAGE ? new Storage : new File;

        if ($diskStatus) $media = $media::disk($disk);

        if ($action == FL_CHECK_EXIST) return $diskStatus ? $media->exists($destinationPath) : $media::exists($destinationPath);

        if ($action == FL_CREATE) return $diskStatus ? $media->put($destinationPath, $content) : $media::put($destinationPath, $content);

        if ($action == FL_APPEND) return $diskStatus ? $media->append($destinationPath, $content) : $media::append($destinationPath, $content);

        if ($action == FL_READ) return $diskStatus ? $media->get($destinationPath) : $media::get($destinationPath);

        if ($action == FL_GET_URL) return $diskStatus ? $media->url($destinationPath) : $media::url($destinationPath);

        if ($action == FL_DELETE) return $diskStatus ? $media->delete($destinationPath) : $media::delete($destinationPath);
    }
}