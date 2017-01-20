[![Build Status](https://travis-ci.org/adeira/connector.svg?branch=master)](https://travis-ci.org/adeira/connector)

```
curl -XPOST -H "Content-Type:application/graphql" -d '{"query": "mutation {login(username:\"test\",password:\"test\"){id,token}}"}' http://adeira.loc/graphql | jq .

curl -XPOST -H "Content-Type:application/graphql" -d '{"query": "query {device(id:\"123\"){id,name}}"}' http://adeira.loc/graphql | jq .
```

Install dependencies:
```
composer install
```

Run tests:
```
tests/run
```

Structuring Code in Modules
---
Every module is divided into three main parts: Domain code, Infrastructure code and the Application layer according to DDD in PHP suggestions.

> Domain holds all the Domain code, and Infrastructure holds the Infrastructure layer, thereby isolating all the Domain logic from the details of the Infrastructure layer.

In Domain subfolder there should be only files related to the **Domain concerns** (not Technical concerns). Good example may be `Order`, `OrderLine`, `OrderLineWasAdded`, `OrderRepository`, `OrderWasCreated` and so on. On the other hand Infrastructure should take care about **Technical concerns** (not Domain concerns) so for example `DoctrineOrderRepository` or `RedisOrderRepository`.
