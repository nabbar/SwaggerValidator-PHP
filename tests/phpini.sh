#!/usr/bin/env bash

grep max_execution_time -H /etc/php*/cli/php.ini
sed -i "s/^max_execution_time.*/max_execution_time = $1/" /etc/php*/cli/php.ini
grep max_execution_time -H /etc/php*/cli/php.ini
