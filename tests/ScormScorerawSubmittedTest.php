<?php namespace XREmitter\Tests;
use \XREmitter\Events\ScormScorerawSubmitted as Event;

class ScormScorerawSubmittedTest extends EventTest {
    protected static $recipe_name = 'scorm_scoreraw_submitted';

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
            $this->constructScormTracking(),
            $this->constructScormScoes()
        );
    }

    protected function assertOutput($input, $output) {
        parent::assertOutput($input, $output);
        $this->assertVerb('http://adlnet.gov/expapi/verbs/completed', 'completed', $output['verb']);
        $this->assertObject('module', $input, $output['object']);
        $this->assertObject('course', $input, $output['context']['contextActivities']['grouping'][1]);
        $this->assertObject('scorm_scoes', $input, $output['context']['contextActivities']['grouping'][2]);
        $this->assertEquals($input['scorm_score_raw'], $output['result']['score']['raw']);
        $this->assertEquals($input['scorm_score_min'], $output['result']['score']['min']);
        $this->assertEquals($input['scorm_score_max'], $output['result']['score']['max']);
        $this->assertEquals($input['scorm_score_scaled'], $output['result']['score']['scaled']);
        $this->assertEquals($input['scorm_status'], $output['verb']['display']['en']);
    }
}
