# kaliana-indra-techtask-php

Loadsmile PHP technical task using ` Symfony micro framework `

## Objectives

Develop an API that provides a set of recipes for today Lunch menu based on the contents of the fridge.

## About the API

The API provide ` /lunch ` endpoint that return a ` JSON ` response of the recipes for today lunch based on the availability of ingredients in the fridge. The endpoint have an optional parameter ` todayDate ` which default value is set to today date (for development and testing purpose, the today date is set to "2019-03-10").

The recipes must be in sequence of: recipes which all of its ingredients are fresh (` Best Before ` date is greater than ` today ` date) and recipes in which at least one of its ingredient is less fresh (past its ` Best Before ` date but still within its ` Use By ` date)

### Example of use 1

By calling ` /lunch ` without any parameter, the user is getting an array of recipes that consists of (respectively): Recipe for "Hotdog", which all ingredients is fresh; and Recipe for "Ham and Cheese Toastie", which one of the ingredient is less fresh (Cheese, ` Best Before ` date is "2019-03-08" and ` Use By ` date is "2019-03-13").

