<?php
/**
 * Created by PhpStorm.
 * User: lee.kirkland
 * Date: 5/2/2016
 * Time: 5:15 PM
 */

namespace XREmitter\Events;


/**
 * Class CourseCompleted
 * @package XREmitter\Events
 */
class CourseCompleted extends Event
{
    /**
     * Sets the language equivalent for completed. 
     * @var array
     */
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
        $data = array_merge_recursive(parent::read($opts), [
            'verb' => [
                'id' => 'http://adlnet.gov/expapi/verbs/completed',
                'display' => $this->readVerbDisplay($opts),
            ],
            'object' => $this->readCourse($opts),
        ]);
        
        // course completion should look at related user as the actor FHLHAS-497
        $data['actor'] = $this->readUser($opts, 'relateduser');
        
        return $data;
    }
}