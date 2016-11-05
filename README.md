[![Build Status](https://travis-ci.org/adeira/connector.svg?branch=master)](https://travis-ci.org/adeira/connector)

```
curl -XPOST -H "Content-Type:application/graphql" -d 'mutation DeviceMutation{device(id:"123"){id}}' http://localhost/adeira/connector/www/graphql
curl -XPOST -H "Content-Type:application/graphql" -d 'query GetDevice{device(id:"123"){id,name}}' http://localhost/adeira/connector/www/graphql
```

Deploy:
```
ansible-playbook ansible/deploy.yml
```

Install dependencies:
```
composer install
```

Run tests:
```
vendor/bin/run-tests tests/ -C
```

Structuring Code in Modules
---
Every module is divided into three main parts: Domain code, Infrastructure code and the Application layer according to DDD in PHP suggestions.

> Domain holds all the Domain code, and Infrastructure holds the Infrastructure layer, thereby isolating all the Domain logic from the details of the Infrastructure layer.

In Domain subfolder there should be only files related to the **Domain concerns** (not Technical concerns). Good example may be `Order`, `OrderLine`, `OrderLineWasAdded`, `OrderRepository`, `OrderWasCreated` and so on. On the other hand Infrastructure should take care about **Technical concerns** (not Domain concerns) so for example `DoctrineOrderRepository` or `RedisOrderRepository`.
