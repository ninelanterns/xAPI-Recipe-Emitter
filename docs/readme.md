## Installation and Upgrading
You'll need to install [Composer](https://getcomposer.org/) first.

- Install with `composer require learninglocker/xapi-recipe-emitter`.
- Update with `composer update learninglocker/xapi-recipe-emitter`.


## Supported Events
Mapping for recipe names to recipe classes can be found in the [Controller](../src/Controller.php).

Recipe Name | Recipe Class | Test | Example
--- | --- | --- | ---
course_viewed | [CourseViewed](../src/Events/CourseViewed.php) | [CourseViewedTest](../tests/CourseViewedTest.php) | [CourseViewed](/examples/CourseViewed.json)
module_viewed | [ModuleEvent](../src/Events/ModuleViewed.php) | [ModuleEventTest](../tests/ModuleViewedTest.php) | [CourseViewed](/examples/ModuleViewed.json)
attempt_started | [AttemptStarted](../src/Events/AttemptStarted.php) | [AttemptStartedTest](../tests/AttemptStartedTest.php) | [CourseViewed](/examples/AttemptStarted.json)
attempt_completed | [AttemptCompleted](../src/Events/AttemptCompleted.php) | [AttemptCompletedTest](../tests/AttemptCompletedTest.php) | [CourseViewed](/examples/AttemptCompleted.json)
user_loggedin | [UserLoggedin](../src/Events/UserLoggedin.php) | [UserLoggedinTest](../tests/UserLoggedinTest.php) | [CourseViewed](/examples/UserLoggedin.json)
user_loggedout | [UserLoggedout](../src/Events/UserLoggedout.php) | [UserLoggedoutTest](../tests/UserLoggedoutTest.php) | [CourseViewed](/examples/UserLoggedout.json)
assignment_graded | [AssignmentGraded](../src/Events/AssignmentGraded.php) | [AssignmentGradedTest](../tests/AssignmentGradedTest.php) | [CourseViewed](/examples/AssignmentGraded.json)
assignment_submitted | [AssignmentSubmitted](../src/Events/AssignmentSubmitted.php) | [AssignmentSubmittedTest](../tests/AssignmentSubmittedTest.php) | [CourseViewed](/examples/AssignmentSubmitted.json)
