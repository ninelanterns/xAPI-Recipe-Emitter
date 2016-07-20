<?php namespace XREmitter\Events;

class ScormScorerawSubmitted extends Event {
    protected static $verb_display;

    /**
     * Reads data for an event.
     * @param [String => Mixed] $opts
     * @return [String => Mixed]
     * @override Event
     */
    public function read(array $opts) {
        return array_merge_recursive(parent::read($opts), [
            'verb' => $this->readScormVerb($opts),
            'result' => [
                'score' => [
                    'raw' => $opts['scorm_score_raw'],
                    'min' => $opts['scorm_score_min'],
                    'max' => $opts['scorm_score_max'],
                    'scaled' => $opts['scorm_score_scaled']
                ],
            ],
            'object' => $this->readModule($opts),
            'context' => [
                'contextActivities' => [
                    'grouping' => [
                        $this->readCourse($opts),
                        /*
                        { Sco launched
                           "id":"http://adlnet.gov/courses/compsci/CS204/lesson01/01?attemptId=50fd6961-ab6c-4e75-e6c7-ca42dce50dd6",
                           "definition":{
                              "name":{
                                 "en-US":"Attempt of CS204 lesson 01"
                              },
                              "description":{
                                 "en-US":"The activity representing an attempt of lesson 01 in the course CS204"
                              },
                              "type": "http://adlnet.gov/expapi/activities/attempt"
                           }
                        }
                        */
                    ],
                ],
            ],
        ]);
    }
}
