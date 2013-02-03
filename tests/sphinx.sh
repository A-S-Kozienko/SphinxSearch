#!/bin/bash

SPHINX_DIR='/tmp/sphinxsearch'
DATA_DIR=${SPHINX_DIR}'/data'
PID_FILE=${SPHINX_DIR}'/searchd.pid'
SPHINX_CONFIG='tests/sphinx.conf'

#create dirs
mkdir -p ${DATA_DIR}

stop()
{
    #kill sphinx
    if [ -f ${PID_FILE} ]; then
        PID=`cat ${PID_FILE}`
        if [ -n "${PID}" ]; then
            kill -9 ${PID}
        fi
    fi
}

index()
{
    #create index
    indexer --all --config ${SPHINX_CONFIG}
}

start()
{
    #start sphinx
    searchd --config ${SPHINX_CONFIG}
}

case "$1" in
    start)
        stop
        index
        start
        ;;
    stop)
        stop
        ;;
    *)
        echo "Usage: sphinx.sh {start|stop}" >&2
        exit 1
        ;;
esac

exit 0
