[![Build Status](https://travis-ci.org/adeira/connector.svg?branch=master)](https://travis-ci.org/adeira/connector)

This is backend GraphQL API server for [adeira/connector-frontend](https://github.com/adeira/connector-frontend) written in Nette Framework.

If you want to play with the API from the CLI you should first create database and create new user account. Create new database and migrate it to the latest version using command `bin/console migrations:continue`. Create new user with command `bin/console a:u:c <login> <pass>`. It should return green message with UUID.

There is only one endpoint URL address `/graphql`. Use tools like [GraphiQL](https://github.com/adeira/connector-graphiql) to run queries and mutations against this server.

## Working with CLI interface

    bin/console

## Working with UUID

    vendor/bin/uuid
    vendor/bin/uuid generate 4
    vendor/bin/uuid decode 4b56376a-19f7-4f98-a610-62ded75ea486

## Running tests

    tests/run

Or alternatively with all checks:

    bin/ci

Have fun! :)
