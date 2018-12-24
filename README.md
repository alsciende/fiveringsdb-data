FiveRingsDB cards JSON data [![Build status](https://travis-ci.org/Alsciende/fiveringsdb-data.svg?branch=master)](https://travis-ci.org/Alsciende/fiveringsdb-data)
=========

This repository contains the game data used by [FiveRingsDB](https://fiveringsdb.com). The data is stored in JSON files under the directory `json/`.

The project also contains a Symfony project you can use to validate or generate the data.

## Installation

```
composer install
```

## Data Validation

To validate the data, execute:
 ```
 bin/console app:data:import
 ```
 No output means that all checks have passed successfully. Use the verbose options to see more info.
 
## Data Generation

### Card Data Generation
 
To generate a card, execute:
```
bin/console app:generate:card
``` 
The file is generated in `json/Card/`.

### Pack Data Generation

To generate a pack, execute: 
```
bin/console app:generate:pack {id} {position} {size} [{ffg-id}]
``` 
The file is generated in `json/PackCard/`.

## Contributing

All contributions are welcome. See [CONTRIBUTING](./CONTRIBUTING.md) for details on how.