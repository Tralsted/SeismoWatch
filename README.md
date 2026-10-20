# School project
### Draw a graph based on data collected from an API.
I chose to draw a graph based on earthquakes, so the data is pulled from the earthquake.usgs.gov site.

##### Installation and setup:
$ git clone or unzip
$ cd seismowatch
$ composer install
$ npm install

2. setup environment

$ cp .env.example .env
$ php artisan key:generate

3. database setup (make sure your .env file matches the db you want to use)

$ php artisan migrate

Now if you want a manual fetch of data into the db do:

$ php artisan app:fetch-earthquakes

Otherwise in another window:

$ php artisan schedule:work

Then finally, when ready:

$ composer run dev

Open your browser and go to http://localhost:8000
