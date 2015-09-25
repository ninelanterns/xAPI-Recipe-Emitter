<?php namespace XREmitter\Events;
use \XREmitter\Repository as Repository;
use \stdClass as PhpObj;

abstract class Event extends PhpObj {
    protected static $verb_display;
    protected $repo;

    /**
     * Constructs a new Event.
     * @param repository $repo
     */
    public function __construct(Repository $repo) {
        $this->repo = $repo;
    }

    /**
     * Creates an event in the repository.
     * @param [string => mixed] $event
     * @return [string => mixed]
     */
    public function create(array $event) {
        return $this->repo->createEvent($event);
    }

    /**
     * Reads data for an event.
     * @param [String => Mixed] $opts
     * @return [String => Mixed]
     */
    public function read(array $opts) {
        $version = str_replace(PHP_EOL, '', file_get_contents(__DIR__.'/../../VERSION'));
        $version_key = 'https://github.com/LearningLocker/xAPI-Recipe-Emitter';
        $opts['context_info']->{$version_key} = $version;
        return [
            'actor' => $this->readUser($opts, 'user'),
            'context' => [
                'platform' => $opts['context_platform'],
                'language' => $opts['context_lang'],
                'extensions' => [
                    $opts['context_ext_key'] => $opts['context_ext'],
                    'http://lrs.learninglocker.net/define/extensions/info' => $opts['context_info'],
                ],
                'contextActivities' => [
                    'grouping' => [
                        $this->readApp($opts),
                    ],
                ],
            ],
            'timestamp' => $opts['time'],
        ];
    }

    protected function readUser(array $opts, $key) {
        return [
            'name' => $opts[$key.'_name'],
            'account' => [
                'homePage' => $opts[$key.'_url'],
                'name' => $opts[$key.'_id'],
            ],
        ];
    }

    protected function readActivity(array $opts, $key) {
        return [
            'id' => $opts[$key.'_url'],
            'definition' => [
                'type' => $opts[$key.'_type'],
                'name' => [
                    $opts['context_lang'] => $opts[$key.'_name'],
                ],
                'description' => [
                    $opts['context_lang'] => $opts[$key.'_description'],
                ],
            ],
        ];
    }

    protected function readCourse($opts) {
        return $this->readActivity($opts, 'course');
    }

    protected function readApp($opts) {
        return $this->readActivity($opts, 'app');
    }

    protected function readModule($opts) {
        return $this->readActivity($opts, 'module');
    }

    protected function readDiscussion($opts) {
        return $this->readActivity($opts, 'discussion');
    }

    protected function readVerbDisplay($opts) {
        $lang = $opts['context_lang'];
        $lang = isset(static::$verb_display[$lang]) ? $lang : array_keys(static::$verb_display)[0];
        return [$lang => static::$verb_display[$lang]];
    }
}
