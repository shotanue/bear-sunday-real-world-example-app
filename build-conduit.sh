#!/usr/bin/env bash

docker image build --target=base-image --tag=multi-stage:base-image Conduit
docker image build --target=test-package --tag=multi-stage:test-package Conduit
docker image build --target=ship --tag=multi-stage:ship Conduit