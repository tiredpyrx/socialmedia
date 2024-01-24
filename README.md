# A Tiny Social Media Simulator

A tiny social media simulator that I devolop to learn and have fun 
\This is my 6st day in laravel yay

## [1.1.0] - 2024-01-24

### Added
- Displaying posts in global feed
- Displaying posts in user profile
- Displaying post images as slider
- Post active slide display in postbox
- Posts can be deleted
- Post author can edit post with a form modal
- Post customization options - hide likes from others -

- User can edit its profile
- Added optional gender choice
- Gender choices determines default profile pictures that users have
- Profiles can be deleted by auth
- Users can see a spesific profile
- Users post count can be seen in their profiles

- Alert messages and confirmations for high-risk conditions - e.g. deletion of profile - 


### Changed
- Posts can have multiple images now
- Profile settings is a hub page now


### Fixed
- Post and profile does not goes through validation
- Profile nicknames can be taken by multiple users
- Profile biography is limitless


## Install Instruction

- php artisan .env.example .env
- php artisan key:generate
- php artisan migrate
- php artisan serve

- npm install
- npm run dev
