#!/bin/bash
cd docs
composer install
cd ..
rm -f docs/*.md
vendor/bin/phpdoc -c phpdoc.xml && docs/vendor/bin/phpdocmd data/output/structure.xml docs
rm -rf data
