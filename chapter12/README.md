## Chapter 12: HATEOAS

This is sample code for Chapter 12 of the book [Build APIs You Won't Hate][].

    $ php artisan migrate
    $ php artisan db:seed
    $ ./run-demo.sh
    PHP 5.5.6 Development Server started at Tue Dec 10 23:30:32 2013
    Listening on http://localhost:5000
    Document root is /some/place/chapter6/public
    Press Ctrl-C to quit.

Open your browser and go to `http://localhost:5000/users` to see [Fractal][] running in all its glory. Well... 
some of its glory. It can do a lot more than just type cast an array.

[Build APIs You Won't Hate]: http://leanpub.com/build-apis-you-wont-hate
[Fractal]: https://github.com/thephpleague/fractal
