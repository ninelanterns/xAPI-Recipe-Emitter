<?php
/**
 * Created by PhpStorm.
 * User: lee.kirkland
 * Date: 5/2/2016
 * Time: 4:52 PM
 */
namespace XREmitter\Tests;
use \XREmitter\Events\CourseCompleted as Event;

class CourseCompletedTest extends EventTest
{
    protected static $recipe_name = 'course_completed';

    /**
     * Sets up the tests.
     * @override EventTest
     */
    public function setup() {
        $this->event = new Event($this->repo);
    }
    protected function constructInput() {
        return array_merge(
            parent::constructInput(),
            $this->contructObject('course')
        );
    }

    protected function assertOutput($input, $output) {
        parent::assertOutput($input, $output);
        $this->assertVerb('http://adlnet.gov/expapi/verbs/completed', 'completed', $output['verb']);
        $this->assertObject('course', $input, $output['object']);
    }
}