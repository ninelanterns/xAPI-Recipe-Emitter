<?php namespace XREmitter\Tests;
use \XREmitter\Events\AssignmentGraded as Event;

class AssignmentGradedTest extends EventTest {
    protected static $recipe_name = 'assignment_graded';

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
            $this->contructObject('course'),
            $this->contructObject('module'),
            $this->constructUser('graded_user'),
            ['grade_result' => 1]
        );
    }

    protected function assertOutput($input, $output) {
        $this->assertUser($input, $output['actor'], 'graded_user');
        $this->assertObject('app', $input, $output['context']['contextActivities']['grouping'][0]);
        $this->assertObject('source', $input, $output['context']['contextActivities']['category'][0]);
        $this->assertLog($input, $output);
        $this->assertInfo(
            $input['context_info'],
            $output['context']['extensions']['http://lrs.learninglocker.net/define/extensions/info']
        );
        $this->assertValidXapiStatement($output);
        $this->assertVerb('http://adlnet.gov/expapi/verbs/scored', 'recieved grade for', $output['verb']);
        $this->assertObject('module', $input, $output['object']);
        $this->assertObject('course', $input, $output['parent'][0]);
        $this->assertEquals($input['grade_result'], $output['result']['score']['raw']);
        $this->assertEquals(true, $output['result']['completion']);
        $this->assertUser($input, $output['context']['instructor'], 'user');
    }
}
