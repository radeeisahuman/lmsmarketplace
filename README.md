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