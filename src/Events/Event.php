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
        $version = trim(file_get_contents(__DIR__.'/../../VERSION'));
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
                        $this->readApp($opts)
                    ],
                    'category' => [
                        $this->readSource($opts)
                    ]
                ],
            ],
            'timestamp' => $opts['time'],
        ];
    }

    protected function readUser(array $opts, $key) {
        global $DB;
        
        $config = get_config('logstore_xapi', 'useridentifier');
        
        $email = $DB->get_field('user', 'email', array('id' => $opts[$key.'_id']));
        $userarray = array('name' => $opts[$key.'_name']);
        
        if (!empty($config) || $config == 'account') {
            $userarray['account'] = array(
                'homePage' => $opts[$key.'_url'],
                'name' => $opts[$key.'_id']
            );
        } else {
            $userarray['mbox'] = 'mailto:'.$email;
        }
        
        return $userarray;
    }

    protected function readActivity(array $opts, $key) {
        $activity = [
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

        if (isset($opts[$key.'_ext']) && isset($opts[$key.'_ext_key'])) {
            $activity['definition']['extensions'] = [];
            $activity['definition']['extensions'][$opts[$key.'_ext_key']] = $opts[$key.'_ext'];
        }

        return $activity;
    }

    protected function readCourse($opts) {
        return $this->readActivity($opts, 'course');
    }

    protected function readApp($opts) {
        return $this->readActivity($opts, 'app');
    }

    protected function readSource($opts) {
        return $this->readActivity($opts, 'source');
    }

    protected function readModule($opts) {
        return $this->readActivity($opts, 'module');
    }

    protected function readDiscussion($opts) {
        return $this->readActivity($opts, 'discussion');
    }

    protected function readQuestion($opts) {
        $opts['question_type'] = 'http://adlnet.gov/expapi/activities/cmi.interaction';
        $question = $this->readActivity($opts, 'question');

        $question['definition']['interactionType'] = $opts['interaction_type'];
        $question['definition']['correctResponsesPattern'] = $opts['interaction_correct_responses'];

        $supportedComponentLists = [
            'choice' => ['choices'],
            'sequencing' => ['choices'],
            'likert' => ['scale'],
            'matching' => ['source', 'target'],
            'performance' => ['steps'],
            'true-false' => [],
            'fill-in' => [],
            'long-fill-in' => [],
            'numeric' => [],
            'other' => []
        ];

        foreach ($supportedComponentLists[$opts['interaction_type']] as $index => $listType) {
            if (isset($opts['interaction_'.$listType]) && !is_null($opts['interaction_'.$listType])) {
                $componentList = [];
                foreach ($opts['interaction_'.$listType] as $id => $description) {
                    array_push($componentList, (object)[
                        'id' => (string) $id,
                        'description' => [
                            $opts['context_lang'] => $description,
                        ]
                    ]);
                }
                $question['definition'][$listType] = $componentList;
            }
        }
        return $question;
    }

    protected function readVerbDisplay($opts) {
        $lang = $opts['context_lang'];
        $lang = isset(static::$verb_display[$lang]) ? $lang : array_keys(static::$verb_display)[0];
        return [$lang => static::$verb_display[$lang]];
    }
}
