#!/bin/bash

../vendor/bin/openapi --bootstrap ./swagger-variables.php --output ../public/swagger/swagger.yaml ./swagger-v1.php ../app/Http/Controllers/
