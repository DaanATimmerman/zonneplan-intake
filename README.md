## Taskfile

This application is built with a Taskfile. The biggest reason to do so, is to make sure the project is always ran the same across different developers. To check all commands in the taskfile, run ``./Taskfile help``.

## Getting started

Start by running ``./Taskfile init``, this initializes the application and docker images.

After this finishes, the application is running on <a href="localhost">localhost</a>.

## General information

This applications retrieves data with Saloon. Jobs and commands have been set in place to fetch this information while developing, and to have data synchronisation using the scheduler.

To initialize the information run ``./Taskfile artisan app:get-electricity-price-history``. This fires the ``ImportAllElectricityPricesJob`` which fetches a year worth of data.

To get the current gas price, run ``./Taskfile artisan app:get-current-gas-price``. You can also tdo this for electricity with: ``./Taskfile artisan app:get-current-electricity-price``
