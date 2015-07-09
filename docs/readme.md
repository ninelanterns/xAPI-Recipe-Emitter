## Installation and Upgrading
You'll need to install [Composer](https://getcomposer.org/) first.

- Install with `composer require learninglocker/xapi-recipe-emitter`.
- Update with `composer update learninglocker/xapi-recipe-emitter`.


## Supported Events
Mapping for recipe names to recipe classes can be found in the [Controller](../src/Controller.php).

Recipe Name | Recipe Class | Test
--- | --- | ---
course_viewed | [CourseViewed](../src/events/CourseViewed.php) | [CourseViewedTest](../tests/CourseViewedTest.php)
module_viewed | [ModuleEvent](../src/events/ModuleViewed.php) | [ModuleEventTest](../tests/ModuleViewedTest.php)
attempt_started | [AttemptStarted](../src/events/AttemptStarted.php) | [AttemptStartedTest](../tests/AttemptStartedTest.php)
attempt_completed | [AttemptCompleted](../src/events/AttemptCompleted.php) | [AttemptCompletedTest](../tests/AttemptCompletedTest.php)
user_loggedin | [UserLoggedin](../src/events/UserLoggedin.php) | [UserLoggedinTest](../tests/UserLoggedinTest.php)
user_loggedout | [UserLoggedout](../src/events/UserLoggedout.php) | [UserLoggedoutTest](../tests/UserLoggedoutTest.php)
assignment_graded | [AssignmentGraded](../src/events/AssignmentGraded.php) | [AssignmentGradedTest](../tests/AssignmentGradedTest.php)
assignment_submitted | [AssignmentSubmitted](../src/events/AssignmentSubmitted.php) | [AssignmentSubmittedTest](../tests/AssignmentSubmittedTest.php)
discussion_viewed | [DiscussionViewed](../src/events/DicussionViewed.php) | [DiscussionViewedTest](../tests/DiscussionViewedTest.php)
