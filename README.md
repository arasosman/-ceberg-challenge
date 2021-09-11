## Iceberg Digital Challenge

Static code analysis and tests were given importance in the project.

### Postman Collection
    https://documenter.getpostman.com/view/5853137/U16kr53w

    also the collection has been added to the git repo. it is in the main directory.
### Test User
    {
        "email": "admin@test.com",
        "password": "123456"
    }

    
### Installation

    git clone https://github.com/arasosman/iceberg-challenge.git
	cd iceberg-challenge
	cp .env.example .env 
    composer install
    php artisan key:generate
    php artisan jwt:secret

### Migration
    php artisan migrate --seed

    project include dummy data

### Tests
    composer test

    if use windows exec this 
    composer test_windows

    test indcluded PhpCs, PhpMd and PhpUnit