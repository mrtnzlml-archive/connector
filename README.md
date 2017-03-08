[![Build Status](https://travis-ci.org/adeira/connector.svg?branch=master)](https://travis-ci.org/adeira/connector)

This is backend GraphQL API server for [adeira/connector-frontend](https://github.com/adeira/connector-frontend) written in Nette Framework.

If you want to play with the API from the CLI you should first create database and create new user account. There is database dump in `migrations/structure.sql` (PostgreSQL) or you can use command `bin/console o:s:c`. Create new user with command `bin/console a:u:c <login> <pass>`. It should return green message with UUID. Please save this UUID for later usage.

Now you are ready for testing GraphQL API. Try it using your UUID (returned in previous step):

    bin/console a:g:q f3cd1f41-42eb-4234-95d2-e89933c2552a

It should return something like this:

    {
      "data": {
        "allQueries": {
          "queries": [ ... ]
        }
      }
    }

Now you can query this API:

    bin/console a:g:q f3cd1f41-42eb-4234-95d2-e89933c2552a -g '{allWeatherStations{weatherStations{id,name}}}'

But as you can see it can be quite long and not really readable. Create file `test.graphql` in root of this project and write there this query:

    {
        allWeatherStations {
            weatherStations {
                id
                name
            }
        }
    }

And use `-f` option:

    bin/console a:g:q f3cd1f41-42eb-4234-95d2-e89933c2552a -f test.graphql

## Working with UUID

    vendor/bin/uuid
    vendor/bin/uuid generate 4
    vendor/bin/uuid decode 4b56376a-19f7-4f98-a610-62ded75ea486

## Running tests

    tests/run

Or alternatively with all checks:

    bin/ci

Have fun! :)
