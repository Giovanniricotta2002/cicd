FROM python:3.13.0a4-slim-bullseye

ENV FILE=*
ENV WORKDIR="/dev/test"


RUN pip install virtualenv && \
    virtualenv omdevtools && . omdevtools/bin/activate && \
    apt-get update && apt-get install -y lsb-release wget python3-dev libpq-dev && \
    sh -c 'echo "deb http://apt.postgresql.org/pub/repos/apt $(lsb_release -cs)-pgdg main" > /etc/apt/sources.list.d/pgdg.list' && \
    echo '#!/bin/bash \n \
    . omdevtools/bin/activate && pip install gcc7 && \
    pip install -r ${WORKDIR}/${REQUIREMENTFILE} \n \
    robot $FILE' >> startTest.sh && \
    chmod +x startTest.sh

WORKDIR /dev/test