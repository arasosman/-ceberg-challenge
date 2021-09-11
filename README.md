##Iceberg Digital Challenge


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