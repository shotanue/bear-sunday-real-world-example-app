#!/usr/bin/env bash

docker container run --rm  multi-stage:test-package > res.txt

grep -sq "OK (" res.txt
if [[ $? -eq 0 ]]; then
  exit 0
fi

exit 1