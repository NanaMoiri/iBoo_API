API DEVEOLPMENT CONCLUSIONS AND COMMENTS

Hi! My name is Gemma Gomez and I'm building this API for an iBoo technical test.
I must say that this is my first time with symfony and its ecosystem. So I spent some time getting familiar with this framework.

- Through the process I've encountered several issues with routing but I solved almost all of them. I tried to cover as much of the basics specs as I could.

- All the basic CRUD operations for an item work (search by uuid, add new products, edit products and delete them).

- In this API I'm using PUT method to edit the product data. We could use Patch method too, so the user wouldn't have to fill again all the data fields. 
But it's a bit more intrincated to make and I didn't have enough time to do that. So that's something that can be improved.

- I tried to make the search by free text but i couldn't make it work.

- Something else to improve could be create services to get a more clean ProductsController code.

FRONT-END

- I could not finish the front-end part cause I was more focused on the back-end functionalities, so I did something very simple to at least visualize the results of the Get methods.

CREATE THE DATABASE
- Create the db using: php bin/console doctrine:database:create

- Creating entities: php bin/console make:entity

- Generate migrations: php bin/console make:migration
then use: php bin/console doctrine:migrations:migrate