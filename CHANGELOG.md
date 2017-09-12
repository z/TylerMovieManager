##  0.7.0 / 2017-09-11

### Changed

* Upgraded Laravel from 5.3 to 5.4

##  0.6.5 / 2017-09-09

### Changed
* Made TMDB the new source of posters (Guidebox has gone commercial-only as of now)
* Updated dependencies

### Added
* TMDB as a source of posters

##  0.6.4 / 2016-12-06

### Changed
* created a dark theme

### Added
* fancier dropdowns and checkboxes

##  0.6.3 / 2016-12-05

### Added
* Better add/edit form layout and star ratings UI

##  0.6.2 / 2016-12-05

### Changed
* Add and remove movies in the DOM without needing to poll the server again

##  0.6.1 / 2016-12-05

### Fixed
* Fixed bug where user couldn't add movies if they didn't already have one

### Added
* Style updates to bring icons to card action menu
* Auth middleware on web route for user-restricted pages

##  0.6.0 / 2016-12-04

### Added
* Integrated [Guidebox](https://api.guidebox.com/apidocs#movies)
* Added guzzle cache middleware using redis to cache guidebox requests 

##  0.5.0 / 2016-12-04

### Added
* CRUD exposed in the GUI
* git post-receive hook for deployment

##  0.4.1 / 2016-12-04

### Added
* Movie list page basics with sorting / filtering
* animate.css is now included

##  0.4.0 / 2016-12-03

### Added
* Basic front-end design
* Dedicated oauth page

##  0.3.2 / 2016-12-03

### Added
* Xdebug is now enabled by default

##  0.3.1 / 2016-12-03

### Added
* Database Seeder

##  0.3.0 / 2016-12-03

### Added
* token based auth (less secure)
* Introduced basic CRUD Movie + Format resources
* Added postman collection for REST endpoints in `extra`

##  0.2.0 / 2016-12-03

### Added
* Passport integration for oauth
* Database migrations
* Front-end build tasks

### Changed
* Switched to node base docker image, which is still based on debian

##  0.1.0 / 2016-12-02

### Added
* Setup development environment with docker, mariadb and nginx
* Generated a base application using Laravel