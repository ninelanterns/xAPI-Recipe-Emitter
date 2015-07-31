<?php namespace XREmitter\Events;

class AttemptCompleted extends AttemptStarted {
    protected static $verb_display = [
        'en' => 'completed'
    ];

    /**
     * Reads data for an event.
     * @param [String => Mixed] $opts
     * @return [String => Mixed]
     * @override Event
     */
    public function read(array $opts) {
        return array_merge(parent::read($opts), [
            'verb' => [
                'id' => 'http://adlnet.gov/expapi/verbs/completed',
                'display' => $this->readVerbDisplay($opts),
            ],
            'result' => [
                'score' => [
                    'raw' => $opts['attempt_result'],
                ],
                'completion' => $opts['attempt_completed'],
                'duration' => $opts['attempt_duration'],
            ],
        ]);
    }
}