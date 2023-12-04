#!/bin/bash

###!/usr/bin/env bash

TEMPLATE_DIR=/etc/php/template.d

# Launch the process
/usr/local/bin/dockerize ${DOCKERIZE_ARGS} $@
