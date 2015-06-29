<?php namespace XREmitter\Events;

class DiscussionViewed extends Viewed {
    /**
     * Reads data for an event.
     * @param [String => Mixed] $opts
     * @return [String => Mixed]
     * @override Event
     */
    public function read(array $opts) {
        return array_merge_recursive(parent::read($opts), [
            'object' => $this->readDiscussion($opts, 'discussion', 'http://adlnet.gov/expapi/activities/interaction'),
            'context' => [
                'contextActivities' => [
                    'grouping' => [
                        $this->readModule($opts, 'module', 'http://adlnet.gov/expapi/activities/module'),
                    ],
                ],
            ],
        ]);
    }
}