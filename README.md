# Project Name - LMS Marketplace

## Group Name - Ascended

| Student Name |      ID       |
|--------------|---------------|
| Radee Al-Mahmood | 1711194042 |
| Rafid Hasan | 2013013642 |

## Strategy Pattern

The strategy pattern will handle the user registration role selection. While this is may be an unusual use-case, if the project starts including a lot of people to work on the site, such as marketers, content publishers, managers, etc. We need to add new roles which would be simplified greatly by the strategy pattern.

## Singleton Pattern

Used to manage the database config. Very usual use-case. The connection is not thread safe, but in its current iteration, the project will not make use of async or thread calls.

## Observer Pattern

Notification and Enrollment management handled in the Enrollment model. It will notify both the instructor and the learner upon enrollment. It will also handle the enrollment into the course.

## Factory Pattern

Factory pattern used in the course model to determine what kind of course we want to build. The three options are Text, Live, and Video.

## Decorator Pattern

In the course class. We are using the decorator to add lessons, quizzes, assignments. This actually is a good and practical use of a design pattern as we can use this to scale the application since we may add more "Topics" or "Topic types" to the courses in the future.

## Builder Pattern

Finally found a way to use the builder pattern. Use it instead of the constructor of the course class. This way if we add new course types in the future, then we can easily create a builder for that course.

## Design Pattern Implementation Completed

Upto this point in the project, we have completed the design pattern implementation.