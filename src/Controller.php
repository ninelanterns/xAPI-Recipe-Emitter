<?php namespace XREmitter;
use \stdClass as PhpObj;

class Controller extends PhpObj {
    protected $repo;
    public static $routes = [
        'course_viewed' => 'CourseViewed',
        'discussion_viewed' => 'DiscussionViewed',
        'module_viewed' => 'ModuleViewed',
        'attempt_started' => 'AttemptStarted',
        'attempt_completed' => 'AttemptCompleted',
        'user_loggedin' => 'UserLoggedin',
        'user_loggedout' => 'UserLoggedout',
        'submission_graded' => 'AssignmentGraded',
        'assessable_submitted' => 'AssignmentSubmitted',
    ];

    /**
     * Constructs a new Controller.
     * @param Repository $repo
     */
    public function __construct(Repository $repo) {
        $this->repo = $repo;
    }

    /**
     * Creates a new event.
     * @param [String => Mixed] $opts
     * @return [String => Mixed]
     */
    public function createEvent(array $opts) {
        $route = isset($opts['recipe']) ? $opts['recipe'] : '';
        if (isset(static::$routes[$route])) {
            $event = '\XREmitter\Events\\'.static::$routes[$route];
            return (new $event($this->repo))->read($opts);
        } else {
            return null;
        }
    }
}
