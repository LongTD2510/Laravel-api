dev: 
	 php artisan migrate
	 php artisan db:seed
	 php artisan passport:install
	 php artisan passport:keys
	 php artisan passport:client --password