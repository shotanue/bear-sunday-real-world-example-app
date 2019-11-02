#!/usr/bin/env bash

docker image build --target=base-image --tag=multi-stage:base-image Conduit
docker image build --target=test-package --tag=multi-stage:test-package Conduit

TAG="docker.pkg.github.com/${{ github.repository }}/bear-sunday-real-world-example-app:${SHA}"
docker image build --target=ship --tag=${TAG} Conduit